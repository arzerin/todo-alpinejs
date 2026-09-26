<?php

namespace App\Services;

use App\Models\ActivityLogModel;

/**
 * ActivityService
 *
 * Central activity logger.
 *
 * IMPORTANT:
 * Controllers should call this service instead of inserting directly into
 * activity_logs. That keeps the audit vocabulary consistent and gives Phase 5
 * (Super Dashboard) a clean event stream to analyse.
 */
class ActivityService
{
    protected ActivityLogModel $activity;

    public function __construct()
    {
        $this->activity = new ActivityLogModel();
    }

    /**
     * Write one activity record.
     *
     * @param int|null    $projectId
     * @param string      $action       e.g. task.completed, category.created
     * @param string      $description  Human-readable fallback description
     * @param string|null $subjectType  task|category|person|schedule|project|import
     * @param int|null    $subjectId
     * @param array       $metadata     Structured details for UI/analytics
     * @param int|null    $actorId      team_members.id when available
     */
    public function log(
        ?int $projectId,
        string $action,
        string $description,
        ?string $subjectType = null,
        ?int $subjectId = null,
        array $metadata = [],
        ?int $actorId = null
    ): int|false {
        return $this->activity->insert([
            'project_id'   => $projectId,
            'actor_id'     => $actorId,
            'subject_type' => $subjectType,
            'subject_id'   => $subjectId,
            'action'       => $action,
            'description'  => $description,
            'metadata'     => $metadata ? json_encode($metadata, JSON_UNESCAPED_UNICODE) : null,
            'created_at'   => date('Y-m-d H:i:s'),
        ], true);
    }

    public function taskCreated(int $projectId, array $task, ?int $actorId = null): int|false
    {
        return $this->log(
            $projectId,
            'task.created',
            'created a task',
            'task',
            (int) $task['id'],
            [
                'task'        => $task['body'] ?? '',
                'priority'    => $task['priority'] ?? 'normal',
                'category_id' => $task['category_id'] ?? null,
                'due_date'    => $task['due_date'] ?? null,
            ],
            $actorId
        );
    }

    public function taskCompleted(int $projectId, array $task, ?int $actorId = null): int|false
    {
        return $this->log(
            $projectId,
            'task.completed',
            'completed a task',
            'task',
            (int) $task['id'],
            ['task' => $task['body'] ?? ''],
            $actorId
        );
    }

    public function taskReopened(int $projectId, array $task, ?int $actorId = null): int|false
    {
        return $this->log(
            $projectId,
            'task.reopened',
            'reopened a task',
            'task',
            (int) $task['id'],
            ['task' => $task['body'] ?? ''],
            $actorId
        );
    }

    public function taskDeleted(int $projectId, array $task, ?int $actorId = null): int|false
    {
        return $this->log(
            $projectId,
            'task.deleted',
            'deleted a task',
            'task',
            (int) ($task['id'] ?? 0),
            ['task' => $task['body'] ?? ''],
            $actorId
        );
    }

    public function taskUpdated(
        int $projectId,
        array $task,
        array $changes,
        ?int $actorId = null
    ): int|false {
        return $this->log(
            $projectId,
            'task.updated',
            'updated a task',
            'task',
            (int) $task['id'],
            [
                'task'    => $task['body'] ?? '',
                'changes' => $changes,
            ],
            $actorId
        );
    }

    public function assignmentChanged(
        int $projectId,
        int $taskId,
        string $taskBody,
        array $people,
        ?int $actorId = null
    ): int|false {
        return $this->log(
            $projectId,
            'task.assignees_changed',
            'changed task assignees',
            'task',
            $taskId,
            [
                'task'   => $taskBody,
                'people' => $people,
            ],
            $actorId
        );
    }

    public function categoryChanged(
        int $projectId,
        string $action,
        int $categoryId,
        string $categoryName,
        ?int $actorId = null
    ): int|false {
        return $this->log(
            $projectId,
            'category.' . $action,
            $action . ' a category',
            'category',
            $categoryId,
            ['category' => $categoryName],
            $actorId
        );
    }

    public function projectMembershipChanged(
        int $projectId,
        string $action,
        int $personId,
        string $personName,
        ?int $actorId = null
    ): int|false {
        return $this->log(
            $projectId,
            'person.' . $action,
            $action === 'added' ? 'added a person to the project' : 'removed a person from the project',
            'person',
            $personId,
            ['person' => $personName],
            $actorId
        );
    }

    public function scheduleChanged(
        ?int $projectId,
        string $action,
        int $eventId,
        string $title,
        array $metadata = [],
        ?int $actorId = null
    ): int|false {
        return $this->log(
            $projectId,
            'schedule.' . $action,
            $action . ' a schedule item',
            'schedule',
            $eventId,
            array_merge(['title' => $title], $metadata),
            $actorId
        );
    }

    public function imported(
        int $projectId,
        int $imported,
        int $skipped,
        ?int $actorId = null
    ): int|false {
        return $this->log(
            $projectId,
            'import.completed',
            'imported Markdown tasks',
            'import',
            null,
            [
                'imported' => $imported,
                'skipped'  => $skipped,
            ],
            $actorId
        );
    }
}
