<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $publicTitle = match (true) {
            request()->routeIs('home') => __('messages.site.home_title'),
            request()->routeIs('business.page') => __('messages.site.businesses_title'),
            request()->routeIs('booking.page') => __('messages.site.booking_title'),
            request()->routeIs('booking.payment') => __('messages.site.payment_title'),
            default => __('messages.site.app_name'),
        };

        $homeSectionLink = static fn (string $hash) => request()->routeIs('home')
            ? '#' . $hash
            : route('home') . '#' . $hash;

        $supportedLocales = config('app.supported_locales', []);
        $currentLocale = app()->getLocale();
    @endphp
    <title>{{ $publicTitle }} | {{ __('messages.site.app_name') }}</title>
    <meta name="description" content="{{ __('messages.site.meta_description') }}">
    <meta name="keywords" content="{{ __('messages.site.meta_keywords') }}">

    <link href="{{ asset('assets/public/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/public/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link href="{{ asset('assets/public/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/public/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/public/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/public/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/public/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/public/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/public/css/bronix-overrides.css') }}" rel="stylesheet">
</head>

<body class="{{ request()->routeIs('home') ? 'index-page bnx-home-page' : 'bnx-public-page' }}">
<header id="header" class="header fixed-top bnx-header">
    <div class="container-xl">
        <div class="bnx-header__shell">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto bnx-brand">
                <span class="bnx-brand__mark">B</span>
                <span class="bnx-brand__copy">
                    <strong>{{ __('messages.site.app_name') }}</strong>
                    <small>{{ __('messages.common.free_platform') }}</small>
                </span>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ $homeSectionLink('hero') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('messages.common.home') }}</a></li>
                    <li><a href="{{ route('business.page') }}" class="{{ request()->routeIs('business.page') ? 'active' : '' }}">{{ __('messages.common.businesses') }}</a></li>
                    <li><a href="{{ route('booking.page') }}" class="{{ request()->routeIs('booking.page', 'booking.payment') ? 'active' : '' }}">{{ __('messages.common.booking') }}</a></li>
                    <li><a href="{{ $homeSectionLink('contact') }}">{{ __('messages.header.contacts') }}</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <div class="bnx-header__actions">
                <div class="dropdown">
                    <button type="button" class="bnx-lang-pill dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>{{ $supportedLocales[$currentLocale] ?? strtoupper($currentLocale) }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end bnx-lang-menu">
                        @foreach($supportedLocales as $locale => $label)
                            <li>
                                <a class="dropdown-item {{ $locale === $currentLocale ? 'active' : '' }}" href="{{ route('locale.switch', $locale) }}">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @auth
                    <a class="btn-getstarted flex-md-shrink-0" href="{{ route('dashboard') }}">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>{{ __('messages.common.dashboard') }}</span>
                    </a>
                @else
                    <a class="btn btn-outline-primary flex-md-shrink-0" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>{{ __('messages.common.login') }}</span>
                    </a>
                    <a class="btn-getstarted flex-md-shrink-0" href="{{ route('register') }}">
                        <i class="bi bi-rocket-takeoff"></i>
                        <span>{{ __('messages.common.start') }}</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
