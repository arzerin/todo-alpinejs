<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class OpenAI extends BaseConfig
{
    public string $apiKey = '';
    public string $baseUrl = 'https://api.openai.com/v1';
    public string $model = 'gpt-5.6-terra';
    public int $timeout = 60;

    public function __construct()
    {
        parent::__construct();

        $this->apiKey = (string) env('OPENAI_API_KEY', '');
        $this->model = (string) env('OPENAI_MODEL', 'gpt-5.6-terra');
        $this->baseUrl = rtrim((string) env('OPENAI_BASE_URL', 'https://api.openai.com/v1'), '/');
        $this->timeout = (int) env('OPENAI_TIMEOUT', 60);
    }
}
