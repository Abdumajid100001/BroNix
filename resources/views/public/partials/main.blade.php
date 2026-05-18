@php
    $assistantPrompts = [
        __('messages.prompts.barbershop_budget'),
        __('messages.prompts.popular_salons'),
        __('messages.prompts.good_schedule'),
    ];

    $categoriesCount = collect($categoryHighlights ?? [])->count();
@endphp

<main class="main bnx-home">
    <section id="hero" class="bnx-hero">
        <div class="container-xl">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="bnx-hero-copy">
                        <span class="bnx-kicker">{{ __('messages.home.kicker') }}</span>
                        <h1>
                            {{ __('messages.home.title_before') }}
                            <span>{{ __('messages.home.title_accent') }}</span>
                            {{ __('messages.home.title_after') }}
                        </h1>
                        <p class="bnx-lead">{{ __('messages.home.description') }}</p>

                        <div class="bnx-hero__actions">
                            <a href="{{ route('business.page') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-rocket-takeoff-fill"></i>
                                <span>{{ __('messages.home.start_free') }}</span>
                            </a>
                            <button type="button" class="btn btn-outline-primary btn-lg" data-bnx-open-assistant>
                                <i class="bi bi-stars"></i>
                                <span>{{ __('messages.home.ask_assistant') }}</span>
                            </button>
                        </div>

                        <div class="row g-3 bnx-metrics">
                            <div class="col-sm-4">
                                <div class="bnx-metric-card">
                                    <strong>{{ $platformMetrics['businesses'] ?? 0 }}</strong>
                                    <span>{{ __('messages.home.metric_companies') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="bnx-metric-card">
                                    <strong>{{ $categoriesCount }}</strong>
                                    <span>{{ __('messages.home.metric_categories') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="bnx-metric-card">
                                    <strong>{{ $platformMetrics['bookings'] ?? 0 }}</strong>
                                    <span>{{ __('messages.home.metric_bookings') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="100">
                    <div class="bnx-hero-panel">
                        <div class="bnx-hero-panel__head">
                            <h2>{{ __('messages.home.stats_title') }}</h2>
                            <span class="bnx-panel-icon"><i class="bi bi-graph-up-arrow"></i></span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <article class="bnx-stat-box">
                                    <span class="bnx-stat-box__label">
                                        <i class="bi bi-building"></i>
                                        {{ __('messages.home.stats_businesses') }}
                                    </span>
                                    <strong>{{ $platformMetrics['businesses'] ?? 0 }}</strong>
                                    <div class="bnx-progress"><span style="width: {{ min(100, (($platformMetrics['businesses'] ?? 0) * 12)) }}%"></span></div>
                                </article>
                            </div>

                            <div class="col-md-6">
                                <article class="bnx-stat-box">
                                    <span class="bnx-stat-box__label">
                                        <i class="bi bi-grid"></i>
                                        {{ __('messages.home.stats_services') }}
                                    </span>
                                    <strong>{{ $platformMetrics['services'] ?? 0 }}</strong>
                                    <div class="bnx-progress"><span style="width: {{ min(100, (($platformMetrics['services'] ?? 0) * 7)) }}%"></span></div>
                                </article>
                            </div>

                            <div class="col-12">
                                <article class="bnx-stat-box bnx-stat-box--wide">
                                    <span class="bnx-stat-box__label bnx-stat-box__label--accent">
                                        <i class="bi bi-stars"></i>
                                        {{ __('messages.home.stats_ai') }}
                                    </span>
                                    <strong>{{ $platformMetrics['bookings'] ?? 0 }}</strong>
                                    <p>{{ __('messages.home.stats_ai_description') }}</p>
                                    <div class="bnx-progress"><span style="width: {{ min(100, (($platformMetrics['bookings'] ?? 0) * 10) + 18) }}%"></span></div>
                                </article>
                            </div>
                        </div>

                        <div class="bnx-chip-list">
                            @foreach($assistantPrompts as $prompt)
                                <button type="button" class="bnx-chip" data-bnx-prompt="{{ $prompt }}">
                                    {{ $prompt }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="leaders" class="bnx-section">
        <div class="container-xl">
            <div class="bnx-section__heading" data-aos="fade-up">
                <span class="bnx-kicker">{{ __('messages.home.leaders_kicker') }}</span>
                <h2>{{ __('messages.home.leaders_title') }}</h2>
                <p>{{ __('messages.home.leaders_description') }}</p>
            </div>

            <div class="row g-4">
                @forelse($topBusinesses ?? collect() as $business)
                    @php
                        $minPrice = $business->services->pluck('price')->filter()->min();
                        $workingDays = $business->schedules->filter(fn ($schedule) => ! $schedule->is_day_off && $schedule->start_time && $schedule->end_time);
                        $firstSchedule = $workingDays->first();
                        $scheduleLabel = $firstSchedule
                            ? $workingDays->count() . ' ' . __('messages.common.working_days') . ', ' . \Illuminate\Support\Str::substr((string) $firstSchedule->start_time, 0, 5) . '-' . \Illuminate\Support\Str::substr((string) $firstSchedule->end_time, 0, 5)
                            : __('messages.common.not_specified_neuter');
                    @endphp
                    <div class="col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <article class="bnx-business-card">
                            <div class="bnx-business-card__image">
                                @if($business->image)
                                    <img src="{{ asset('storage/' . $business->image) }}" alt="{{ $business->name }}">
                                @else
                                    <img src="{{ asset('assets/public/img/services.jpg') }}" alt="{{ $business->name }}">
                                @endif
                                <span class="bnx-business-card__badge">{{ $business->bookings_count }} {{ __('messages.common.bookings') }}</span>
                            </div>

                            <div class="bnx-business-card__body">
                                <div class="bnx-business-card__topline">
                                    <span class="bnx-category-pill">{{ $business->type?->name ?? __('messages.common.uncategorized') }}</span>
                                    <span class="bnx-rating-pill">
                                        <i class="bi bi-graph-up-arrow"></i>
                                        {{ __('messages.home.top_demand') }}
                                    </span>
                                </div>

                                <h3>{{ $business->name }}</h3>
                                <p>{{ \Illuminate\Support\Str::limit($business->description ?: __('messages.business_page.description_placeholder'), 120) }}</p>

                                <ul class="bnx-business-card__meta">
                                    <li><i class="bi bi-cash-stack"></i> {{ $minPrice ? __('messages.assistant_engine.price_from', ['price' => number_format((float) $minPrice, 0, '.', ' ') . ' ' . __('messages.common.currency')]) : __('messages.common.price_on_request') }}</li>
                                    <li><i class="bi bi-grid"></i> {{ $business->services->count() }} {{ __('messages.common.services') }}</li>
                                    <li><i class="bi bi-clock-history"></i> {{ $scheduleLabel }}</li>
                                </ul>

                                <div class="bnx-business-card__actions">
                                    <a href="{{ route('business.page') }}#business-{{ $business->id }}" class="btn btn-outline-primary">{{ __('messages.common.open') }}</a>
                                    <a href="{{ route('booking.page', ['business' => $business->id]) }}" class="btn btn-primary">{{ __('messages.common.book') }}</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="bnx-empty-state" data-aos="fade-up">
                            {{ __('messages.business_page.empty_description') }}
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="assistant-showcase" class="bnx-section">
        <div class="container-xl">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="bnx-surface">
                        <span class="bnx-kicker">{{ __('messages.home.assistant_kicker') }}</span>
                        <h2>{{ __('messages.home.assistant_title') }}</h2>
                        <p>{{ __('messages.home.assistant_description') }}</p>

                        <ul class="bnx-feature-list">
                            <li>{{ __('messages.home.assistant_feature_1') }}</li>
                            <li>{{ __('messages.home.assistant_feature_2') }}</li>
                            <li>{{ __('messages.home.assistant_feature_3') }}</li>
                        </ul>

                        <button type="button" class="btn btn-primary btn-lg w-100" data-bnx-open-assistant>
                            {{ __('messages.home.assistant_launch') }}
                        </button>
                    </div>
                </div>

                <div class="col-lg-7" data-aos="fade-left" data-aos-delay="100">
                    <div class="bnx-surface bnx-surface--grid">
                        <div class="row g-3">
                            @forelse($categoryHighlights ?? collect() as $item)
                                <div class="col-md-6">
                                    <div class="bnx-mini-card">
                                        <span class="bnx-mini-card__count">{{ $item['count'] }}</span>
                                        <h3>{{ $item['name'] }}</h3>
                                        <p>{{ $item['services_count'] }} {{ __('messages.common.services') }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="bnx-mini-card">
                                        <h3>{{ __('messages.common.categories') }}</h3>
                                        <p>{{ __('messages.business_page.empty_description') }}</p>
                                    </div>
                                </div>
                            @endforelse

                            <div class="col-12">
                                <div class="bnx-process-card">
                                    <div>
                                        <strong>1</strong>
                                        <span>{{ __('messages.home.process_step_1') }}</span>
                                    </div>
                                    <div>
                                        <strong>2</strong>
                                        <span>{{ __('messages.home.process_step_2') }}</span>
                                    </div>
                                    <div>
                                        <strong>3</strong>
                                        <span>{{ __('messages.home.process_step_3') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="catalog-preview" class="bnx-section">
        <div class="container-xl">
            <div class="bnx-section__heading" data-aos="fade-up">
                <span class="bnx-kicker">{{ __('messages.home.catalog_kicker') }}</span>
                <h2>{{ __('messages.home.catalog_title') }}</h2>
                <p>{{ __('messages.home.catalog_description') }}</p>
            </div>

            <div class="row g-4">
                @forelse($catalogPreview ?? collect() as $business)
                    @php
                        $minPrice = $business->services->pluck('price')->filter()->min();
                    @endphp
                    <div class="col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 80 }}">
                        <article class="bnx-catalog-card">
                            <div class="bnx-catalog-card__head">
                                <span class="bnx-category-pill">{{ $business->type?->name ?? __('messages.common.uncategorized') }}</span>
                                <span class="bnx-catalog-card__price">{{ $minPrice ? __('messages.assistant_engine.price_from', ['price' => number_format((float) $minPrice, 0, '.', ' ') . ' ' . __('messages.common.currency')]) : __('messages.common.price_on_request') }}</span>
                            </div>
                            <h3>{{ $business->name }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($business->description ?: __('messages.business_page.description_placeholder'), 115) }}</p>
                            <div class="bnx-catalog-card__footer">
                                <span><i class="bi bi-grid"></i> {{ $business->services->count() }} {{ __('messages.common.services') }}</span>
                                <a href="{{ route('booking.page', ['business' => $business->id]) }}">{{ __('messages.common.to_booking') }}</a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="bnx-empty-state" data-aos="fade-up">
                            {{ __('messages.business_page.empty_description') }}
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="contact" class="bnx-section bnx-section--compact">
        <div class="container-xl">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="bnx-surface bnx-surface--accent">
                        <span class="bnx-kicker">{{ __('messages.home.contact_kicker') }}</span>
                        <h2>{{ __('messages.home.contact_title') }}</h2>
                        <p>{{ __('messages.home.contact_description') }}</p>

                        <div class="bnx-contact-points">
                            <div>
                                <strong>{{ __('messages.home.contact_format_title') }}</strong>
                                <span>{{ __('messages.home.contact_format_text') }}</span>
                            </div>
                            <div>
                                <strong>{{ __('messages.home.contact_support_title') }}</strong>
                                <span>{{ __('messages.home.contact_support_text') }}</span>
                            </div>
                            <div>
                                <strong>{{ __('messages.home.contact_scenario_title') }}</strong>
                                <span>{{ __('messages.home.contact_scenario_text') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7" data-aos="fade-left" data-aos-delay="100">
                    <div class="bnx-surface">
                        <div class="bnx-form-heading">
                            <h3>{{ __('messages.contact.form_title') }}</h3>
                            <p>{{ __('messages.contact.form_description') }}</p>
                        </div>

                        <form action="{{ route('contact.send') }}" method="post" class="row g-3">
                            @csrf

                            @if(session('contact_success'))
                                <div class="col-12">
                                    <div class="alert alert-success mb-0" role="alert">
                                        {{ session('contact_success') }}
                                    </div>
                                </div>
                            @endif

                            @if(session('contact_error'))
                                <div class="col-12">
                                    <div class="alert alert-danger mb-0" role="alert">
                                        {{ session('contact_error') }}
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-6">
                                <label for="contact-name" class="form-label">{{ __('messages.contact.name') }}</label>
                                <input type="text" id="contact-name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="{{ __('messages.contact.name_placeholder') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="contact-email" class="form-label">{{ __('messages.contact.email') }}</label>
                                <input type="email" id="contact-email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="you@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="contact-subject" class="form-label">{{ __('messages.contact.subject') }}</label>
                                <input type="text" id="contact-subject" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" placeholder="{{ __('messages.contact.subject_placeholder') }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="contact-message" class="form-label">{{ __('messages.contact.message') }}</label>
                                <textarea id="contact-message" name="message" rows="6" class="form-control @error('message') is-invalid @enderror" placeholder="{{ __('messages.contact.message_placeholder') }}" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-send me-2"></i>{{ __('messages.contact.send_button') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>