<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
        $this->baseUrl = 'https://api.openai.com/v1/chat/completions';
    }

    public function generateChirps(): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->baseUrl, [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => 'Generate 3 example tweets in seperate messages with different levels of seriousness. Level 1 is humorous, Level 2 is neutral, Level 3 is serious.respond only with 3 messages separated by colon, example format: message1:message2:message3'],
            ],

        ]);

        return $response->json();
    }
}
