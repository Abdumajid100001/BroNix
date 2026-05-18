<?php
namespace App\Http\Controllers;
use App\Services\GeminiService;

class TestController extends Controller
{
    public function index(GeminiService $gemini)
    {
        $result = $gemini->generateText("Объясни что такое Laravel");

        return response()->json([
            'response' => $result
        ]);
    }
}
