<?php

use App\Http\Controllers\Admin\BusinessesController;
use App\Http\Controllers\Admin\BusinessesTypesController;
use App\Http\Controllers\AssistantMessageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Owner\BusinessesController as OwnerBusinessesController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WalletController;
use App\Models\Booking;
use App\Models\Business;
use Illuminate\Support\Facades\Route;

/* ==========================================================================
    PUBLIC ROUTES (ПУБЛИЧНЫЕ СТРАНИЦЫ)
========================================================================== */

// Главная страница
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

    $catalogPreview = $businesses->take(6)->values();

    $platformMetrics = [
        'businesses' => $businesses->count(),
        'services'   => $businesses->sum(fn ($b) => $b->services->count()),
        'bookings'   => Booking::count(),
    ];

    $categoryHighlights = $businesses
        ->groupBy(fn ($b) => $b->type?->name ?? 'Без категории')
        ->map(fn ($items, $name) => [
            'name'           => $name,
            'count'          => $items->count(),
            'services_count' => $items->sum(fn ($b) => $b->services->count()),
        ])
        ->sortByDesc('count')
        ->take(4)
        ->values();

    return view('public.layouts.app', compact(
        'topBusinesses',
        'catalogPreview',
        'platformMetrics',
        'categoryHighlights'
    ));
})->name('home');

// Страница со списком всех бизнесов
Route::get('/businesses', function () {
    $businesses = Business::with(['type', 'services', 'schedules'])->latest()->get();
    return view('public.business', compact('businesses'));
})->name('business.page');

// Страница онлайн-бронирования (Шаг 1, 2, 3)
Route::get('/booking', [BookingController::class, 'index'])->name('booking.page');

// Локализация и обратная связь
Route::get('/locale/{locale}', [LocaleController::class, 'update'])->name('locale.switch');
Route::post('/assistant/message', AssistantMessageController::class)->name('assistant.message');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/gemini-test', [TestController::class, 'index']);


/* ==========================================================================
    AUTH REQUIRED ROUTES (ТОЛЬКО ДЛЯ АВТОРИЗОВАННЫХ)
========================================================================== */
Route::middleware('auth')->group(function () {

    // Создание бронирования и оплата
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}/payment', [BookingController::class, 'payment'])->name('booking.payment');

    // Кошелек и Карты
    Route::get('/wallet', function () { return view('public.wallet'); })->name('wallet');
    Route::post('/cards', [CardController::class, 'store'])->name('cards.store');

    // Общий редирект на нужную панель в зависимости от роли
    Route::get('/dashboard', DashboardRedirectController::class)->name('dashboard');

    // Панель клиента (обычный пользователь)
    Route::get('/client/dashboard', ClientDashboardController::class)
        ->middleware('role:user')
        ->name('client.dashboard');

    // Настройки профиля пользователя
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* ==========================================
        OWNER ZONE (ПАНЕЛЬ ВЛАДЕЛЬЦА БИЗНЕСА)
    ========================================== */
    Route::prefix('owner')->name('owner.')->middleware(['role:owner|business'])->group(function () {
        
        // Главная страница панели (Дашборд)
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
        
        // Календарь и управление записями
        Route::get('/bookings/calendar', [OwnerDashboardController::class, 'calendar'])->name('bookings.calendar');
        Route::get('/bookings/day/{date}', [OwnerDashboardController::class, 'dayBookings'])->name('bookings.day');
        Route::post('/bookings/store', [OwnerDashboardController::class, 'storeBooking'])->name('bookings.store');
        Route::post('/bookings/update-time/{id}', [OwnerDashboardController::class, 'updateBookingTime'])->name('bookings.updateTime');

        // Управление бизнесом (Автоматически создает: owner.businesses.index, .create, .edit, .destroy и т.д.)
        Route::resource('businesses', OwnerBusinessesController::class);
    });

    // Редирект со старого адреса дашборда на новый
    Route::redirect('/business/dashboard', '/owner/dashboard')->name('business.dashboard');
});


/* ==========================================================================
    ADMIN ZONE (ПАНЕЛЬ АДМИНИСТРАТОРА ПЛАТФОРМЫ)
========================================================================== */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', fn () => view('admin.layouts.app'))->name('layouts.app');
    Route::resource('businesses', BusinessesController::class);
    Route::resource('businesses-types', BusinessesTypesController::class);
});

require __DIR__.'/auth.php';