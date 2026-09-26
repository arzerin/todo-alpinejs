<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Models\TaskModel;
use App\Models\TaskCategoryModel;
use App\Services\ActivityService;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Task Manager Controller
 *
 * Handles:
 * - Dashboard data
 * - Project CRUD
 * - Category CRUD
 * - Task CRUD
 * - Markdown task import
 *
 * Import duplicate policy:
 * 1. Category uniqueness is checked inside the selected project by category name.
 * 2. Task uniqueness is checked by project_id + category_id + normalized body.
 * 3. Re-importing the same TASKS.md therefore does not create duplicate categories/tasks.
 */
class TaskManager extends BaseController
{
    protected ProjectModel $projects;
    protected TaskModel $tasks;
    protected TaskCategoryModel $categories;
    protected ActivityService $activity;

    public function __construct()
    {
        $this->projects   = new ProjectModel();
        $this->tasks      = new TaskModel();
        $this->categories = new TaskCategoryModel();
        $this->activity   = new ActivityService();
    }

    /**
     * Main Basecamp-style dashboard.
     */
    public function index()
    {
        return view('task_manager/dashboard');
    }

    /**
     * Standard JSON response.
     *
     * A fresh CSRF hash is returned so Alpine can keep making AJAX requests
     * when CI4 CSRF protection is enabled.
     */
    private function json(array $data, int $status = 200): ResponseInterface
    {
        $data['csrfHash'] = csrf_hash();

        return $this->response
            ->setStatusCode($status)
            ->setJSON($data);
    }

    /**
     * Read JSON request payload.
     */
    private function input(): array
    {
        return $this->request->getJSON(true) ?? [];
    }

    /**
     * Normalize text for duplicate comparison.
     *
     * We deliberately compare case-insensitively and collapse whitespace:
     *
     * "Build Login API"
     * " build   login api "
     *
     * are treated as the same task/category text.
     */
    /**
     * Normalize task priority to the values supported by the Phase 3 UI.
     */
    private function validPriority(?string $priority): string
    {
        $priority = strtolower(trim((string) $priority));

        return in_array($priority, ['low', 'normal', 'high', 'urgent'], true)
            ? $priority
            : 'normal';
    }

    private function normalizeText(?string $value): string
    {
        $value = trim((string) $value);
        $value = preg_replace('/\s+/u', ' ', $value) ?? $value;

        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * Load all dashboard data.
     *
     * Alpine filters categories/tasks for the currently selected project.
     */
    public function data(): ResponseInterface
    {
        $projects = $this->projects
            ->orderBy('name', 'ASC')
            ->findAll();

        $categories = $this->categories
            ->orderBy('project_id', 'ASC')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();

        $tasks = $this->tasks
            ->orderBy('completed', 'ASC')
            ->orderBy('id', 'DESC')
            ->findAll();

        return $this->json([
            'success'    => true,
            'projects'   => $projects,
            'categories' => $categories,
            'tasks'      => $tasks,
        ]);
    }

    // -------------------------------------------------------------------------
    // PROJECT CRUD
    // -------------------------------------------------------------------------

    public function createProject(): ResponseInterface
    {
        $data = $this->input();
        $name = trim((string) ($data['name'] ?? ''));

        if ($name === '') {
            return $this->json([
                'success' => false,
                'message' => 'Project name is required.',
            ], 422);
        }

        $id = $this->projects->insert([
            'name'  => $name,
            'color' => ($data['color'] ?? '') ?: null,
        ], true);

        if (!$id) {
            return $this->json([
                'success' => false,
                'message' => 'Unable to create project.',
            ], 500);
        }

        $project = $this->projects->find($id);

        $this->activity->log(
            (int) $id,
            'project.created',
            'created a project',
            'project',
            (int) $id,
            ['project' => $project['name'] ?? $name]
        );

        return $this->json([
            'success' => true,
            'project' => $project,
        ], 201);
    }

    public function updateProject(int $id): ResponseInterface
    {
        $before = $this->projects->find($id);

        if (!$before) {
            return $this->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 404);
        }

        $data   = $this->input();
        $update = [];

        if (array_key_exists('name', $data)) {
            $name = trim((string) $data['name']);

            if ($name === '') {
                return $this->json([
                    'success' => false,
                    'message' => 'Project name is required.',
                ], 422);
            }

            $update['name'] = $name;
        }

        if (array_key_exists('color', $data)) {
            $update['color'] = $data['color'] ?: null;
        }

        if ($update) {
            $this->projects->update($id, $update);
        }

        $project = $this->projects->find($id);

        if ($update) {
            $changes = [];
            foreach ($update as $field => $value) {
                if (($before[$field] ?? null) != $value) {
                    $changes[$field] = [
                        'from' => $before[$field] ?? null,
                        'to'   => $value,
                    ];
                }
            }

            if ($changes) {
                $this->activity->log(
                    (int) $id,
                    'project.updated',
                    'updated a project',
                    'project',
                    (int) $id,
                    [
                        'project' => $project['name'] ?? '',
                        'changes' => $changes,
                    ]
                );
            }
        }

        return $this->json([
            'success' => true,
            'project' => $project,
        ]);
    }

    public function deleteProject(int $id): ResponseInterface
    {
        $project = $this->projects->find($id);

        if (!$project) {
            return $this->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 404);
        }

        // Log before deletion. Depending on your FK policy, project deletion may
        // intentionally remove project-scoped history together with the project.
        $this->activity->log(
            (int) $id,
            'project.deleted',
            'deleted a project',
            'project',
            (int) $id,
            ['project' => $project['name'] ?? '']
        );

        // Categories/tasks are removed through the database FK cascade rules.
        $this->projects->delete($id);

        return $this->json([
            'success' => true,
        ]);
    }

    // -------------------------------------------------------------------------
    // CATEGORY CRUD
    // -------------------------------------------------------------------------

    public function createCategory(): ResponseInterface
    {
        $data      = $this->input();
        $projectId = (int) ($data['project_id'] ?? 0);
        $name      = trim((string) ($data['name'] ?? ''));

        if (!$this->projects->find($projectId)) {
            return $this->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 422);
        }

        if ($name === '') {
            return $this->json([
                'success' => false,
                'message' => 'Category name is required.',
            ], 422);
        }

        // Prevent duplicate category names inside the same project.
        foreach ($this->categories->where('project_id', $projectId)->findAll() as $category) {
            if ($this->normalizeText($category['name']) === $this->normalizeText($name)) {
                return $this->json([
                    'success' => false,
                    'message' => 'A category with this name already exists in this project.',
                ], 409);
            }
        }

        $maxSort = $this->categories
            ->where('project_id', $projectId)
            ->selectMax('sort_order')
            ->first();

        $sortOrder = ((int) ($maxSort['sort_order'] ?? 0)) + 10;

        $id = $this->categories->insert([
            'project_id' => $projectId,
            'name'       => $name,
            'sort_order' => $sortOrder,
        ], true);

        $category = $this->categories->find($id);

        $this->activity->categoryChanged(
            $projectId,
            'created',
            (int) $id,
            $category['name'] ?? $name
        );

        return $this->json([
            'success'  => true,
            'category' => $category,
        ], 201);
    }

    public function updateCategory(int $id): ResponseInterface
    {
        $category = $this->categories->find($id);

        if (!$category) {
            return $this->json([
                'success' => false,
                'message' => 'Category not found.',
            ], 404);
        }

        $data   = $this->input();
        $update = [];

        if (array_key_exists('name', $data)) {
            $name = trim((string) $data['name']);

            if ($name === '') {
                return $this->json([
                    'success' => false,
                    'message' => 'Category name is required.',
                ], 422);
            }

            foreach ($this->categories
                ->where('project_id', $category['project_id'])
                ->where('id !=', $id)
                ->findAll() as $otherCategory) {

                if ($this->normalizeText($otherCategory['name']) === $this->normalizeText($name)) {
                    return $this->json([
                        'success' => false,
                        'message' => 'A category with this name already exists in this project.',
                    ], 409);
                }
            }

            $update['name'] = $name;
        }

        if (array_key_exists('sort_order', $data)) {
            $update['sort_order'] = max(0, (int) $data['sort_order']);
        }

        if ($update) {
            $this->categories->update($id, $update);
        }

        $updatedCategory = $this->categories->find($id);

        if ($update) {
            $this->activity->categoryChanged(
                (int) $category['project_id'],
                'updated',
                (int) $id,
                $updatedCategory['name'] ?? $category['name']
            );
        }

        return $this->json([
            'success'  => true,
            'category' => $updatedCategory,
        ]);
    }

    public function deleteCategory(int $id): ResponseInterface
    {
        $category = $this->categories->find($id);

        if (!$category) {
            return $this->json([
                'success' => false,
                'message' => 'Category not found.',
            ], 404);
        }

        /*
         * FK should be:
         *
         * tasks.category_id
         *     REFERENCES task_categories(id)
         *     ON DELETE SET NULL
         *
         * Therefore deleting a category keeps its tasks and they appear under
         * "Uncategorized" in the Basecamp-style dashboard.
         */
        $this->activity->categoryChanged(
            (int) $category['project_id'],
            'deleted',
            (int) $id,
            $category['name']
        );

        $this->categories->delete($id);

        return $this->json([
            'success' => true,
        ]);
    }

    // -------------------------------------------------------------------------
    // TASK CRUD
    // -------------------------------------------------------------------------

    public function createTask(): ResponseInterface
    {
        $data       = $this->input();
        $projectId  = (int) ($data['project_id'] ?? 0);
        $categoryId = !empty($data['category_id'])
            ? (int) $data['category_id']
            : null;

        $body = trim((string) ($data['body'] ?? ''));

        if (!$this->projects->find($projectId)) {
            return $this->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 422);
        }

        if ($body === '') {
            return $this->json([
                'success' => false,
                'message' => 'Task description is required.',
            ], 422);
        }

        if ($categoryId !== null) {
            $category = $this->categories->find($categoryId);

            if (!$category || (int) $category['project_id'] !== $projectId) {
                return $this->json([
                    'success' => false,
                    'message' => 'Invalid task category.',
                ], 422);
            }
        }

        $id = $this->tasks->insert([
            'project_id'  => $projectId,
            'category_id' => $categoryId,
            'body'        => $body,
            'assignee'    => ($data['assignee'] ?? '') ?: null,
            'due_date'    => ($data['due_date'] ?? '') ?: null,
            'priority'    => $this->validPriority($data['priority'] ?? 'normal'),
            'completed'   => !empty($data['completed']) ? 1 : 0,
            'completed_at'=> !empty($data['completed']) ? date('Y-m-d H:i:s') : null,
        ], true);

        $task = $this->tasks->find($id);

        $this->activity->taskCreated(
            $projectId,
            $task
        );

        // If a task is created already completed, record that state transition too.
        if ((int) ($task['completed'] ?? 0) === 1) {
            $this->activity->taskCompleted(
                $projectId,
                $task
            );
        }

        return $this->json([
            'success' => true,
            'task'    => $task,
        ], 201);
    }

    public function updateTask(int $id): ResponseInterface
    {
        $task = $this->tasks->find($id);

        if (!$task) {
            return $this->json([
                'success' => false,
                'message' => 'Task not found.',
            ], 404);
        }

        $data   = $this->input();
        $update = [];

        if (array_key_exists('body', $data)) {
            $body = trim((string) $data['body']);

            if ($body === '') {
                return $this->json([
                    'success' => false,
                    'message' => 'Task description is required.',
                ], 422);
            }

            $update['body'] = $body;
        }

        if (array_key_exists('assignee', $data)) {
            $update['assignee'] = $data['assignee'] ?: null;
        }

        if (array_key_exists('due_date', $data)) {
            $update['due_date'] = $data['due_date'] ?: null;
        }

        if (array_key_exists('completed', $data)) {
            $update['completed'] = !empty($data['completed']) ? 1 : 0;
            $update['completed_at'] = $update['completed'] ? date('Y-m-d H:i:s') : null;
        }

        if (array_key_exists('priority', $data)) {
            $update['priority'] = $this->validPriority($data['priority']);
        }

        if (array_key_exists('category_id', $data)) {
            $categoryId = !empty($data['category_id'])
                ? (int) $data['category_id']
                : null;

            if ($categoryId !== null) {
                $category = $this->categories->find($categoryId);

                if (!$category || (int) $category['project_id'] !== (int) $task['project_id']) {
                    return $this->json([
                        'success' => false,
                        'message' => 'Invalid task category.',
                    ], 422);
                }
            }

            $update['category_id'] = $categoryId;
        }

        if ($update) {
            $this->tasks->update($id, $update);
        }

        $after = $this->tasks->find($id);

        if ($update) {
            // Completion/reopen is a first-class activity event.
            $wasCompleted = (int) ($task['completed'] ?? 0) === 1;
            $isCompleted  = (int) ($after['completed'] ?? 0) === 1;

            if (!$wasCompleted && $isCompleted) {
                $this->activity->taskCompleted(
                    (int) $after['project_id'],
                    $after
                );
            } elseif ($wasCompleted && !$isCompleted) {
                $this->activity->taskReopened(
                    (int) $after['project_id'],
                    $after
                );
            }

            // Store field-level changes for the Activity UI.
            $changes = [];

            foreach (['body', 'category_id', 'assignee', 'priority', 'due_date'] as $field) {
                if (($task[$field] ?? null) != ($after[$field] ?? null)) {
                    $changes[$field] = [
                        'from' => $task[$field] ?? null,
                        'to'   => $after[$field] ?? null,
                    ];
                }
            }

            if ($changes) {
                $this->activity->taskUpdated(
                    (int) $after['project_id'],
                    $after,
                    $changes
                );
            }
        }

        return $this->json([
            'success' => true,
            'task'    => $after,
        ]);
    }

    public function deleteTask(int $id): ResponseInterface
    {
        $task = $this->tasks->find($id);

        if (!$task) {
            return $this->json([
                'success' => false,
                'message' => 'Task not found.',
            ], 404);
        }

        $this->activity->taskDeleted(
            (int) $task['project_id'],
            $task
        );

        $this->tasks->delete($id);

        return $this->json([
            'success' => true,
        ]);
    }

    // -------------------------------------------------------------------------
    // MARKDOWN IMPORT
    // -------------------------------------------------------------------------

    /**
     * Import normalized Markdown tasks generated by dashboard.php.
     *
     * Expected JSON:
     *
     * {
     *   "project_id": 1,
     *   "tasks": [
     *      {
     *          "category": "Authentication",
     *          "body": "Build login API",
     *          "completed": false
     *      },
     *      {
     *          "category": "Authentication",
     *          "body": "Create users table",
     *          "completed": true
     *      }
     *   ]
     * }
     *
     * DUPLICATE PROTECTION
     * --------------------
     * Category:
     *     same project + normalized category name => reuse category.
     *
     * Task:
     *     same project + same category + normalized task body => skip task.
     *
     * Completion state is NOT part of duplicate identity. This means importing
     * the same task again as [x] will not create another row.
     */
    public function importTasks(): ResponseInterface
    {
        $data      = $this->input();
        $projectId = (int) ($data['project_id'] ?? 0);
        $incoming  = $data['tasks'] ?? [];

        if (!$this->projects->find($projectId)) {
            return $this->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 422);
        }

        if (!is_array($incoming) || !$incoming) {
            return $this->json([
                'success' => false,
                'message' => 'No tasks were supplied for import.',
            ], 422);
        }

        if (count($incoming) > 1000) {
            return $this->json([
                'success' => false,
                'message' => 'Maximum 1000 tasks can be imported at once.',
            ], 422);
        }

        $db = db_connect();
        $db->transStart();

        /*
         * Build an in-memory category lookup once.
         *
         * key = normalized category name
         * value = category ID
         */
        $categoryMap = [];

        foreach ($this->categories
            ->where('project_id', $projectId)
            ->findAll() as $category) {

            $categoryMap[$this->normalizeText($category['name'])] =
                (int) $category['id'];
        }

        /*
         * Determine next sort order for newly imported categories.
         */
        $maxSortRow = $this->categories
            ->where('project_id', $projectId)
            ->selectMax('sort_order')
            ->first();

        $nextSortOrder = ((int) ($maxSortRow['sort_order'] ?? 0)) + 10;

        /*
         * Existing task map.
         *
         * Duplicate identity:
         * category_id + normalized body
         *
         * category_id=0 represents Uncategorized.
         */
        $taskMap = [];

        foreach ($this->tasks
            ->where('project_id', $projectId)
            ->findAll() as $existingTask) {

            $categoryKey = (int) ($existingTask['category_id'] ?? 0);
            $bodyKey     = $this->normalizeText($existingTask['body']);

            $taskMap[$categoryKey . '|' . $bodyKey] =
                (int) $existingTask['id'];
        }

        $insertedTasks      = 0;
        $skippedTasks       = 0;
        $createdCategories  = 0;
        $reusedCategories   = 0;

        foreach ($incoming as $item) {

            $body = trim((string) ($item['body'] ?? ''));

            if ($body === '') {
                continue;
            }

            /*
             * tasks.body is VARCHAR(500).
             */
            if (mb_strlen($body, 'UTF-8') > 500) {
                $body = mb_substr($body, 0, 500, 'UTF-8');
            }

            $rawCategory = trim((string) ($item['category'] ?? ''));

            /*
             * "Uncategorized" from the browser is treated as NULL category.
             * It does not need a physical task_categories row.
             */
            $isUncategorized =
                $rawCategory === ''
                || $this->normalizeText($rawCategory) === 'uncategorized';

            $categoryId = null;

            if (!$isUncategorized) {

                if (mb_strlen($rawCategory, 'UTF-8') > 150) {
                    $rawCategory = mb_substr($rawCategory, 0, 150, 'UTF-8');
                }

                $categoryNameKey = $this->normalizeText($rawCategory);

                /*
                 * Reuse existing/imported category if already known.
                 */
                if (isset($categoryMap[$categoryNameKey])) {

                    $categoryId = $categoryMap[$categoryNameKey];
                    $reusedCategories++;

                } else {

                    /*
                     * Create category only once.
                     */
                    $categoryId = (int) $this->categories->insert([
                        'project_id' => $projectId,
                        'name'       => $rawCategory,
                        'sort_order' => $nextSortOrder,
                    ], true);

                    $categoryMap[$categoryNameKey] = $categoryId;

                    $nextSortOrder += 10;
                    $createdCategories++;
                }
            }

            /*
             * Prevent duplicate task.
             *
             * Same task text in DIFFERENT categories is allowed.
             * Same task text in SAME category is skipped.
             */
            $categoryKey = (int) ($categoryId ?? 0);
            $bodyKey     = $this->normalizeText($body);
            $duplicateKey = $categoryKey . '|' . $bodyKey;

            if (isset($taskMap[$duplicateKey])) {
                $skippedTasks++;
                continue;
            }

            $taskId = $this->tasks->insert([
                'project_id'  => $projectId,
                'category_id' => $categoryId,
                'body'        => $body,
                'assignee'    => null,
                'due_date'    => null,
                'priority'    => 'normal',
                'completed'   => !empty($item['completed']) ? 1 : 0,
                'completed_at'=> !empty($item['completed']) ? date('Y-m-d H:i:s') : null,
            ], true);

            /*
             * Immediately update map so duplicate lines INSIDE the same
             * TASKS.md file are also skipped.
             */
            $taskMap[$duplicateKey] = (int) $taskId;

            $insertedTasks++;
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->json([
                'success' => false,
                'message' => 'Import failed. Database changes were rolled back.',
            ], 500);
        }

        $this->activity->imported(
            $projectId,
            $insertedTasks,
            $skippedTasks
        );

        return $this->json([
            'success'            => true,
            'imported'           => $insertedTasks,
            'skipped_duplicates' => $skippedTasks,
            'categories_created' => $createdCategories,
            'categories_reused'  => $reusedCategories,
            'message'            => sprintf(
                '%d task(s) imported, %d duplicate task(s) skipped.',
                $insertedTasks,
                $skippedTasks
            ),
        ]);
    }
}
