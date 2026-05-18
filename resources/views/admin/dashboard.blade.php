@extends('admin.layouts.app')

@section('title', __('Админ-панель'))

@section('header')
    <p class="text-muted mb-0 mt-1">{{ __('Центр управления платформой: бизнесы, категории, пользователи и бронирования в одном месте.') }}</p>
@endsection

@section('content')
    @php
        $bookingStatuses = [
            'pending' => ['label' => __('Ожидают'), 'class' => 'warning'],
            'confirmed' => ['label' => __('Подтверждены'), 'class' => 'success'],
            'cancelled' => ['label' => __('Отменены'), 'class' => 'danger'],
        ];
    @endphp

    <div class="mt-4">
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-xxl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-soft-primary text-primary mb-3">{{ __('Каталог') }}</span>
                        <h3 class="mb-1">{{ $stats['businesses'] }}</h3>
                        <p class="text-muted mb-0">{{ __('Всего бизнесов на платформе') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xxl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-soft-info text-info mb-3">{{ __('Структура') }}</span>
                        <h3 class="mb-1">{{ $stats['types'] }}</h3>
                        <p class="text-muted mb-0">{{ __('Категорий бизнеса доступно в системе') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xxl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-soft-success text-success mb-3">{{ __('Записи') }}</span>
                        <h3 class="mb-1">{{ $stats['bookings'] }}</h3>
                        <p class="text-muted mb-0">{{ __('Всего бронирований создано') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xxl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge bg-soft-warning text-warning mb-3">{{ __('Пользователи') }}</span>
                        <h3 class="mb-1">{{ $stats['users'] }}</h3>
                        <p class="text-muted mb-0">{{ __('Всего аккаунтов в системе') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                            <div>
                                <h5 class="mb-1">{{ __('Что может администратор') }}</h5>
                                <p class="text-muted mb-0">{{ __('Быстрые переходы в основные разделы управления.') }}</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <h6 class="mb-2">{{ __('Управление бизнесами') }}</h6>
                                    <p class="text-muted mb-3">{{ __('Просмотр, редактирование и удаление любых карточек бизнеса на платформе.') }}</p>
                                    <a href="{{ route('admin.businesses.index') }}" class="btn btn-primary btn-sm">{{ __('Открыть бизнесы') }}</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <h6 class="mb-2">{{ __('Типы бизнесов') }}</h6>
                                    <p class="text-muted mb-3">{{ __('Поддерживайте категории каталога в актуальном состоянии.') }}</p>
                                    <a href="{{ route('admin.businesses-types.index') }}" class="btn btn-primary btn-sm">{{ __('Открыть категории') }}</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <h6 class="mb-2">{{ __('Все бронирования') }}</h6>
                                    <p class="text-muted mb-3">{{ __('Фильтруйте записи клиентов и меняйте статусы без перехода в публичную часть.') }}</p>
                                    <a href="{{ route('admin.bookings.manage') }}" class="btn btn-primary btn-sm">{{ __('Открыть бронирования') }}</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <h6 class="mb-2">{{ __('Аккаунт администратора') }}</h6>
                                    <p class="text-muted mb-3">{{ __('Обновите профиль или быстро вернитесь на публичный сайт.') }}</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">{{ __('Профиль') }}</a>
                                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">{{ __('Сайт') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="mb-3">{{ __('Сводка по ролям и сервисам') }}</h5>
                        <div class="d-flex justify-content-between border rounded-3 px-3 py-2 mb-2">
                            <span>{{ __('Администраторы') }}</span>
                            <strong>{{ $stats['admins'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between border rounded-3 px-3 py-2 mb-2">
                            <span>{{ __('Владельцы') }}</span>
                            <strong>{{ $stats['owners'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between border rounded-3 px-3 py-2 mb-2">
                            <span>{{ __('Клиенты') }}</span>
                            <strong>{{ $stats['clients'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between border rounded-3 px-3 py-2 mb-2">
                            <span>{{ __('Услуги') }}</span>
                            <strong>{{ $stats['services'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between border rounded-3 px-3 py-2">
                            <span>{{ __('Ожидающие бронирования') }}</span>
                            <strong>{{ $stats['pending_bookings'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            @foreach ($bookingStatuses as $key => $meta)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <span class="badge bg-soft-{{ $meta['class'] }} text-{{ $meta['class'] }} mb-3">{{ $meta['label'] }}</span>
                            <h3 class="mb-1">{{ $stats[$key . '_bookings'] }}</h3>
                            <p class="text-muted mb-0">{{ __('Бронирования со статусом') }} "{{ $meta['label'] }}"</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-3">
            <div class="col-xl-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-1">{{ __('Последние бронирования') }}</h5>
                                <p class="text-muted mb-0">{{ __('Новые заявки клиентов по всем бизнесам.') }}</p>
                            </div>
                            <a href="{{ route('admin.bookings.manage') }}" class="btn btn-outline-primary btn-sm">{{ __('Все записи') }}</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th>{{ __('Клиент') }}</th>
                                    <th>{{ __('Бизнес') }}</th>
                                    <th>{{ __('Услуга') }}</th>
                                    <th>{{ __('Дата') }}</th>
                                    <th>{{ __('Статус') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($recentBookings as $booking)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $booking->user?->name ?? __('Не указан') }}</div>
                                            <div class="text-muted small">{{ $booking->user?->email ?? '—' }}</div>
                                        </td>
                                        <td>{{ $booking->business?->name ?? '—' }}</td>
                                        <td>{{ $booking->service?->name ?? '—' }}</td>
                                        <td>{{ $booking->booking_date ? \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d.m.Y') : '—' }}</td>
                                        <td>
                                            @php($statusMeta = $bookingStatuses[$booking->status] ?? ['label' => $booking->status, 'class' => 'secondary'])
                                            <span class="badge bg-soft-{{ $statusMeta['class'] }} text-{{ $statusMeta['class'] }}">{{ $statusMeta['label'] }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">{{ __('Пока нет бронирований.') }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-1">{{ __('Новые бизнесы') }}</h5>
                                <p class="text-muted mb-0">{{ __('Последние добавленные компании в каталоге.') }}</p>
                            </div>
                            <a href="{{ route('admin.businesses.index') }}" class="btn btn-outline-primary btn-sm">{{ __('Каталог') }}</a>
                        </div>

                        <div class="d-grid gap-3">
                            @forelse ($recentBusinesses as $business)
                                <div class="border rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div>
                                            <div class="fw-semibold">{{ $business->name }}</div>
                                            <div class="text-muted small">{{ $business->type?->name ?? __('Без категории') }}</div>
                                        </div>
                                        <span class="badge bg-soft-primary text-primary">{{ $business->services_count }} {{ __('услуг') }}</span>
                                    </div>
                                    <div class="text-muted small mt-2">{{ __('Владелец') }}: {{ $business->owner?->name ?? __('Не указан') }}</div>
                                    <div class="text-muted small">{{ __('Создано') }}: {{ $business->created_at?->format('d.m.Y H:i') ?? '—' }}</div>
                                </div>
                            @empty
                                <div class="text-muted">{{ __('Бизнесы ещё не добавлены.') }}</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
