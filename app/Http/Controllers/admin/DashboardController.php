<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Business;
use App\Models\BusinessesTypes;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'businesses' => Business::query()->count(),
            'types' => BusinessesTypes::query()->count(),
            'services' => Service::query()->count(),
            'bookings' => Booking::query()->count(),
            'pending_bookings' => Booking::query()->where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::query()->where('status', 'confirmed')->count(),
            'cancelled_bookings' => Booking::query()->where('status', 'cancelled')->count(),
            'users' => User::query()->count(),
            'admins' => User::role('admin')->count(),
            'owners' => User::role('owner')->count(),
            'clients' => User::role('user')->count(),
        ];

        $recentBookings = Booking::query()
            ->with(['user', 'business', 'service'])
            ->latest()
            ->take(6)
            ->get();

        $recentBusinesses = Business::query()
            ->with(['type', 'owner'])
            ->withCount('services')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentBusinesses'));
    }
}
