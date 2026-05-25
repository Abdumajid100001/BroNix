@include('public.partials.header')

@php
    $daysMap = trans('messages.days');
@endphp

<style>
    .schedule-box {
        background: #f8f9ff;
        padding: 12px;
        border-radius: 14px;
        border: 1px solid #eef2ff;
    }

    .status { font-weight:600; font-size:13px; }
    .status.open { color:#16a34a; }
    .status.closed { color:#dc2626; }

    .time { font-weight:600; font-size:13px; }

    .days {
        display:flex;
        flex-wrap:wrap;
        gap:6px;
        margin-top:6px;
    }

    .days span {
        background:#eef2ff;
        padding:4px 8px;
        border-radius:8px;
        font-size:11px;
    }

    /* услуги */
    .services-box {
        background:#fff;
        border:1px solid #eef2ff;
        border-radius:14px;
        padding:12px;
    }

    .services-title {
        font-weight:600;
        font-size:13px;
        margin-bottom:8px;
    }

    .service-item {
        display:flex;
        justify-content:space-between;
        font-size:13px;
    }

    .service-meta {
        color:#6b7280;
        font-size:12px;
    }
</style>

<main class="main">
    <section class="section bnx-booking-section">
        <div class="container">

            <div class="row g-4">
                @foreach($businesses as $business)

                    @php
                        $daysOrder = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                        $schedules = $business->schedules->keyBy('day_of_week');

                        $workingDays = collect($daysOrder)->map(function($day) use ($schedules,$daysMap){
                            $row = $schedules->get($day);
                            if(!$row || $row->is_day_off) return null;

                            $start = substr($row->start_time,0,5);
                            $end = substr($row->end_time,0,5);

                            return [
                                'day'=>$daysMap[$day] ?? $day,
                                'time'=>"$start - $end"
                            ];
                        })->filter()->values();

                        $workTime = $workingDays->pluck('time')->unique()->implode(', ');

                        $nowDay = now()->format('l');
                        $nowTime = now()->format('H:i');

                        $today = $schedules->get($nowDay);

                        $isOpen = false;
                        if($today && !$today->is_day_off){
                            $start = substr($today->start_time,0,5);
                            $end = substr($today->end_time,0,5);
                            $isOpen = $nowTime >= $start && $nowTime <= $end;
                        }
                    @endphp

                    <div class="col-md-6 col-xl-4">
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">

                            <div class="ratio ratio-16x9 bg-light">
                                @if($business->image)
                                    <img src="{{ asset('storage/'.$business->image) }}" class="bnx-business-image">
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column">

                                <div class="d-flex justify-content-between mb-2">
                                    <h5>{{ $business->name }}</h5>
                                    <span class="badge bg-primary-subtle text-primary">
{{ $business->type->name ?? '-' }}
</span>
                                </div>

                                <p class="text-muted small">
                                    {{ Str::limit($business->description,100) }}
                                </p>

                                <div class="small text-muted mb-3">
                                    <div>📍 {{ $business->address }}</div>
                                    <div>📞 {{ $business->phone }}</div>
                                </div>

                                <div class="schedule-box mb-3">
                                    <div class="d-flex justify-content-between">
<span class="status {{ $isOpen ? 'open':'closed' }}">
{{ $isOpen ? '🟢 Открыто':'🔴 Закрыто' }}
</span>

                                        <span class="time">{{ $workTime }}</span>
                                    </div>

                                    <div class="days">
                                        @foreach($workingDays as $d)
                                            <span>{{ $d['day'] }}</span>
                                        @endforeach
                                    </div>
                                </div>

                             
                                @if($business->services->isNotEmpty())
                                    <div class="services-box mb-3">
                                        <div class="services-title">💼 Услуги</div>

                                        @foreach($business->services->take(3) as $service)
                                            @php
                                                $duration = preg_replace('/[^0-9]/', '', $service->duration);
                                            @endphp

                                            <div class="service-item">
                                                <span>{{ $service->name }}</span>

                                                <span class="service-meta">
{{ $service->price }} сомон
@if($duration) • {{ $duration }} минут @endif
</span>
                                            </div>
                                        @endforeach

                                        @if($business->services->count() > 3)
                                            <div class="service-meta mt-1">
                                                + ещё {{ $business->services->count() - 3 }}
                                            </div>
                                        @endif

                                    </div>
                                @endif

                                <a href="{{ route('booking.page',$business->id) }}" class="btn btn-primary mt-auto">
                                    Перейти к бронированию
                                </a>

                            </div>
                        </div>
                    </div>

                @endforeach
            </div>

        </div>
    </section>
</main>

@include('public.partials.footer')
