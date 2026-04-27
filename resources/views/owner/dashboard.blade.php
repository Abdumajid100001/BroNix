@extends('owner.layouts.app')

@section('title', __('Панель владельца'))
@section('page_title', __('Панель владельца'))

@section('header')
    <p class="text-muted mb-0 mt-1">
        {{ __('Управляйте своими бизнесами, смотрите новые бронирования и следите за оплатами.') }}
    </p>
@endsection

@section('content')

    <div class="container-fluid px-2 px-md-4">

        <!-- СТАТИСТИКА -->
        <div class="row g-3">
            @foreach([
                ['label' => __('Мои бизнесы'), 'value' => $stats['businesses']],
                ['label' => __('Все бронирования'), 'value' => $stats['bookings']],
                ['label' => __('Ожидают'), 'value' => $stats['pending_bookings']],
                ['label' => __('Оплачено'), 'value' => number_format($stats['paid_total'], 0, '.', ' ') . ' ' . __('сум')],
            ] as $item)

                <div class="col-6 col-md-4 col-xl-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center text-md-start">
                            <p class="text-muted small mb-1">{{ $item['label'] }}</p>
                            <h5 class="mb-0">{{ $item['value'] }}</h5>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>

        <!-- ОСНОВНОЙ БЛОК -->
        <div class="row g-3 mt-2">

            <!-- БРОНИРОВАНИЯ -->
            <div class="col-12 col-xl-7">
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                            <h5 class="mb-0">{{ __('Последние бронирования') }}</h5>
                            <a href="{{ route('owner.businesses.index') }}" class="btn btn-sm btn-primary">
                                {{ __('Мои бизнесы') }}
                            </a>
                        </div>

                        @if($recentBookings->isEmpty())
                            <p class="text-muted mb-0">{{ __('Пока нет бронирований.') }}</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Бизнес') }}</th>
                                        <th class="d-none d-md-table-cell">{{ __('Клиент') }}</th>
                                        <th class="d-none d-md-table-cell">{{ __('Услуга') }}</th>
                                        <th>{{ __('Дата') }}</th>
                                        <th>{{ __('Статус') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td>{{ $booking->business->name ?? '-' }}</td>
                                            <td class="d-none d-md-table-cell">{{ $booking->user->name ?? '-' }}</td>
                                            <td class="d-none d-md-table-cell">{{ $booking->service->name ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y') }}</td>
                                            <td>
                                            <span class="badge bg-secondary">
                                                {{ $booking->status }}
                                            </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <!-- ОПЛАТЫ -->
            <div class="col-12 col-xl-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <h5 class="mb-3">{{ __('Последние оплаты') }}</h5>

                        @if($recentPayments->isEmpty())
                            <p class="text-muted mb-0">{{ __('Оплат пока нет.') }}</p>
                        @else
                            <div class="d-flex flex-column gap-2">

                                @foreach($recentPayments as $payment)
                                    <div class="border rounded p-2">

                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <div class="fw-semibold small">
                                                    {{ $payment->booking->business->name ?? '-' }}
                                                </div>
                                                <div class="text-muted small">
                                                    {{ $payment->booking->service->name ?? '-' }}
                                                </div>
                                            </div>

                                            <div class="text-end">
                                                <div class="fw-semibold small">
                                                    {{ number_format((float)$payment->amount, 0, '.', ' ') }} {{ __('сум') }}
                                                </div>
                                                <span class="badge bg-success">
                                                {{ $payment->status }}
                                            </span>
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

    </div>
@endsection
