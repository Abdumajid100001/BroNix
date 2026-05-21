<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\Booking;
class PollController extends Controller
{
    public function show($token)
    {
        $poll = Poll::where('token', $token)->firstOrFail();
        return view('poll.vote', compact('poll'));
    }

    public function cast(Request $request, $token)
    {
        $poll = Poll::where('token', $token)->firstOrFail();

        if ($poll->is_booked) {
            return back()->with('error', 'Игра уже забронирована!');
        }

        // Увеличиваем счетчик
        $poll->increment('positive_votes');

        // Авто-бронирование
        if ($poll->positive_votes >= 10) {
            $poll->update(['is_booked' => true]);
            
            Booking::create([
                'business_id' => $poll->business_id,
                'status' => 'confirmed',
                'description' => 'Авто-бронирование через голосование'
            ]);
        }

        return back()->with('success', 'Твой голос принят!');
    }
}
