@include('public.partials.header')

{{-- КОНТЕЙНЕР ДЛЯ УВЕДОМЛЕНИЙ --}}
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080; margin-top: 100px;">
    @if(session('success'))
        <div id="bookingToast" class="toast align-items-center text-white bg-success border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body py-3 fw-medium" style="font-size: 15px;">
                    🎉 {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white m-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>

<main class="main" style="padding-top:120px; background-color: #f8fafc; min-height: 100vh;">
<div class="container">

{{-- ================================================================== --}}
{{-- ШАГ 3: ФОРМА БРОНИРОВАНИЯ С HERO-БЛОКОМ БИЗНЕСА (Выбран конкретный бизнес) --}}
{{-- ================================================================== --}}
@if(isset($business) && $business)

    <div class="mb-4">
        <a href="{{ url('/booking?type_id=' . $business->business_type_id) }}" class="text-decoration-none text-secondary fw-medium small d-inline-flex align-items-center gap-2 bg-white px-3 py-2 rounded-3 shadow-sm border">
            &larr; Назад к выбору бизнеса
        </a>
    </div>

    <div class="row g-4 justify-content-center align-items-start">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div style="height: 260px; overflow: hidden; position: relative;">
                    @if($business->image)
                        <img src="{{ asset('storage/' . $business->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $business->name }}">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white fw-bold fs-1" style="background: linear-gradient(135deg, #5046e5, #7c3aed);">
                            {{ mb_substr($business->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h3 class="fw-bold mb-0" style="font-size: 24px; color: #1e293b; letter-spacing: -0.5px;">{{ $business->name }}</h3>
                        <span class="badge bg-primary-subtle text-primary px-3 py-2" style="font-size: 12px; border-radius: 8px; font-weight: 600;">
                            {{ $business->type->name ?? 'Бизнес' }}
                        </span>
                    </div>

                    <div class="text-muted small mb-4" style="font-size: 14px;">
                        <div class="mb-2 d-flex align-items-center gap-2">📍 <span class="text-uppercase fw-semibold text-dark">{{ $business->address }}</span></div>
                        @if($business->phone)
                            <div class="d-flex align-items-center gap-2">📞 <span class="fw-semibold text-dark">{{ $business->phone }}</span></div>
                        @endif
                    </div>

                    <div class="p-3 rounded-4 border bg-stone" style="font-size: 13px; background-color: #f1f5f9;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-success fw-bold d-flex align-items-center gap-1">● Открыто</span>
                            <span class="fw-bold text-dark">00:00 - 23:59</span>
                        </div>
                        <div class="d-flex gap-1 justify-content-between text-muted text-center" style="font-size: 11px;">
                            @foreach(['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'] as $day)
                                <span class="flex-fill py-1 bg-white rounded-3 shadow-sm border fw-bold text-secondary">{{ $day }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm p-4 p-md-5 border-0" style="border-radius: 20px;">
                <h4 class="fw-bold mb-4" style="color: #1e293b; letter-spacing: -0.5px;">Оформление бронирования</h4>

                <form method="POST" action="{{ route('booking.store') }}">
                    @csrf
                    <input type="hidden" name="business_id" value="{{ $business->id }}">

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Выберите услугу</label>
                        <select name="service_id" class="form-select py-3" style="border-radius: 12px; background-color: #f8fafc;" required>
                            <option value="" disabled selected>Нажмите для выбора...</option>
                            @foreach($business->services as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} — {{ number_format($s->price ?? 0, 0) }} сомон</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark small">Дата</label>
                            <input type="date" name="booking_date" class="form-control py-3" style="border-radius: 12px; background-color: #f8fafc;" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-dark small">Время</label>
                            <input type="time" name="start_time" class="form-control py-3" style="border-radius: 12px; background-color: #f8fafc;" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark small">Комментарий к записи</label>
                        <textarea name="comment" class="form-control" rows="3" style="border-radius: 12px; background-color: #f8fafc;" placeholder="Например: пожелания к мастеру или детали заказа..."></textarea>
                    </div>

                    <button class="btn text-white w-100 py-3 fw-bold shadow-sm custom-submit-btn" style="background-color: #5046e5; border-radius: 14px; font-size: 16px;">
                        Подтвердить запись
                    </button>
                </form>
            </div>
        </div>
    </div>

{{-- ================================================================== --}}
{{-- ШАГ 2: СПИСОК БИЗНЕСОВ ВНУТРИ ВЫБРАННОЙ КАТЕГОРИИ --}}
{{-- ================================================================== --}}
@elseif(isset($selectedType) && $selectedType)

    <div class="mb-4">
        <a href="{{ url('/booking') }}" class="text-decoration-none text-secondary fw-medium small d-inline-flex align-items-center gap-2 bg-white px-3 py-2 rounded-3 shadow-sm border">
            &larr; Назад к категориям
        </a>
    </div>

    <h3 class="mb-4 fw-bold" style="color: #1e293b; letter-spacing: -0.5px;">Доступные варианты</h3>

    <div class="row g-4 mb-5">
        @forelse($businesses as $b)
            <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                <div class="card border-0 shadow-sm h-100 overflow-hidden business-premium-card" style="border-radius: 22px; background-color: #ffffff;">
                    
                    <div class="position-relative" style="height: 210px; overflow: hidden;">
                        @if($b->image)
                            <img src="{{ asset('storage/' . $b->image) }}" class="w-100 h-100 object-fit-cover biz-img" alt="{{ $b->name }}">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white fw-bold fs-2" style="background: linear-gradient(135deg, #6366f1, #a855f7);">
                                {{ mb_substr($b->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="position-absolute top-3 end-3">
                            <span class="badge bg-white text-dark shadow-sm px-3 py-2" style="font-size: 12px; border-radius: 10px; font-weight: 700; color: #1e293b !important;">
                                {{ $b->type->name ?? 'Бизнес' }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4 d-flex flex-column justify-content-between" style="min-height: 320px;">
                        <div>
                            <h4 class="fw-bold mb-2 text-dark" style="font-size: 22px; letter-spacing: -0.4px; line-height: 1.3;">{{ $b->name }}</h4>
                            
                            <div class="d-flex flex-column gap-1.5 mb-3 text-secondary" style="font-size: 13.5px;">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-primary" style="opacity: 0.8;">📍</span>
                                    <span class="text-truncate fw-medium text-muted" style="max-width: 100%;">{{ $b->address }}</span>
                                </div>
                                @if($b->phone)
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary" style="opacity: 0.8;">📞</span>
                                        <span class="fw-semibold text-dark">{{ $b->phone }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-2.5 rounded-3 mb-4 d-flex align-items-center justify-content-between" style="background-color: #f8fafc; border: 1px solid #edf2f7;">
                                <span class="badge bg-success-subtle text-success d-flex align-items-center gap-1.5 px-2.5 py-1.5" style="font-size: 12px; font-weight: 600; border-radius: 6px;">
                                    <span style="display:inline-block; width:6px; height:6px; background-color:#10b981; border-radius:50%;"></span>
                                    Открыто
                                </span>
                                <span class="text-dark fw-bold" style="font-size: 12.5px;">00:00 - 23:59</span>
                            </div>

                            <div class="mb-4">
                                <div class="text-uppercase fw-bold text-muted mb-2 tracking-wider" style="font-size: 11px; letter-spacing: 0.5px;">Популярные услуги</div>
                                <div class="d-flex flex-column gap-2" style="max-height: 110px; overflow-y: auto;">
                                    @forelse($b->services->take(2) as $service)
                                        <div class="d-flex justify-content-between align-items-center py-1.5 border-bottom border-light">
                                            <span class="text-secondary text-truncate me-2" style="font-size: 14px; font-weight: 500;">{{ $service->name }}</span>
                                            <span class="fw-bold text-dark px-2 py-0.5 rounded-2" style="font-size: 13.5px; background-color: #f1f5f9;">
                                                {{ number_format($service->price ?? 0, 0, '.', ' ') }} сом.
                                            </span>
                                        </div>
                                    @empty
                                        <span class="text-muted small italic">Список услуг пуст</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <a href="{{ url('/booking?type_id=' . $selectedType . '&business_id=' . $b->id) }}"
                           class="btn text-white w-100 py-3 fw-bold shadow-sm action-premium-btn" style="background-color: #5046e5; border-radius: 14px; font-size: 15px; letter-spacing: -0.1px;">
                            Перейти к бронированию
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 bg-white rounded-4 shadow-sm border max-width-md mx-auto">
                    <p class="text-muted fs-5 mb-0">В данной категории еще нет зарегистрированных заведений.</p>
                </div>
            </div>
        @endforelse
    </div>

{{-- ================================================================== --}}
{{-- ШАГ 1: ГЛАВНЫЙ ЭКРАН (Отображается изначально, когда ничего не выбрано) --}}
{{-- ================================================================== --}}
@else

    <h3 class="mb-4 fw-bold" style="color: #1e293b; letter-spacing: -0.75px; font-size: 28px;">Выберите категорию услуг</h3>

    <div class="row g-4 mb-5">
        @foreach($types as $type)
            @php
                $count = \App\Models\Business::where('business_type_id', $type->id)->count();
                $nameLower = Str::lower($type->name);

                if (Str::contains($nameLower, ['салон', 'красот', 'волос'])) {
                    $bgImage = 'https://images.unsplash.com/photo-1560066984-138dadb4c035?q=80&w=500&auto=format&fit=crop';
                    $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M3.5 3.5c-.614-.884-.074-1.962.858-2.5L8 7.226 11.642 1.c.932.538 1.472 1.616.858 2.5L8.81 8.61l1.556 2.661a2.5 2.5 0 1 1-.794.637L8 9.73l-1.572 2.177a2.5 2.5 0 1 1-.794-.638L7.19 8.61zm2.5 10a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0zm7 0a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/></svg>';
                } elseif (Str::contains($nameLower, ['барбер'])) {
                    $bgImage = 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?q=80&w=500&auto=format&fit=crop';
                    $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 12c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4"/></svg>';
                } elseif (Str::contains($nameLower, ['фитнес-клуб', 'фитнес'])) {
                    $bgImage = 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=500&auto=format&fit=crop';
                    $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M14.5 9a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0 0 1h1a.5.5 0 0 0 .5-.5m-13 0a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0 0 1h1a.5.5 0 0 0 .5-.5"/></svg>';
                } elseif (Str::contains($nameLower, ['спорт'])) {
                    $bgImage = 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=500&auto=format&fit=crop';
                    $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01z"/></svg>';
                } elseif (Str::contains($nameLower, ['стоматолог'])) {
                    $bgImage = 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?q=80&w=500&auto=format&fit=crop';
                    $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M12 .5a.5.5 0 0 1 .5.5v1.5a.5.5 0 0 1-1 0V1a.5.5 0 0 1 .5-.5M7 .5a.5.5 0 0 1 .5.5v1.5a.5.5 0 0 1-1 0V1a.5.5 0 0 1 .5-.5M1.5 5.5A2.5 2.5 0 0 1 4 3h8a2.5 2.5 0 0 1 2.5 2.5v7A2.5 2.5 0 0 1 12 15H4a2.5 2.5 0 0 1-2.5-2.5z"/></svg>';
                } elseif (Str::contains($nameLower, ['медицинский', 'центр', 'клиник'])) {
                    $bgImage = 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=500&auto=format&fit=crop';
                    $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/></svg>';
                } elseif (Str::contains($nameLower, ['косметолог'])) {
                    $bgImage = 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?q=80&w=500&auto=format&fit=crop';
                    $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>';
                } elseif (Str::contains($nameLower, ['йога', 'студия'])) {
                    $bgImage = 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=500&auto=format&fit=crop';
                    $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5"/></svg>';
                } elseif (Str::contains($nameLower, ['авто', 'сервис', 'ремонт'])) {
                    $bgImage = 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=500&auto=format&fit=crop';
                    $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M6 1h4v1.5a.5.5 0 0 1-1 0V2H7v.5a.5.5 0 0 1-1 0zm3.36 3.89c.14-.14.35-.19.54-.11a3 3 0 1 1-2.8 0c.19-.08.4-.03.54.11l1.11 1.12a.5.5 0 1 0 .71-.71z"/></svg>';
                } elseif (Str::contains($nameLower, ['ресторан'])) {
                    $bgImage = 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=500&auto=format&fit=crop';
                    $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M3 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5V4H3zm-1 3v4.5A2.5 2.5 0 0 0 4.5 12h7a2.5 2.5 0 0 0 2.5-2.5V5.5a.5.5 0 0 0-.5-.5H1.5a.5.5 0 0 0-.5.5"/></svg>';
                } elseif (Str::contains($nameLower, ['кафе'])) {
                    $bgImage = 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=500&auto=format&fit=crop';
                    $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5z"/></svg>';
                } else {
                    $bgImage = 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=500&auto=format&fit=crop';
                    $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5z"/></svg>';
                }
            @endphp

            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <a href="{{ url('/booking?type_id=' . $type->id) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm category-real-card overflow-hidden" style="border-radius: 16px;">
                        <div class="position-relative" style="height: 160px; overflow: hidden; background-color: #f1f5f9;">
                            <img src="{{ $bgImage }}" class="w-100 h-100 object-fit-cover cat-img" alt="{{ $type->name }}" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=500&auto=format&fit=crop';">
                            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, rgba(0,0,0,0) 60%, rgba(0,0,0,0.05));"></div>
                        </div>

                        <div class="card-body p-3 d-flex align-items-center justify-content-between bg-white">
                            <div class="overflow-hidden">
                                <h5 class="text-dark fw-bold mb-0 text-truncate" style="font-size: 16px; letter-spacing: -0.3px;">{{ $type->name }}</h5>
                                <small class="text-muted d-block mt-0.5" style="font-size: 13px;">{{ $count }} бизнесов</small>
                            </div>
                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" 
                                 style="width: 36px; height: 36px; background-color: #f0f1ff; color: #5046e5;">
                                {!! $svgIcon !!}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@endif

</div>
</main>

{{-- СТИЛИ ДЛЯ ПРЕМИАЛЬНОГО ДИЗАЙНА --}}
<style>
    .category-real-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .category-real-card .cat-img {
        transition: transform 0.5s ease;
    }
    .category-real-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 20px -5px rgba(0,0,0,0.08), 0 8px 8px -5px rgba(0,0,0,0.04) !important;
    }
    .category-real-card:hover .cat-img {
        transform: scale(1.06);
    }

    .business-premium-card {
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #f1f5f9 !important;
    }
    .business-premium-card .biz-img {
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .business-premium-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.06), 0 10px 10px -5px rgba(0, 0, 0, 0.03) !important;
        border-color: #e2e8f0 !important;
    }
    .business-premium-card:hover .biz-img {
        transform: scale(1.05);
    }

    .action-premium-btn, .custom-submit-btn {
        transition: all 0.2s ease;
    }
    .action-premium-btn:hover, .custom-submit-btn:hover {
        background-color: #4338ca !important;
        box-shadow: 0 4px 12px rgba(80, 70, 229, 0.25) !important;
    }
    .action-premium-btn:active, .custom-submit-btn:active {
        transform: scale(0.98);
    }

    .business-premium-card ::-webkit-scrollbar {
        width: 4px;
    }
    .business-premium-card ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    .business-premium-card ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastEl = document.getElementById('bookingToast');
        if (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>

@include('public.partials.footer')