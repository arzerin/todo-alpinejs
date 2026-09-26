<?php

namespace App\Services;

use App\Models\AiSuggestionModel;

class AssignmentIntelligenceService
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

    public function recommend(int $projectId, string $taskText, ?int $actorId = null): array
    {
        $context = $this->context->build($projectId);

        $system = <<<'PROMPT'
You are a project assignment recommendation engine.
Never claim authority to assign employees. Produce suggestions for human review.

Selection precedence:
1. Explicitly named owner in the supplied task/context.
2. Project-specific responsibilities and role.
3. Global responsibilities and skills.
4. Project membership.
5. Current open workload as a balancing signal.

Only suggest people where ai_assignment_enabled=true.
Do not invent people, IDs, skills, deadlines or facts.
Return:
{
  "recommendations": [
    {
      "person_id": 123,
      "reason": "short evidence-based reason",
      "confidence": 0.0
    }
  ]
}
Maximum 3 recommendations, best evidence first.
PROMPT;

        $result = $this->openai->json(
            'assignment_recommendation',
            $projectId,
            $system,
            $context,
            $taskText,
            $actorId
        );

        $rows = [];
        foreach (($result['data']['recommendations'] ?? []) as $rec) {
            $personId = (int)($rec['person_id'] ?? 0);
            if (!$personId) continue;

            // Never trust a model-provided ID without validating it against context.
            $valid = false;
            foreach ($context['people'] as $person) {
                if ((int)$person['id'] === $personId && $person['ai_assignment_enabled']) {
                    $valid = true;
                    break;
                }
            }
            if (!$valid) continue;

            $suggestionId = $this->suggestions->insert([
                'ai_run_id' => $result['run_id'],
                'project_id' => $projectId,
                'suggestion_type' => 'assignee',
                'subject_type' => 'task_draft',
                'title' => mb_substr($taskText, 0, 500),
                'payload' => json_encode($rec, JSON_UNESCAPED_UNICODE),
                'confidence' => isset($rec['confidence']) ? max(0, min(1, (float)$rec['confidence'])) : null,
                'status' => 'proposed',
            ], true);

            $rec['suggestion_id'] = (int)$suggestionId;
            $rows[] = $rec;
        }

        return ['run_id'=>$result['run_id'], 'recommendations'=>$rows];
    }
}
