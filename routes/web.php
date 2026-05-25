<?php

use App\Http\Controllers\Admin\BusinessesController;
use App\Http\Controllers\Admin\BusinessesTypesController;
use App\Http\Controllers\AssistantMessageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Owner\BusinessesController as OwnerBusinessesController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Models\Booking;
use App\Models\Business;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;
use App\Http\Controllers\AiAnalysisController;

Route::get('/analytics', [AiAnalysisController::class, 'index'])->name('ai.analytics');

Route::post('/ai/compare-businesses', [AiAnalysisController::class, 'compare'])->name('ai.compare');Route::get('/owner/home', [OwnerDashboardController::class, 'index'])->name('owner.home');
Route::get('/owner/booking', [OwnerDashboardController::class, 'bookingsIndex'])->name('owner.booking');
Route::post('/api/ai/compare-businesses', [\App\Http\Controllers\AiAnalysisController::class, 'compare']);
Route::get('/vote/{token}', [PollController::class, 'show'])->name('poll.show');
Route::post('/vote/{token}', [PollController::class, 'cast'])->name('poll.cast');
Route::get('/api/booked-slots', [BookingController::class, 'getBookedSlots']);
Route::get('/booking/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.check');

Route::get('lang/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'ru', 'tj'])) session(['locale' => $lang]);
    return redirect()->back();
})->name('lang.switch');

Route::get('/', function () {
    $businesses = Business::with(['type', 'services', 'schedules'])->withCount('bookings')->latest()->get();
    $topBusinesses = $businesses->sortByDesc('bookings_count')->take(3)->values();
    $catalogPreview = $businesses->take(6)->values();
    
    $platformMetrics = [
        'businesses' => $businesses->count(),
        'services'   => $businesses->sum(fn ($b) => $b->services->count()),
        'bookings'   => Booking::count(),
    ];

    $categoryHighlights = $businesses->groupBy(fn ($b) => $b->type?->name ?? 'Без категории')->map(fn ($items, $name) => [
        'name' => $name, 'count' => $items->count()
    ])->sortByDesc('count')->take(4)->values();

    return view('public.layouts.app', compact('topBusinesses', 'catalogPreview', 'platformMetrics', 'categoryHighlights'));
})->name('home');

Route::get('/businesses', fn () => view('public.business', ['businesses' => Business::with(['type', 'services', 'schedules'])->latest()->get()]))->name('business.page');
Route::get('/booking', [BookingController::class, 'index'])->name('booking.page');
Route::get('/locale/{locale}', [LocaleController::class, 'update'])->name('locale.switch');
Route::post('/assistant/message', AssistantMessageController::class)->name('assistant.message');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/gemini-test', [TestController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}/payment', [BookingController::class, 'payment'])->name('booking.payment');
    Route::get('/dashboard', DashboardRedirectController::class)->name('dashboard');
    Route::get('/client/dashboard', ClientDashboardController::class)->middleware('role:user')->name('client.dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('owner')->name('owner.')->middleware(['role:owner|business'])->group(function () {
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
     
        Route::get('/bookings/data', [OwnerDashboardController::class, 'getBookingsJson'])->name('bookings.json');
        Route::post('/bookings/confirm/{id}', [OwnerDashboardController::class, 'confirmBooking'])->name('bookings.confirm');
        Route::post('/bookings/cancel/{id}', [OwnerDashboardController::class, 'cancelBooking'])->name('bookings.cancel');

        Route::get('/businesses/map', [OwnerBusinessesController::class, 'index'])->name('businesses.map');
        Route::get('/bookings', [OwnerDashboardController::class, 'bookingsIndex'])->name('bookings.index');
        Route::get('/dashboard/revenue-data/{period}', [OwnerDashboardController::class, 'getRevenueData'])->name('dashboard.revenue-data');
        Route::post('/notifications/read-all', [OwnerDashboardController::class, 'readAllNotifications'])->name('notifications.read-all');
        Route::get('/bookings/calendar', [OwnerDashboardController::class, 'calendar'])->name('bookings.calendar');
        Route::get('/bookings/day/{date}', [OwnerDashboardController::class, 'dayBookings'])->name('bookings.day');
        Route::get('/bookings/month/{year_month}', [OwnerDashboardController::class, 'monthBookings'])->name('bookings.month');
        Route::post('/bookings/store', [OwnerDashboardController::class, 'storeBooking'])->name('bookings.store');
        Route::post('/bookings/update-time/{id}', [OwnerDashboardController::class, 'updateBookingTime'])->name('bookings.updateTime');

        Route::resource('businesses', OwnerBusinessesController::class);
    });

    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        Route::get('/', fn () => view('admin.layouts.app'))->name('layouts.app');
        Route::resource('businesses', BusinessesController::class);
        Route::resource('businesses-types', BusinessesTypesController::class);
    });

    Route::redirect('/business/dashboard', '/owner/dashboard')->name('business.dashboard');
});

require __DIR__.'/auth.php';