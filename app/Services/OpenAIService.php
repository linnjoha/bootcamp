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
        $states = ['funny', 'neutral', 'serious'];
        $responses = $this->generateTweetsForStates($states);
        return $responses;
    }


    public function generateTweet(string $state)
    {
        $prompt = "Generate a $state tweet, maximum length 255.";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->baseUrl, [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        if ($response->failed()) {
            throw new \Exception('OpenAI API request failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Generate tweets for multiple states.
     *
     * @param array $states
     * @return array
     */
    public function generateTweetsForStates(array $states): array
    {
        $responses = [];

        foreach ($states as $state) {
            try {
                $tweet = $this->generateTweet($state);
                $responses[$state] = $tweet;
            } catch (\Exception $e) {
                $responses[$state] = 'Error: ' . $e->getMessage();
            }
        }

        return $responses;
    }
}
