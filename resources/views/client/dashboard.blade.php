@extends('client.layouts.app')

@section('title', __('Личный кабинет'))

@section('header')
    <p class="text-muted mb-0 mt-1">{{ __('Здесь собраны ваши бронирования, оплаты и быстрые переходы к каталогу бизнесов.') }}</p>
@endsection

@section('content')
    <div class="row g-4 mt-1">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">{{ __('Бронирования') }}</p>
                    <h3 class="mb-0">{{ $stats['bookings'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">{{ __('Ожидают') }}</p>
                    <h3 class="mb-0">{{ $stats['pending_bookings'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">{{ __('Платежи') }}</p>
                    <h3 class="mb-0">{{ $stats['payments'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">{{ __('Оплачено') }}</p>
                    <h3 class="mb-0">{{ number_format($stats['paid_total'], 0, '.', ' ') }} {{ __('сум') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="card-title mb-0">{{ __('Последние бронирования') }}</h5>
                        <a href="{{ route('booking.page') }}" class="btn btn-sm btn-primary">{{ __('Новое бронирование') }}</a>
                    </div>

                    @if($recentBookings->isEmpty())
                        <div class="text-muted">
                            {{ __('Бронирований пока нет. Начните с каталога и выберите бизнес для первой записи.') }}
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                <tr>
                                    <th>{{ __('Бизнес') }}</th>
                                    <th>{{ __('Услуга') }}</th>
                                    <th>{{ __('Дата') }}</th>
                                    <th>{{ __('Статус') }}</th>
                                    <th>{{ __('Оплата') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recentBookings as $booking)
                                    <tr>
                                        <td>{{ $booking->business->name ?? '-' }}</td>
                                        <td>{{ $booking->service->name ?? '-' }}</td>
                                        <td>{{ \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d.m.Y') }}</td>
                                        <td>{{ $booking->status }}</td>
                                        <td>{{ $booking->payment->status ?? '—' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">{{ __('Популярные бизнесы') }}</h5>
                        <a href="{{ route('business.page') }}" class="btn btn-sm btn-outline-primary">{{ __('Каталог') }}</a>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @forelse($popularBusinesses as $business)
                            <div class="border rounded-3 p-3">
                                <div class="fw-semibold">{{ $business->name }}</div>
                                <div class="text-muted small mb-2">{{ $business->type->name ?? __('Бизнес') }}</div>
                                <div class="d-flex justify-content-between gap-3 small">
                                    <span>{{ $business->bookings_count }} {{ __('записей') }}</span>
                                    <span>{{ $business->services->count() }} {{ __('услуг') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-muted">{{ __('Каталог пока не заполнен.') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="card-title mb-0">{{ __('Последние оплаты') }}</h5>
                    </div>

                    @if($recentPayments->isEmpty())
                        <div class="text-muted">{{ __('Оплат пока нет.') }}</div>
                    @else
                        <div class="row g-3">
                            @foreach($recentPayments as $payment)
                                <div class="col-md-6 col-xl-4">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="fw-semibold">{{ $payment->booking->business->name ?? '-' }}</div>
                                        <div class="text-muted small mb-2">{{ $payment->booking->service->name ?? '-' }}</div>
                                        <div class="d-flex justify-content-between gap-3">
                                            <span>{{ number_format((float) $payment->amount, 0, '.', ' ') }} {{ __('сум') }}</span>
                                            <span class="text-muted">{{ $payment->status }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
