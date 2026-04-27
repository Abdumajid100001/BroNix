<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8" />
    @php
        $adminTitle = match (true) {
            request()->routeIs('dashboard') => __('Личный кабинет'),
            request()->routeIs('admin.layouts.app') => __('Админ-панель'),
            request()->routeIs('admin.search') => __('Поиск'),
            request()->routeIs('admin.businesses.index') => __('Бизнесы'),
            request()->routeIs('admin.businesses.create') => __('Добавить бизнес'),
            request()->routeIs('admin.businesses.edit') => __('Редактировать бизнес'),
            request()->routeIs('admin.businesses.show') => __('Карточка бизнеса'),
            request()->routeIs('admin.businesses-types.index') => __('Типы бизнесов'),
            request()->routeIs('admin.businesses-types.create') => __('Добавить тип бизнеса'),
            request()->routeIs('admin.businesses-types.edit') => __('Редактировать тип бизнеса'),
            request()->routeIs('admin.businesses-types.show') => __('Карточка типа бизнеса'),
            request()->routeIs('profile.edit') => __('Настройки аккаунта'),
            request()->routeIs('admin.bookings.manage') => __('Управление бронированиями'),
            default => 'BroNix Admin',
        };
        $pageTitle = trim($__env->yieldContent('title', $adminTitle));
    @endphp
    <title>{{ $pageTitle }} | BroNix</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('Панель администратора BroNix.') }}"/>
    <meta name="author" content="BroNix"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/admin/images/favicon.ico')}}">

    <!-- App css -->
    <link href="{{asset('assets/admin/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="{{asset('assets/admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    <script src="{{asset('assets/admin/js/head.js')}}"></script>


</head>

<!-- body start -->
<body data-menu-color="light" data-sidebar="default">

<!-- Begin page -->
<div id="app-layout">

    <!-- Topbar Start -->
    <div class="topbar-custom">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                    <li>
                        <button class="button-toggle-menu nav-link">
                            <i data-feather="menu" class="noti-icon"></i>
                        </button>
                    </li>
                    <li class="d-none d-lg-block">
                        <h5 class="mb-0">{{ __('Доброе утро') }}, {{ auth()->user()->name ?? __('Пользователь') }}</h5>
                    </li>
                </ul>

                <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                    <li class="d-none d-lg-block">
                        <form class="app-search d-none d-md-block me-auto" method="GET" action="{{ route('admin.search') }}">
                            <div class="position-relative topbar-search">
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control ps-4" placeholder="{{ __('Поиск по страницам...') }}" />
                                <i class="mdi mdi-magnify fs-16 position-absolute text-muted top-50 translate-middle-y ms-2"></i>
                            </div>
                        </form>
                    </li>

                    <!-- Button Trigger Customizer Offcanvas -->
                    <li class="d-none d-sm-flex">
                        <button type="button" class="btn nav-link" data-toggle="fullscreen">
                            <i data-feather="maximize" class="align-middle fullscreen noti-icon"></i>
                        </button>
                    </li>

                    <!-- Light/Dark Mode Button Themes -->
                    <li class="d-none d-sm-flex">
                        <button type="button" class="btn nav-link" id="light-dark-mode">
                            <i data-feather="moon" class="align-middle dark-mode"></i>
                            <i data-feather="sun" class="align-middle light-mode"></i>
                        </button>
                    </li>

                    <!-- User Dropdown -->
                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="pro-user-name ms-1">{{ auth()->user()->name ?? __('Пользователь') }} <i class="mdi mdi-chevron-down"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">{{ __('Аккаунт') }}</h6>
                            </div>

                            <!-- item-->
                            <a href="{{ route('profile.edit') }}" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-circle-outline fs-16 align-middle"></i>
                                <span>{{ __('Мой аккаунт') }}</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item notify-item">
                                    <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                                    <span>{{ __('Выйти') }}</span>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
