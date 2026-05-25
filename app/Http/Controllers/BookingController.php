<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index(Request $request)
    {
     
        $types = BusinessType::withCount('businesses')->get();

        $selectedType = $request->query('type_id');
        $selectedBusiness = $request->query('business_id');

        $businesses = collect();
        $business = null;

        if ($selectedBusiness) {
            $business = Business::with(['services', 'schedules', 'type'])
                ->findOrFail($selectedBusiness);

            if (!$selectedType) {
                $selectedType = $business->business_type_id;
            }
        }
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
        $request->validate([
            'business_id'  => 'required|exists:businesses,id',
            'service_id'   => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today', // Не даем бронировать прошедшие даты
            'start_time'   => 'required',
            'comment'      => 'nullable|string|max:1000',
        ]);

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
        return redirect()->back()->with('success', 'Бронирование успешно создано!');
    }
}