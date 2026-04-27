@include('public.partials.header')

@php
    $daysMap = trans('messages.days');
@endphp

<main class="main">
    <section class="section" style="padding-top: 140px;">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h1 class="mb-3">{{ __('messages.booking_page.title') }}</h1>
                    <p class="mb-0">{{ __('messages.booking_page.description') }}</p>
                </div>
            </div>

            @if($businesses->isEmpty())
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body text-center py-5">
                                <h3 class="h4 mb-3">{{ __('messages.booking_page.empty_title') }}</h3>
                                <p class="text-muted mb-4">{{ __('messages.booking_page.empty_description') }}</p>
                                <a href="{{ route('home') }}" class="btn btn-primary">{{ __('messages.common.back_home') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row g-4">
                    <div class="col-lg-7">
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
                                @endphp

                                <div class="col-12">
                                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <div class="h-100 bg-light d-flex align-items-center justify-content-center">
                                                    @if($business->image)
                                                        <img
                                                            src="{{ asset('storage/' . $business->image) }}"
                                                            alt="{{ $business->name }}"
                                                            style="width: 100%; height: 100%; object-fit: cover; min-height: 240px;"
                                                        >
                                                    @else
                                                        <div class="text-muted fw-semibold">{{ __('messages.common.no_photo') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="card-body p-4">
                                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                                        <div>
                                                            <h3 class="h4 mb-1">{{ $business->name }}</h3>
                                                            <p class="text-muted mb-0">{{ $business->type->name ?? __('messages.common.uncategorized') }}</p>
                                                        </div>
                                                        <span class="badge bg-primary-subtle text-primary">{{ __('messages.common.available') }}</span>
                                                    </div>

                                                    <p class="text-muted mb-3">
                                                        {{ \Illuminate\Support\Str::limit($business->description ?: __('messages.booking_page.description_placeholder'), 140) }}
                                                    </p>

                                                    <div class="small text-muted mb-3">
                                                        <div class="mb-2"><strong>{{ __('messages.common.address') }}:</strong> {{ $business->address ?: __('messages.common.not_specified') }}</div>
                                                        <div class="mb-2"><strong>{{ __('messages.common.phone') }}:</strong> {{ $business->phone ?: __('messages.common.not_specified') }}</div>
                                                        <div><strong>{{ __('messages.common.working_days') }}:</strong> {{ $workingDays->isNotEmpty() ? $workingDays->pluck('day')->implode(', ') : __('messages.common.not_specified_plural') }}</div>
                                                    </div>

                                                    @if($workingDays->isNotEmpty())
                                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                                            @foreach($workingDays as $item)
                                                                <span class="small rounded-pill bg-light border px-2 py-1 text-dark">
                                                                    {{ $item['day'] }} {{ $item['time'] }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    <div>
                                                        <h4 class="h6 mb-3">{{ __('messages.common.services') }}</h4>
                                                        @if($business->services->isEmpty())
                                                            <div class="text-muted small">{{ __('messages.booking_page.services_empty') }}</div>
                                                        @else
                                                            <div class="d-flex flex-column gap-2">
                                                                @foreach($business->services as $service)
                                                                    <div class="d-flex justify-content-between align-items-center border rounded-3 px-3 py-2">
                                                                        <div>
                                                                            <strong>{{ $service->name }}</strong>
                                                                            <div class="small text-muted">{{ __('messages.common.duration') }}: {{ $service->duration }}</div>
                                                                        </div>
                                                                        <div class="text-end">
                                                                            <div class="fw-semibold">{{ number_format((float) $service->price, 0, '.', ' ') }}</div>
                                                                            <div class="small text-muted">{{ __('messages.common.currency') }}</div>
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
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 110px;">
                            <div class="card-body p-4">
                                <h3 class="h4 mb-3">{{ __('messages.booking_page.booking_form_title') }}</h3>
                                <p class="text-muted mb-4">{{ __('messages.booking_page.booking_form_description') }}</p>

                                @guest
                                    <div class="alert alert-warning">
                                        {{ __('messages.booking_page.login_notice_before') }}
                                        <a href="{{ route('login') }}" class="alert-link">{{ __('messages.booking_page.login_notice_link') }}</a>.
                                    </div>
                                @endguest

                                <form action="{{ route('booking.store') }}" method="post">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">{{ __('messages.booking_page.business_label') }}</label>
                                        <select name="business_id" class="form-select" required>
                                            <option value="" selected disabled>{{ __('messages.booking_page.business_placeholder') }}</option>
                                            @foreach($businesses as $business)
                                                <option value="{{ $business->id }}" @selected((int) old('business_id', $selectedBusinessId ?? 0) === $business->id)>{{ $business->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('business_id')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">{{ __('messages.booking_page.service_label') }}</label>
                                        <select name="service_id" class="form-select" required>
                                            <option value="" selected disabled>{{ __('messages.booking_page.service_placeholder') }}</option>
                                            @foreach($businesses as $business)
                                                @foreach($business->services as $service)
                                                    <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>{{ $business->name }} - {{ $service->name }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        @error('service_id')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('messages.booking_page.date_label') }}</label>
                                            <input type="date" name="booking_date" class="form-control" value="{{ old('booking_date') }}" required>
                                            @error('booking_date')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('messages.booking_page.time_label') }}</label>
                                            <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                                            @error('start_time')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">{{ __('messages.booking_page.comment_label') }}</label>
                                        <textarea name="comment" class="form-control" rows="4" placeholder="{{ __('messages.booking_page.comment_placeholder') }}">{{ old('comment') }}</textarea>
                                        @error('comment')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">{{ __('messages.booking_page.submit') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>

@include('public.partials.footer')
