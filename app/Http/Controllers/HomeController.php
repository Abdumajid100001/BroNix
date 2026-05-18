<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Business;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $businessCount = Business::count();
        $serviceCount = Service::count();
        $bookingCount = Booking::count();

        return view('home', [
            'businessCount' => $businessCount,
            'serviceCount' => $serviceCount,
            'bookingCount' => $bookingCount,
        ]);
    }
}
