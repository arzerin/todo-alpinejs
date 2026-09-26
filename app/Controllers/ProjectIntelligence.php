<?php

namespace App\Controllers;

use App\Services\ProjectIntelligenceService;
use App\Services\AssignmentIntelligenceService;
use App\Services\TaskIntelligenceService;
use App\Models\AiSuggestionModel;

class ProjectIntelligence extends BaseController
{
    protected function jsonBody(): array
    {
        $data = $this->request->getJSON(true);
        return is_array($data) ? $data : [];
    }

    protected function actorId(): ?int
    {
        // Replace with your authenticated team-member mapping when available.
        $id = session()->get('team_member_id');
        return $id ? (int)$id : null;
    }

    public function ask($projectId)
    {
        try {
            $body = $this->jsonBody();
            $question = trim((string)($body['question'] ?? ''));
            if ($question === '') {
                return $this->response->setStatusCode(422)->setJSON(['error'=>'Question is required.']);
            }

            $result = (new ProjectIntelligenceService())
                ->ask((int)$projectId, $question, $this->actorId());

            return $this->response->setJSON([
                'ok'=>true,
                'run_id'=>$result['run_id'],
                'result'=>$result['data'],
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON(['error'=>$e->getMessage()]);
        }
    }

    public function brief($projectId)
    {
        try {
            $result = (new ProjectIntelligenceService())
                ->brief((int)$projectId, $this->actorId());

            return $this->response->setJSON([
                'ok'=>true,
                'run_id'=>$result['run_id'],
                'brief'=>$result['data'],
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON(['error'=>$e->getMessage()]);
        }
    }

    public function recommendAssignee($projectId)
    {
        try {
            $body = $this->jsonBody();
            $task = trim((string)($body['task'] ?? ''));
            if ($task === '') {
                return $this->response->setStatusCode(422)->setJSON(['error'=>'Task text is required.']);
            }

            $result = (new AssignmentIntelligenceService())
                ->recommend((int)$projectId, $task, $this->actorId());

            return $this->response->setJSON(['ok'=>true] + $result);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON(['error'=>$e->getMessage()]);
        }
    }

    public function breakdownTask($taskId)
    {
        try {
            $result = (new TaskIntelligenceService())
                ->breakdown((int)$taskId, $this->actorId());

            return $this->response->setJSON(['ok'=>true] + $result);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON(['error'=>$e->getMessage()]);
        }
    }

    public function acceptSubtasks($taskId)
    {
        try {
            $body = $this->jsonBody();
            $ids = array_values(array_unique(array_map('intval', $body['suggestion_ids'] ?? [])));

            $created = (new TaskIntelligenceService())
                ->acceptSubtasks((int)$taskId, $ids, $this->actorId());

            return $this->response->setJSON([
                'ok'=>true,
                'created_task_ids'=>$created,
                'created_count'=>count($created),
            ]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON(['error'=>$e->getMessage()]);
        }
    }

    public function reviewSuggestion($suggestionId)
    {
        try {
            $body = $this->jsonBody();
            $status = (string)($body['status'] ?? '');
            if (!in_array($status, ['accepted','rejected'], true)) {
                return $this->response->setStatusCode(422)->setJSON(['error'=>'Invalid review status.']);
            }

            $model = new AiSuggestionModel();
            $row = $model->find((int)$suggestionId);
            if (!$row) {
                return $this->response->setStatusCode(404)->setJSON(['error'=>'Suggestion not found.']);
            }

            $model->update((int)$suggestionId, [
                'status'=>$status,
                'reviewed_by'=>$this->actorId(),
                'reviewed_at'=>date('Y-m-d H:i:s'),
            ]);

            return $this->response->setJSON(['ok'=>true]);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setJSON(['error'=>$e->getMessage()]);
        }
    }
}
