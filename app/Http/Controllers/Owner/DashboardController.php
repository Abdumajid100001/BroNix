<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   
    public function index(): View
    {
        $user = auth()->user();
        $businessIds = $user->businesses()->pluck('id');

        $stats = [
            'total_bookings'   => Booking::whereIn('business_id', $businessIds)->count(),
            'pending_bookings' => Booking::whereIn('business_id', $businessIds)->where('status', 'pending')->count(),
            'confirmed_today'  => Booking::whereIn('business_id', $businessIds)
                                    ->whereDate('booking_date', Carbon::today())
                                    ->where('status', 'confirmed')
                                    ->count(),
        ];

        $daysOfWeekBookings = Booking::whereIn('business_id', $businessIds)
            ->whereMonth('booking_date', Carbon::now()->month)
            ->select(DB::raw('DAYOFWEEK(booking_date) as day_num'), DB::raw('count(*) as total'))
            ->groupBy('day_num')
            ->pluck('total', 'day_num')
            ->toArray();

        $chartData = [
            $daysOfWeekBookings[2] ?? 0,  
            $daysOfWeekBookings[3] ?? 0, 
            $daysOfWeekBookings[4] ?? 0, 
            $daysOfWeekBookings[5] ?? 0, 
            $daysOfWeekBookings[6] ?? 0, 
            $daysOfWeekBookings[7] ?? 0, 
            $daysOfWeekBookings[1] ?? 0, 
        ];
        $chartLabels = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];

        $topServices = Booking::whereIn('business_id', $businessIds)
            ->with('service')
            ->select('service_id', DB::raw('count(*) as count'))
            ->groupBy('service_id')
            ->orderBy('count', 'desc')
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'name'  => $item->service ? $item->service->name : 'Услуга удалена',
                    'count' => $item->count
                ];
            });

    
        $recentBookings = Booking::with(['service', 'user'])
            ->whereIn('business_id', $businessIds)
            ->latest()
            ->take(4)
            ->get();

        return view('owner.dashboard', compact('user', 'stats', 'chartLabels', 'chartData', 'topServices', 'recentBookings'));
    }

    
    public function dayBookings($date): JsonResponse
    {
        $user = auth()->user();
        $businessIds = $user->businesses()->pluck('id');

        try {
            $formattedDate = Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Неверный формат даты'], 400);
        }

        $bookings = Booking::with(['service', 'user'])
            ->whereIn('business_id', $businessIds)
            ->whereDate('booking_date', $formattedDate) 
            ->orderBy('start_time', 'asc')
            ->get();

        $formattedBookings = $bookings->map(function ($b) {
            return [
                'id'         => $b->id,
                'start_time' => $b->start_time ?? '--:--', 
                'service'    => $b->service ? $b->service->name : 'Без названия',
                'client'     => $b->user ? $b->user->name : 'Гость', 
                'status'     => $b->status ?? 'pending', 
            ];
        });

        return response()->json($formattedBookings);
    }

    
    public function confirmBooking($id): JsonResponse
    {
        $user = auth()->user();
        $businessIds = $user->businesses()->pluck('id');

        $booking = Booking::whereIn('business_id', $businessIds)->find($id);

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Бронирование не найдено или доступ запрещен'], 404);
        }

        if ($booking->status === 'confirmed') {
            return response()->json(['success' => true, 'message' => 'Уже подтверждено ранее']);
        }

        $booking->status = 'confirmed';
        $booking->save();

        return response()->json([
            'success' => true, 
            'message' => 'Бронирование успешно подтверждено!'
        ]);
    }

    
    public function cancelBooking($id): JsonResponse
    {
        $user = auth()->user();
        $businessIds = $user->businesses()->pluck('id');

        $booking = Booking::whereIn('business_id', $businessIds)->find($id);

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Бронирование не найдено или доступ запрещен'], 404);
        }

        if ($booking->status === 'cancelled') {
            return response()->json(['success' => true, 'message' => 'Уже отменено ранее']);
        }

        $booking->status = 'cancelled';
        $booking->save();

        return response()->json([
            'success' => true, 
            'message' => 'Бронирование успешно отменено!'
        ]);
    }

   
    public function monthBookings($year_month): JsonResponse
    {
        $user = auth()->user();
        $businessIds = $user->businesses()->pluck('id');

        try {
            $startOfMonth = Carbon::parse($year_month . '-01')->startOfMonth()->format('Y-m-d');
            $endOfMonth = Carbon::parse($year_month . '-01')->endOfMonth()->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Неверный формат месяца'], 400);
        }

        $bookedDates = Booking::whereIn('business_id', $businessIds)
            ->whereBetween('booking_date', [$startOfMonth, $endOfMonth])
            ->pluck('booking_date') 
            ->map(function($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->unique()
            ->values();

        return response()->json($bookedDates);
    }
}