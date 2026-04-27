<?php

use App\Http\Controllers\Admin\BusinessesController;
use App\Http\Controllers\AssistantMessageController;
use App\Http\Controllers\admin\BusinessesTypesController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Owner\BusinessesController as OwnerBusinessesController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\Booking;
use App\Models\Business;
use Illuminate\Support\Facades\Route;
//Wallet
Route::get('/wallet', function () {
    return view('public.wallet');
})->middleware('auth')->name('wallet');
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CardController;
Route::get('/gemini-test', [TestController::class, 'index']);
Route::middleware('auth')->group(function () {
    Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');
    Route::post('/cards', [CardController::class, 'store'])->name('cards.store');
});
Route::get('/locale/{locale}', [LocaleController::class, 'update'])->name('locale.switch');
Route::get('/', function () {
    $businesses = Business::with(['type', 'services', 'schedules'])
        ->withCount('bookings')
        ->latest()
        ->get();

    $topBusinesses = $businesses
        ->sort(function ($left, $right) {
            if ($left->bookings_count !== $right->bookings_count) {
                return $right->bookings_count <=> $left->bookings_count;
            }

            return $right->id <=> $left->id;
        })
        ->take(3)
        ->values();

    $catalogPreview = $businesses
        ->take(6)
        ->values();

    $platformMetrics = [
        'businesses' => $businesses->count(),
        'services' => $businesses->sum(fn ($business) => $business->services->count()),
        'bookings' => Booking::query()->count(),
    ];

    $categoryHighlights = $businesses
        ->groupBy(fn ($business) => $business->type?->name ?? __('��� ���������'))
        ->map(fn ($items, $name) => [
            'name' => $name,
            'count' => $items->count(),
            'services_count' => $items->sum(fn ($business) => $business->services->count()),
        ])
        ->sortByDesc('count')
        ->take(4)
        ->values();

    return view('public.layouts.app', compact('topBusinesses', 'catalogPreview', 'platformMetrics', 'categoryHighlights'));
})->name('home');
Route::post('/assistant/message', AssistantMessageController::class)->name('assistant.message');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/businesses', function () {
    $businesses = Business::with(['type', 'services', 'schedules'])->latest()->get();
    return view('public.business', compact('businesses'));
})->name('business.page');
Route::get('/booking', [BookingController::class, 'create'])->name('booking.page');
Route::middleware('auth')->group(function () {
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}/payment', [BookingController::class, 'payment'])->name('booking.payment');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.layouts.app');
    })->name('layouts.app');

    Route::get('/search', function (\Illuminate\Http\Request $request) {
        $query = trim((string) $request->query('q', ''));

        $pages = collect([
            ['title' => __('�����-������'), 'description' => __('������� ������� �������� ��������������.'), 'route' => route('admin.layouts.app')],
            ['title' => __('��� �������'), 'description' => __('�������� �������, email � ������.'), 'route' => route('profile.edit')],
            ['title' => __('������ �������'), 'description' => __('������� �������� �������� ��������.'), 'route' => route('dashboard')],
            ['title' => __('���������� ��������������'), 'description' => __('������� �������� ���������� ��������������.'), 'route' => route('admin.bookings.manage')],
        ]);

        $results = $query === ''
            ? collect()
            : $pages->filter(function (array $page) use ($query) {
                return str_contains(strtolower($page['title']), strtolower($query))
                    || str_contains(strtolower($page['description']), strtolower($query));
            })->values();

        return view('admin.partials.search', [
            'query' => $query,
            'results' => $results,
        ]);
    })->name('search');

    Route::get('/bookings/manage', function () {
        return __('�������� ���������� ��������������');
    })->name('bookings.manage');

    Route::resource('businesses', BusinessesController::class);
    Route::resource('businesses-types', BusinessesTypesController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardRedirectController::class)->name('dashboard');
    Route::get('/client/dashboard', ClientDashboardController::class)
        ->middleware('role:user')
        ->name('client.dashboard');
    Route::prefix('owner')->name('owner.')->middleware('role:owner|business')->group(function () {
        Route::get('/dashboard', OwnerDashboardController::class)->name('dashboard');
        Route::resource('businesses', OwnerBusinessesController::class);
    });

    Route::redirect('/business/dashboard', '/owner/dashboard')->name('business.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
