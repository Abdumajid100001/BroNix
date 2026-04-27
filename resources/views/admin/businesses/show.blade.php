@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        @php
            $daysMap = [
                'Monday' => __('ПН'),
                'Tuesday' => __('ВТ'),
                'Wednesday' => __('СР'),
                'Thursday' => __('ЧТ'),
                'Friday' => __('ПТ'),
                'Saturday' => __('СБ'),
                'Sunday' => __('ВС'),
            ];
            $daysOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $schedulesByDay = $business->schedules->keyBy('day_of_week');

            $workingDays = collect($daysOrder)->map(function ($dayKey) use ($schedulesByDay, $daysMap) {
                $row = $schedulesByDay->get($dayKey);

                if (!$row || $row->is_day_off) {
                    return null;
                }

                $start = $row->start_time ? \Illuminate\Support\Str::substr($row->start_time, 0, 5) : null;
                $end = $row->end_time ? \Illuminate\Support\Str::substr($row->end_time, 0, 5) : null;
                $hasRealTime = $start && $end && !($start === '00:00' && $end === '00:00');

                if (!$hasRealTime) {
                    return null;
                }

                return [
                    'day' => $daysMap[$dayKey],
                    'time' => $start . '-' . $end,
                ];
            })->filter()->values();

            $workingDayNames = $workingDays->pluck('day')->implode(', ');
            $dayOffCount = $business->schedules->where('is_day_off', true)->count();
            $dayOffLabel = ($dayOffCount % 10 == 1 && $dayOffCount % 100 != 11) ? __('день')
                : (($dayOffCount % 10 >= 2 && $dayOffCount % 10 <= 4 && ($dayOffCount % 100 < 10 || $dayOffCount % 100 >= 20)) ? __('дня') : __('дней'));
        @endphp

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mx-auto" style="max-width:980px;">
            <div class="row g-0">
                <div class="col-12 col-lg-5">
                    @if($business->image)
                        <img
                            src="{{ asset('storage/' . $business->image) }}"
                            alt="{{ $business->name }}"
                            class="w-100 h-100"
                            style="min-height:340px; max-height:520px; object-fit:cover;"
                        >
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted h-100" style="min-height:340px;">
                            {{ __('Нет фото') }}
                        </div>
                    @endif
                </div>

                <div class="col-12 col-lg-7">
                    <div class="card-body p-4 p-lg-5 h-100 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <div>
                                <h2 class="fw-bold mb-1">{{ $business->name }}</h2>
                                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                    {{ $business->type->name ?? __('Без категории') }}
                                </span>
                            </div>
                            <span class="text-muted small">ID: {{ $business->id }}</span>
                        </div>

                        <p class="text-muted mb-4">
                            {{ $business->description ?: __('Описание не заполнено.') }}
                        </p>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <div class="small text-muted mb-1">{{ __('Адрес') }}</div>
                                    <div class="fw-semibold">{{ $business->address ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <div class="small text-muted mb-1">{{ __('Телефон') }}</div>
                                    <div class="fw-semibold">{{ $business->phone ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <div class="small text-muted mb-1">{{ __('Дни работы') }}</div>
                                    <div class="fw-semibold">{{ $workingDayNames !== '' ? $workingDayNames : __('Не указан') }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <div class="small text-muted mb-1">{{ __('Выходные') }}</div>
                                    <div class="fw-semibold">{{ $dayOffCount }} {{ $dayOffLabel }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="fw-semibold mb-2">{{ __('График') }}</div>
                            @if($workingDays->isEmpty())
                                <div class="small text-muted">{{ __('Не указан') }}</div>
                            @else
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($workingDays as $item)
                                        <span class="badge rounded-pill text-bg-light border px-3 py-2">
                                            {{ $item['day'] }} {{ $item['time'] }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <div class="fw-semibold mb-2">{{ __('Услуги') }}</div>
                            @if($business->services->isEmpty())
                                <div class="small text-muted">{{ __('Услуги пока не добавлены.') }}</div>
                            @else
                                <div class="row g-2">
                                    @foreach($business->services as $service)
                                        <div class="col-sm-6">
                                            <div class="p-3 bg-light rounded-3 h-100">
                                                <div class="fw-semibold">{{ $service->name }}</div>
                                                <div class="small text-muted mt-1">{{ __('Цена') }}: {{ number_format((float) $service->price, 0, '.', ' ') }} {{ __('сум') }}</div>
                                                <div class="small text-muted">{{ __('Длительность') }}: {{ $service->duration }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="mt-auto d-flex flex-wrap gap-2">
                            <a href="{{ route('admin.businesses.index') }}" class="btn btn-dark">{{ __('Назад') }}</a>
                            <a href="{{ route('admin.businesses.edit', $business) }}" class="btn btn-outline-warning">{{ __('Изменить') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
