<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Models\TaskModel;
use App\Models\TaskCategoryModel;
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

    public function __construct()
    {
        $this->projects   = new ProjectModel();
        $this->tasks      = new TaskModel();
        $this->categories = new TaskCategoryModel();
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

        return $this->json([
            'success' => true,
            'project' => $this->projects->find($id),
        ], 201);
    }

    public function updateProject(int $id): ResponseInterface
    {
        if (!$this->projects->find($id)) {
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

        return $this->json([
            'success' => true,
            'project' => $this->projects->find($id),
        ]);
    }

    public function deleteProject(int $id): ResponseInterface
    {
        if (!$this->projects->find($id)) {
            return $this->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 404);
        }

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

        return $this->json([
            'success'  => true,
            'category' => $this->categories->find($id),
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

        return $this->json([
            'success'  => true,
            'category' => $this->categories->find($id),
        ]);
    }

    public function deleteCategory(int $id): ResponseInterface
    {
        if (!$this->categories->find($id)) {
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
            'completed'   => !empty($data['completed']) ? 1 : 0,
        ], true);

        return $this->json([
            'success' => true,
            'task'    => $this->tasks->find($id),
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

        return $this->json([
            'success' => true,
            'task'    => $this->tasks->find($id),
        ]);
    }

    public function deleteTask(int $id): ResponseInterface
    {
        if (!$this->tasks->find($id)) {
            return $this->json([
                'success' => false,
                'message' => 'Task not found.',
            ], 404);
        }

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
                'completed'   => !empty($item['completed']) ? 1 : 0,
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
