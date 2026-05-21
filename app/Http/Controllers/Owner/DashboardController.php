<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Business; // Добавьте этот импорт!
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Отображение главной страницы дашборда владельца.
     */
    public function index(): View
    {
        $user = auth()->user();
        
        // Получаем все бизнесы пользователя
        $businesses = Business::where('user_id', $user->id)->get();
        $businessIds = $businesses->pluck('id');

        // 1. Статистика бронирований
        $stats = [
            'total_bookings'   => Booking::whereIn('business_id', $businessIds)->count(),
            'pending_bookings' => Booking::whereIn('business_id', $businessIds)->where('status', 'pending')->count(),
            'confirmed_today'  => Booking::whereIn('business_id', $businessIds)
                                        ->whereDate('booking_date', Carbon::today())
                                        ->where('status', 'confirmed')
                                        ->count(),
        ];

        // 2. Сбор данных для графика
        $daysOfWeekBookings = Booking::whereIn('business_id', $businessIds)
            ->whereMonth('booking_date', Carbon::now()->month)
            ->select(DB::raw('DAYOFWEEK(booking_date) as day_num'), DB::raw('count(*) as total'))
            ->groupBy('day_num')
            ->pluck('total', 'day_num')
            ->toArray();

        $chartData = [
            $daysOfWeekBookings[2] ?? 0, // Пн
            $daysOfWeekBookings[3] ?? 0, // Вт
            $daysOfWeekBookings[4] ?? 0, // Ср
            $daysOfWeekBookings[5] ?? 0, // Чт
            $daysOfWeekBookings[6] ?? 0, // Пт
            $daysOfWeekBookings[7] ?? 0, // Сб
            $daysOfWeekBookings[1] ?? 0, // Вс
        ];
        $chartLabels = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];

        // 3. Топ-3 популярные услуги
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

        // 4. Последние 4 записи для ленты активности
        $recentBookings = Booking::with(['service', 'user'])
            ->whereIn('business_id', $businessIds)
            ->latest()
            ->take(4)
            ->get();

        // Передаем переменную $businesses в compact
        return view('owner.dashboard', compact(
            'user', 
            'businesses', // <- ВАЖНО: передаем эту переменную
            'stats', 
            'chartLabels', 
            'chartData', 
            'topServices', 
            'recentBookings'
        ));
    }

    /**
     * AJAX-метод: Получить список бронирований на выбранный день.
     */
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

    /**
     * AJAX-метод: Подтвердить бронирование.
     */
    public function confirmBooking($id): JsonResponse
    {
        $user = auth()->user();
        $businessIds = $user->businesses()->pluck('id');
        $booking = Booking::whereIn('business_id', $businessIds)->find($id);

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Не найдено'], 404);
        }

        $booking->status = 'confirmed';
        $booking->save();

        return response()->json(['success' => true]);
    }

    /**
     * AJAX-метод: Отменить бронирование.
     */
    public function cancelBooking($id): JsonResponse
    {
        $user = auth()->user();
        $businessIds = $user->businesses()->pluck('id');
        $booking = Booking::whereIn('business_id', $businessIds)->find($id);

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Не найдено'], 404);
        }

        $booking->status = 'cancelled';
        $booking->save();

        return response()->json(['success' => true]);
    }

    /**
     * AJAX-метод: Получить массив дат для календаря.
     */
    public function monthBookings($year_month): JsonResponse
    {
        $user = auth()->user();
        $businessIds = $user->businesses()->pluck('id');

        try {
            $startOfMonth = Carbon::parse($year_month . '-01')->startOfMonth()->format('Y-m-d');
            $endOfMonth = Carbon::parse($year_month . '-01')->endOfMonth()->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Неверный формат'], 400);
        }

        $bookedDates = Booking::whereIn('business_id', $businessIds)
            ->whereBetween('booking_date', [$startOfMonth, $endOfMonth])
            ->pluck('booking_date') 
            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'))
            ->unique()
            ->values();

        return response()->json($bookedDates);
    }
}