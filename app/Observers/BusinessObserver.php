<?php

namespace App\Observers;
use App\Models\Business;
use Illuminate\Support\Facades\Http;

class BusinessObserver
{
    public function created(Business $business): void
    {
        $text =
            "🆕 Новый бизнес:\n\n" .
            "🏢 Название: {$business->name}\n" .
            "📝 Описание: {$business->description}\n" .
            "📍 Адрес: {$business->address}\n" .
            "📞 Телефон: {$business->phone}\n" .
            "🏷 Тип: {$business->businesses_type_name}";

        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }
}
