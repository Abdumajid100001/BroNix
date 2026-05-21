<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use Google\Cloud\AI\Gemini;

class AIConsultantController extends Controller
{
   public function analyze(Request $request)
    {
        $userQuestion = $request->input('question');

        // Подготавливаем базу для Gemini
        $businesses = Business::select('name', 'description', 'category', 'price_range', 'rating')
            ->where('is_active', true)
            ->get()
            ->map(function ($b) {
                return "- {$b->name} ({$b->category}): {$b->description}. Цена: {$b->price_range}, Рейтинг: {$b->rating}";
            })->implode("\n");

        $systemPrompt = "Ты — дружелюбный эксперт-консультант маркетплейса. Твой тон: современный, профессиональный, как у технического специалиста. 
        Вот список доступных бизнесов:
        {$businesses}
        
        Твоя задача: помогать пользователю выбирать бизнес из списка. Если ответа нет в базе — признайся в этом. Общайся на русском языке.";

        // Запрос к Gemini
        $result = Gemini::geminiModel(model: 'gemini-1.5-flash')->generateContent([
            $systemPrompt . "\n\nВопрос пользователя: " . $userQuestion
        ]);

        return response()->json([
            'answer' => $result->text()
        ]);
    }
}
