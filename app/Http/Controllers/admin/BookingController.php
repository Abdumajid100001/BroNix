<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $status = trim((string) $request->query('status', ''));
        $query = trim((string) $request->query('q', ''));

        $bookingsQuery = Booking::query()
            ->with(['user', 'business', 'service', 'payment'])
            ->latest();

        if (in_array($status, ['pending', 'confirmed', 'cancelled'], true)) {
            $bookingsQuery->where('status', $status);
        }

        if ($query !== '') {
            $bookingsQuery->where(function ($builder) use ($query) {
                $builder
                    ->whereHas('user', function ($userQuery) use ($query) {
                        $userQuery
                            ->where('name', 'like', '%' . $query . '%')
                            ->orWhere('email', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('business', function ($businessQuery) use ($query) {
                        $businessQuery->where('name', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('service', function ($serviceQuery) use ($query) {
                        $serviceQuery->where('name', 'like', '%' . $query . '%');
                    });
            });
        }

        $bookings = $bookingsQuery->paginate(15)->withQueryString();

        $summary = [
            'all' => Booking::query()->count(),
            'pending' => Booking::query()->where('status', 'pending')->count(),
            'confirmed' => Booking::query()->where('status', 'confirmed')->count(),
            'cancelled' => Booking::query()->where('status', 'cancelled')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'summary', 'status', 'query'));
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', __('Статус бронирования обновлён.'));
    }
}
