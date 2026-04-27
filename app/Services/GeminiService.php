<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected string $apiKey;
    protected string $url;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent";
    }

    public function generateText(string $prompt): string
    {
        $response = Http::post($this->url . "?key=" . $this->apiKey, [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->failed()) {
            throw new \Exception("Gemini API error: " . $response->body());
        }

        return $response->json('candidates.0.content.parts.0.text');
    }
}
