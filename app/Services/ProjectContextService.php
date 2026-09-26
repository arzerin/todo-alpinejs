<?php

namespace App\Services;

use App\Models\ProjectModel;
use App\Models\TaskModel;
use App\Models\TaskCategoryModel;
use App\Models\TeamMemberModel;
use App\Models\ProjectMemberModel;
use App\Models\TaskAssignmentModel;

class ProjectContextService
{
    public function build(int $projectId): array
    {
        $projectModel = new ProjectModel();
        $taskModel = new TaskModel();
        $categoryModel = new TaskCategoryModel();
        $memberModel = new TeamMemberModel();
        $projectMemberModel = new ProjectMemberModel();
        $assignmentModel = new TaskAssignmentModel();

        $project = $projectModel->find($projectId);
        if (!$project) {
            throw new \RuntimeException('Project not found.');
        }

        $categories = $categoryModel->where('project_id', $projectId)
            ->orderBy('sort_order', 'ASC')->findAll();

        $tasks = $taskModel->where('project_id', $projectId)
            ->orderBy('completed', 'ASC')
            ->orderBy('due_date', 'ASC')
            ->findAll();

        $projectMembers = $projectMemberModel->where('project_id', $projectId)->findAll();
        $memberIds = array_values(array_unique(array_map(
            static fn($row) => (int) $row['team_member_id'],
            $projectMembers
        )));

        $people = [];
        if ($memberIds) {
            foreach ($memberModel->whereIn('id', $memberIds)->findAll() as $person) {
                $people[(int)$person['id']] = $person;
            }
        }

        $taskIds = array_map(static fn($t) => (int)$t['id'], $tasks);
        $assignments = $taskIds
            ? $assignmentModel->whereIn('task_id', $taskIds)->findAll()
            : [];

        $taskAssignees = [];
        $openLoad = [];
        foreach ($assignments as $a) {
            $tid = (int)$a['task_id'];
            $pid = (int)$a['team_member_id'];
            $taskAssignees[$tid][] = $pid;
        }

        foreach ($tasks as &$task) {
            $task['assignee_ids'] = $taskAssignees[(int)$task['id']] ?? [];
            if (!(bool)$task['completed']) {
                foreach ($task['assignee_ids'] as $personId) {
                    $openLoad[$personId] = ($openLoad[$personId] ?? 0) + 1;
                }
            }
        }
        unset($task);

        $membershipMap = [];
        foreach ($projectMembers as $membership) {
            $membershipMap[(int)$membership['team_member_id']] = $membership;
        }

        $peopleContext = [];
        foreach ($people as $id => $person) {
            $membership = $membershipMap[$id] ?? [];
            $peopleContext[] = [
                'id' => $id,
                'name' => $person['name'] ?? '',
                'job_title' => $person['job_title'] ?? '',
                'role_description' => $person['role_description'] ?? '',
                'skills' => $this->decodeList($person['skills'] ?? null),
                'responsibilities' => $this->decodeList($person['responsibilities'] ?? null),
                'ai_assignment_enabled' => (bool)($person['ai_assignment_enabled'] ?? true),
                'project_role' => $membership['role'] ?? '',
                'project_role_description' => $membership['role_description'] ?? '',
                'project_responsibilities' => $this->decodeList($membership['responsibilities'] ?? null),
                'open_task_count' => $openLoad[$id] ?? 0,
            ];
        }

        return [
            'project' => $project,
            'categories' => $categories,
            'tasks' => $tasks,
            'people' => $peopleContext,
            'generated_at' => date(DATE_ATOM),
        ];
    }

    protected function decodeList($value): array
    {
        if (!$value) return [];
        if (is_array($value)) return array_values($value);
        $decoded = json_decode((string)$value, true);
        if (is_array($decoded)) return array_values($decoded);
        return array_values(array_filter(array_map('trim', explode(',', (string)$value))));
    }
}
