<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\Booking;

class BookingController extends Controller
{
    public function getBookedSlots(Request $request) 
{
    $bookedSlots = Booking::where('business_id', $request->business_id)
        ->where('booking_date', $request->date)
        ->where('status', '!=', 'cancelled')
        ->pluck('start_time')
        ->toArray();

    return response()->json(['booked_slots' => $bookedSlots]);
}
    public function index(Request $request)
    {
        // 1. Категории для левой панели вытаскиваем ВСЕГДА
        $types = BusinessType::withCount('businesses')->get();

        $selectedType = $request->query('type_id');
        $selectedBusiness = $request->query('business_id');

        $businesses = collect();
        $business = null;

        // 2. Логика для выбранного конкретного БИЗНЕСА (Шаг 3)
        if ($selectedBusiness) {
            $business = Business::with(['services', 'schedules', 'type'])
                ->findOrFail($selectedBusiness);

            // 🔥 ВОТ ОНО ИСПРАВЛЕНИЕ: Если type_id не передан в URL, но выбран бизнес, 
            // мы берём type_id прямо из этого бизнеса! Так левая колонка никогда не сломается.
            if (!$selectedType) {
                $selectedType = $business->business_type_id;
            }
        }

        // 3. БИЗНЕСЫ ПО КАТЕГОРИИ (Шаг 2)
        // Теперь это сработает и при прямом клике на категорию, и при открытом бизнесе
        if ($selectedType) {
            $businesses = Business::with(['services', 'schedules', 'type'])
                ->where('business_type_id', $selectedType)
                ->latest()
                ->get();
        }

        return view('public.booking', compact(
            'types',
            'businesses',
            'business',
            'selectedType',
            'selectedBusiness'
        ));
    }

    public function store(Request $request)
    {
        // В контроллере
if ($request->booking_date == date('Y-m-d') && $request->start_time < date('H:i')) {
    return back()->withErrors(['time' => 'Вы выбрали прошедшее время']);
}
        $request->validate([
            'business_id'  => 'required|exists:businesses,id',
            'service_id'   => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today', // Не даем бронировать прошедшие даты
            'start_time'   => 'required',
            'comment'      => 'nullable|string|max:1000',
        ]);

        // Создаем бронирование
        Booking::create([
            'user_id'      => auth()->id(),
            'business_id'  => $request->business_id,
            'service_id'   => $request->service_id,
            'booking_date' => $request->booking_date,
            'start_time'   => $request->start_time,
            'end_time'     => $request->start_time, // В будущем можно рассчитывать на основе длительности услуги
            'status'       => 'pending',
            'comment'      => $request->comment,
        ]);

        // После успешного бронирования лучше редиректить пользователя в его личный кабинет 
        // к списку броней, либо на страницу оплаты, но оставляем на твое усмотрение:
        return redirect()->back()->with('success', 'Бронирование успешно создано!');
    }
    
}