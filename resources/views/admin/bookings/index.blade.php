@extends('admin.layouts.app')

@section('title', __('Управление бронированиями'))
@section('page_title', __('Панель управления'))

@section('header')
    <p>{{ __('Здесь вы можете управлять всеми бронированиями и их статусами.') }}</p>
@endsection

@section('content')
    @php
        $statusMeta = [
            'pending' => ['label' => __('Ожидают')],
            'confirmed' => ['label' => __('Подтверждены')],
            'cancelled' => ['label' => __('Отменены')],
        ];

        $paymentMeta = [
            'pending' => __('Ожидает оплату'),
            'paid' => __('Оплачено'),
            'failed' => __('Ошибка оплаты'),
        ];

        $summaryCards = [
            ['icon' => 'calendar', 'label' => __('Всего бронирований'), 'value' => $summary['all']],
            ['icon' => 'clock', 'label' => __('Ожидают'), 'value' => $summary['pending']],
            ['icon' => 'check-circle', 'label' => __('Подтверждены'), 'value' => $summary['confirmed']],
            ['icon' => 'x-circle', 'label' => __('Отменены'), 'value' => $summary['cancelled']],
        ];
    @endphp

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4 mb-4">
        @foreach ($summaryCards as $card)
            <div class="col-sm-6 col-xl-3">
                <div class="admin-kpi-card">
                    <div class="admin-kpi-row">
                        <span class="admin-kpi-icon">
                            <i data-feather="{{ $card['icon'] }}"></i>
                        </span>
                        <div>
                            <p class="admin-kpi-label">{{ $card['label'] }}</p>
                            <h2 class="admin-kpi-value">{{ $card['value'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="admin-filter-card mb-4">
        <form method="GET" action="{{ route('admin.bookings.manage') }}">
            <div class="row g-3 align-items-end">
                <div class="col-lg-5">
                    <label for="booking-search" class="admin-filter-label">{{ __('Поиск') }}</label>
                    <input
                        id="booking-search"
                        type="text"
                        name="q"
                        value="{{ $query }}"
                        class="form-control admin-filter-input"
                        placeholder="{{ __('Имя, email, бизнес или услуга') }}"
                    >
                </div>

                <div class="col-lg-4">
                    <label for="booking-status" class="admin-filter-label">{{ __('Статус') }}</label>
                    <select id="booking-status" name="status" class="form-select admin-filter-select">
                        <option value="">{{ __('Все статусы') }}</option>
                        @foreach ($statusMeta as $key => $meta)
                            <option value="{{ $key }}" @selected($status === $key)>{{ $meta['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3">
                    <div class="admin-filter-actions">
                        <button type="submit" class="btn btn-admin-dark">{{ __('Применить') }}</button>
                        <a href="{{ route('admin.bookings.manage') }}" class="btn btn-admin-light">{{ __('Сбросить') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="admin-table-card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th class="admin-table-index">#</th>
                    <th>{{ __('Клиент') }}</th>
                    <th>{{ __('Бизнес / Услуга') }}</th>
                    <th>{{ __('Дата и время') }}</th>
                    <th>{{ __('Комментарий') }}</th>
                    <th>{{ __('Статус') }}</th>
                    <th>{{ __('Действия') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($bookings as $booking)
                    @php
                        $paymentStatus = $paymentMeta[$booking->payment->status ?? 'pending'] ?? ($booking->payment->status ?? __('Нет данных'));
                        $statusFormId = 'booking-status-' . $booking->id;
                    @endphp
                    <tr>
                        <td class="admin-table-index">{{ $booking->id }}</td>
                        <td>
                            <div class="admin-client-name">{{ $booking->user?->name ?? __('Не указан') }}</div>
                            <div class="admin-client-meta">{{ $booking->user?->email ?? '—' }}</div>
                        </td>
                        <td>
                            <div class="admin-entity-name">{{ $booking->business?->name ?? '—' }}</div>
                            <div class="admin-entity-meta">{{ $booking->service?->name ?? __('Услуга не указана') }}</div>
                        </td>
                        <td>
                            <div class="admin-entity-name">
                                {{ $booking->booking_date ? \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d.m.Y') : '—' }}
                            </div>
                            <div class="admin-datetime-meta">
                                {{ $booking->start_time ? \Illuminate\Support\Str::substr((string) $booking->start_time, 0, 5) : '—' }}
                                -
                                {{ $booking->end_time ? \Illuminate\Support\Str::substr((string) $booking->end_time, 0, 5) : '—' }}
                            </div>
                        </td>

                        <td>
                            <div class="admin-comment-text {{ $booking->comment ? '' : 'is-empty' }}">
                                {{ $booking->comment ?: '—' }}
                            </div>
                        </td>
                        <td>
                            <form id="{{ $statusFormId }}" method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="admin-status-form">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select admin-status-select">
                                    @foreach ($statusMeta as $key => $meta)
                                        <option value="{{ $key }}" @selected($booking->status === $key)>{{ $meta['label'] }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>
                            <button
                                type="submit"
                                form="{{ $statusFormId }}"
                                class="btn btn-admin-icon"
                                title="{{ __('Сохранить статус') }}"
                                aria-label="{{ __('Сохранить статус') }}"
                            >
                                <i data-feather="check"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="admin-empty-state">
                            {{ __('Подходящие бронирования не найдены.') }}
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($bookings->hasPages())
            <div class="p-4 pt-0">
                {{ $bookings->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
