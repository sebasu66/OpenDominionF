<?php

namespace OpenDominion\Services\AI;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenAIChatService
{
    protected Client $client;
    protected string $apiKey;
    protected string $model;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiKey = config('services.openai.key', '');
        $this->model = 'gpt-3.5-turbo';
    }

    public function chat(array $messages): array
    {
        try {
            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $this->model,
                    'messages' => $messages,
                ],
                'timeout' => 10,
            ]);

            $data = json_decode((string) $response->getBody(), true);
            return $data['choices'][0]['message'] ?? ['role' => 'assistant', 'content' => ''];
        } catch (\Throwable $e) {
            Log::error('OpenAI error: ' . $e->getMessage());
            return ['role' => 'assistant', 'content' => 'Lo siento, hubo un error al comunicar con la IA.'];
        }
    }
}
