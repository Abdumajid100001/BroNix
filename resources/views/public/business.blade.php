@include('public.partials.header')

@php
    $daysMap = trans('messages.days');
@endphp

<main class="main">
    <section class="section" style="padding-top: 140px;">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h1 class="mb-3">{{ __('messages.business_page.title') }}</h1>
                    <p class="mb-0">{{ __('messages.business_page.description') }}</p>
                </div>
            </div>

            @if($businesses->isEmpty())
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body text-center py-5">
                                <h3 class="h4 mb-3">{{ __('messages.business_page.empty_title') }}</h3>
                                <p class="text-muted mb-4">{{ __('messages.business_page.empty_description') }}</p>
                                <a href="{{ route('home') }}" class="btn btn-primary">{{ __('messages.common.back_home') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row g-4">
                    @foreach($businesses as $business)
                        @php
                            $daysOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            $schedulesByDay = $business->schedules->keyBy(fn ($item) => strtolower((string) $item->day_of_week));
                            $workingDays = collect($daysOrder)->map(function ($dayKey) use ($schedulesByDay, $daysMap) {
                                $row = $schedulesByDay->get(strtolower($dayKey));

                                if (! $row || $row->is_day_off) {
                                    return null;
                                }

                                $start = $row->start_time ? \Illuminate\Support\Str::substr($row->start_time, 0, 5) : null;
                                $end = $row->end_time ? \Illuminate\Support\Str::substr($row->end_time, 0, 5) : null;
                                $hasRealTime = $start && $end && ! ($start === '00:00' && $end === '00:00');

                                if (! $hasRealTime) {
                                    return null;
                                }

                                return [
                                    'day' => $daysMap[$dayKey] ?? $dayKey,
                                    'time' => $start . ' - ' . $end,
                                ];
                            })->filter()->values();
                            $workTimeLabel = $workingDays->pluck('time')->unique()->implode(', ');
                        @endphp

                        <div class="col-12 col-md-6 col-xl-4" id="business-{{ $business->id }}">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                <div class="ratio ratio-16x9 bg-light">
                                    @if($business->image)
                                        <img
                                            src="{{ asset('storage/' . $business->image) }}"
                                            alt="{{ $business->name }}"
                                            style="width: 100%; height: 100%; object-fit: cover;"
                                        >
                                    @else
                                        <div class="d-flex align-items-center justify-content-center text-muted fw-semibold">
                                            {{ __('messages.common.no_photo') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                                        <h3 class="h5 mb-0">{{ $business->name }}</h3>
                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ $business->type->name ?? __('messages.common.uncategorized') }}
                                        </span>
                                    </div>

                                    <p class="text-muted mb-3">
                                        {{ \Illuminate\Support\Str::limit($business->description ?: __('messages.business_page.description_placeholder'), 120) }}
                                    </p>

                                    <div class="small text-muted mb-4">
                                        <div class="mb-2"><strong>{{ __('messages.common.address') }}:</strong> {{ $business->address ?: __('messages.common.not_specified') }}</div>
                                        <div class="mb-2"><strong>{{ __('messages.common.phone') }}:</strong> {{ $business->phone ?: __('messages.common.not_specified') }}</div>
                                        <div class="mb-2"><strong>{{ __('messages.common.working_hours') }}:</strong> {{ $workTimeLabel !== '' ? $workTimeLabel : __('messages.common.not_specified_neuter') }}</div>
                                        <div><strong>{{ __('messages.common.working_days') }}:</strong> {{ $workingDays->isNotEmpty() ? $workingDays->pluck('day')->implode(', ') : __('messages.common.not_specified_plural') }}</div>
                                    </div>

                                    @if($workingDays->isNotEmpty())
                                        <div class="d-flex flex-wrap gap-2 mb-4">
                                            @foreach($workingDays as $item)
                                                <span class="small rounded-pill bg-light border px-2 py-1 text-dark">
                                                    {{ $item['day'] }} {{ $item['time'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="mt-auto">
                                        <a href="{{ route('booking.page', ['business' => $business->id]) }}" class="btn btn-primary w-100">{{ __('messages.business_page.go_to_booking') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</main>

@include('public.partials.footer')
