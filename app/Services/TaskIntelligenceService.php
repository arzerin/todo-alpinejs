<?php

namespace App\Services;

use App\Models\AiSuggestionModel;
use App\Models\TaskModel;
use App\Models\TaskDependencyModel;

class TaskIntelligenceService
{
    protected ProjectContextService $context;
    protected OpenAIService $openai;
    protected AiSuggestionModel $suggestions;

    public function __construct()
    {
        $this->context = new ProjectContextService();
        $this->openai = new OpenAIService();
        $this->suggestions = new AiSuggestionModel();
    }

    public function breakdown(int $taskId, ?int $actorId = null): array
    {
        $tasks = new TaskModel();
        $task = $tasks->find($taskId);
        if (!$task) throw new \RuntimeException('Task not found.');

        $projectId = (int)$task['project_id'];
        $context = $this->context->build($projectId);

        $system = <<<'PROMPT'
You break a parent task into practical implementation subtasks for human review.
Do not create tasks yourself. Do not invent people or IDs.
Return:
{
  "summary": "one sentence",
  "subtasks": [
    {
      "title": "clear actionable task",
      "priority": "low|normal|high|urgent",
      "due_date": null,
      "suggested_person_id": null,
      "assignment_reason": "",
      "confidence": 0.0
    }
  ]
}
Use ISO YYYY-MM-DD dates only when the supplied context supports a date.
Prefer 3-8 useful subtasks. Avoid duplicates and vague administrative filler.
PROMPT;

        $result = $this->openai->json(
            'task_breakdown',
            $projectId,
            $system,
            $context,
            'Break down this task: ' . ($task['body'] ?? ''),
            $actorId
        );

        $saved = [];
        foreach (($result['data']['subtasks'] ?? []) as $row) {
            $title = trim((string)($row['title'] ?? ''));
            if ($title === '') continue;

            $id = $this->suggestions->insert([
                'ai_run_id' => $result['run_id'],
                'project_id' => $projectId,
                'suggestion_type' => 'subtask',
                'subject_type' => 'task',
                'subject_id' => $taskId,
                'title' => mb_substr($title, 0, 500),
                'payload' => json_encode($row, JSON_UNESCAPED_UNICODE),
                'confidence' => isset($row['confidence']) ? max(0, min(1, (float)$row['confidence'])) : null,
                'status' => 'proposed',
            ], true);
            $row['suggestion_id'] = (int)$id;
            $saved[] = $row;
        }

        return [
            'run_id' => $result['run_id'],
            'summary' => $result['data']['summary'] ?? '',
            'subtasks' => $saved,
        ];
    }

    public function acceptSubtasks(int $parentTaskId, array $suggestionIds, ?int $reviewerId = null): array
    {
        $tasks = new TaskModel();
        $suggestions = new AiSuggestionModel();

        $parent = $tasks->find($parentTaskId);
        if (!$parent) throw new \RuntimeException('Parent task not found.');

        $created = [];
        $db = db_connect();
        $db->transStart();

        foreach ($suggestionIds as $suggestionId) {
            $suggestion = $suggestions->find((int)$suggestionId);
            if (!$suggestion
                || $suggestion['suggestion_type'] !== 'subtask'
                || (int)$suggestion['subject_id'] !== $parentTaskId
                || $suggestion['status'] !== 'proposed') {
                continue;
            }

            $payload = json_decode($suggestion['payload'] ?? '{}', true) ?: [];
            $body = trim((string)($payload['title'] ?? $suggestion['title'] ?? ''));
            if ($body === '') continue;

            $taskId = $tasks->insert([
                'project_id' => (int)$parent['project_id'],
                'category_id' => $parent['category_id'] ?? null,
                'parent_task_id' => $parentTaskId,
                'body' => $body,
                'due_date' => $payload['due_date'] ?? null,
                'priority' => in_array(($payload['priority'] ?? 'normal'), ['low','normal','high','urgent'], true)
                    ? $payload['priority'] : 'normal',
                'completed' => 0,
                'source_type' => 'ai',
                'source_id' => (int)$suggestion['ai_run_id'],
                'ai_generated' => 1,
                'ai_reason' => $payload['assignment_reason'] ?? null,
            ], true);

            $suggestions->update((int)$suggestionId, [
                'status' => 'accepted',
                'reviewed_by' => $reviewerId,
                'reviewed_at' => date('Y-m-d H:i:s'),
            ]);

            $created[] = (int)$taskId;
        }

        $db->transComplete();
        if (!$db->transStatus()) throw new \RuntimeException('Could not create subtasks.');

        return $created;
    }
}
