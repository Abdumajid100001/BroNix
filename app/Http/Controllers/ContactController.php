<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $text = "
📩 Новое сообщение

👤 Имя: {$request->name}
📧 Email: {$request->email}
💬 Сообщение: {$request->message}
        ";

        Http::post(
            "https://api.telegram.org/bot".env('TELEGRAM_BOT_TOKEN')."/sendMessage",
            [
                'chat_id' => env('TELEGRAM_GROUP_CHAT_ID'),
                'text' => $text,
                'parse_mode' => 'HTML'
            ]
        );

        return back()->with('success', 'Message sent!');
    }
}
