<?php

namespace App\Services;

class ProjectIntelligenceService
{
    protected ProjectContextService $context;
    protected OpenAIService $openai;

    public function __construct()
    {
        $this->context = new ProjectContextService();
        $this->openai = new OpenAIService();
    }

    public function ask(int $projectId, string $question, ?int $actorId = null): array
    {
        $context = $this->context->build($projectId);

        $system = <<<'PROMPT'
You are a project intelligence assistant.
Answer only from the supplied project context.
If the context does not support an answer, explicitly say so.
Do not invent task status, people, deadlines, workload or project facts.
Return:
{
  "answer": "concise useful answer",
  "attention_task_ids": [],
  "people_ids": [],
  "follow_up_questions": []
}
PROMPT;

        return $this->openai->json(
            'project_question',
            $projectId,
            $system,
            $context,
            $question,
            $actorId
        );
    }

    public function brief(int $projectId, ?int $actorId = null): array
    {
        $context = $this->context->build($projectId);

        $system = <<<'PROMPT'
Create a concise project-manager briefing using only supplied context.
Separate observed facts from recommendations.
Do not invent dates, blockers, dependencies or causes.
Return:
{
  "headline": "",
  "summary": "",
  "facts": [],
  "risks": [],
  "recommended_focus": [],
  "attention_task_ids": []
}
PROMPT;

        return $this->openai->json(
            'project_brief',
            $projectId,
            $system,
            $context,
            'Prepare the current project briefing.',
            $actorId
        );
    }
}
