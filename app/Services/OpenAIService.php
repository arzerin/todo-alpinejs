<?php

namespace App\Services;

use App\Models\AiRunModel;
use RuntimeException;

class OpenAIService
{
    protected \Config\OpenAI $config;
    protected AiRunModel $runs;

    public function __construct()
    {
        $this->config = config('OpenAI');
        $this->runs = new AiRunModel();
    }

    /**
     * Send a structured project-intelligence request through OpenAI Responses API.
     * The prompt requests JSON only; validate the returned structure in the caller.
     */
    public function json(
        string $feature,
        ?int $projectId,
        string $systemInstruction,
        array $context,
        string $userRequest,
        ?int $actorId = null
    ): array {
        if ($this->config->apiKey === '') {
            throw new RuntimeException('OPENAI_API_KEY is not configured.');
        }

        $runId = $this->runs->insert([
            'project_id' => $projectId,
            'actor_id' => $actorId,
            'feature' => $feature,
            'model' => $this->config->model,
            'status' => 'pending',
            'input_summary' => mb_substr($userRequest, 0, 2000),
        ], true);

        try {
            $payload = [
                'model' => $this->config->model,
                'instructions' => $systemInstruction,
                'input' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'input_text',
                                'text' => "PROJECT CONTEXT:\n"
                                    . json_encode($context, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
                                    . "\n\nREQUEST:\n" . $userRequest
                                    . "\n\nReturn valid JSON only. Do not wrap it in Markdown fences.",
                            ],
                        ],
                    ],
                ],
            ];

            $client = \Config\Services::curlrequest([
                'timeout' => $this->config->timeout,
                'http_errors' => false,
            ]);

            $response = $client->post($this->config->baseUrl . '/responses', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->config->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $status = $response->getStatusCode();
            $body = json_decode((string) $response->getBody(), true);

            if ($status < 200 || $status >= 300) {
                $message = $body['error']['message'] ?? ('OpenAI HTTP ' . $status);
                throw new RuntimeException($message);
            }

            $text = $this->extractOutputText($body);
            $decoded = json_decode($text, true);

            if (!is_array($decoded)) {
                throw new RuntimeException('OpenAI returned non-JSON output.');
            }

            $this->runs->update($runId, [
                'status' => 'completed',
                'response_id' => $body['id'] ?? null,
                'usage_input_tokens' => $body['usage']['input_tokens'] ?? null,
                'usage_output_tokens' => $body['usage']['output_tokens'] ?? null,
                'completed_at' => date('Y-m-d H:i:s'),
            ]);

            return [
                'run_id' => (int) $runId,
                'data' => $decoded,
                'response_id' => $body['id'] ?? null,
            ];
        } catch (\Throwable $e) {
            $this->runs->update($runId, [
                'status' => 'failed',
                'error_message' => mb_substr($e->getMessage(), 0, 10000),
                'completed_at' => date('Y-m-d H:i:s'),
            ]);
            throw $e;
        }
    }

    protected function extractOutputText(array $response): string
    {
        if (!empty($response['output_text']) && is_string($response['output_text'])) {
            return trim($response['output_text']);
        }

        $parts = [];
        foreach (($response['output'] ?? []) as $item) {
            foreach (($item['content'] ?? []) as $content) {
                if (($content['type'] ?? '') === 'output_text' && isset($content['text'])) {
                    $parts[] = $content['text'];
                }
            }
        }

        $text = trim(implode("\n", $parts));
        if ($text === '') {
            throw new RuntimeException('OpenAI response contained no output text.');
        }
        return $text;
    }
}
