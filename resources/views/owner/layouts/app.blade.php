<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    @php
        $ownerTitle = match (true) {
            request()->routeIs('owner.dashboard') => __('Панель владельца'),
            request()->routeIs('owner.businesses.index') => __('Мои бизнесы'),
            request()->routeIs('owner.businesses.create') => __('Добавить бизнес'),
            request()->routeIs('owner.businesses.edit') => __('Редактировать бизнес'),
            request()->routeIs('owner.businesses.show') => __('Карточка бизнеса'),
            
        };
        $pageTitle = trim($__env->yieldContent('title', $ownerTitle));
    @endphp
    <title>{{ $pageTitle }} | BroNix</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('Кабинет владельца для управления бизнесами в BroNix.') }}" />
    <meta name="author" content="BroNix" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/admin/js/head.js') }}"></script>

    <script>
        (function () {
            // Фиксируем всегда светлую тему, так как переключатель удален
            document.documentElement.setAttribute('data-bs-theme', 'light');
        })();
    </script>
</head>

<body data-menu-color="light" data-sidebar="default">
<div id="app-layout">
    
    <div class="topbar-custom shadow-sm bg-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center" style="height: 70px;">
                
                <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                    <li>
                        <button class="button-toggle-menu nav-link p-2 me-3 rounded-circle hover-bg">
                            <i data-feather="menu" class="noti-icon text-dark"></i>
                        </button>
                    </li>
                    <li class="d-none d-lg-block">
                        <h5 class="mb-0 fw-semibold text-body">
                            {{ __('Панель владельца') }}, <span class="text-primary">{{ auth()->user()->name ?? __('Пользователь') }}</span>
                        </h5>
                    </li>
                </ul>

                <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center gap-2">
                    
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user me-0 d-flex align-items-center py-2" data-bs-toggle="dropdown" href="#" role="button">
                            <span class="pro-user-name d-inline-block text-body fw-medium">
                                {{ auth()->user()->name ?? __('Пользователь') }} 
                                <i class="mdi mdi-chevron-down opacity-70 ms-1"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-dropdown shadow-sm border-0 rounded-3">
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0 text-muted fs-11 text-uppercase fw-bold">{{ __('Аккаунт') }}</h6>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item notify-item py-2">
                                <i class="mdi mdi-account-cog-outline fs-16 align-middle me-1.5 text-muted"></i>
                                <span>{{ __('Настройки аккаунта') }}</span>
                            </a>
                            <div class="dropdown-divider my-1 opacity-50"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item notify-item py-2 text-danger">
                                    <i class="mdi mdi-location-exit fs-16 align-middle me-1.5"></i>
                                    <span>{{ __('Выйти') }}</span>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0 text-body">@yield('page_title', $pageTitle)</h4>
                        @yield('header')
                    </div>
                </div>

                @yield('content')
            </div>
        </div>

       <footer class="footer bg-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col text-muted text-center py-2" style="font-size: 12px; opacity: 0.7;">
                        &copy; <script>document.write(new Date().getFullYear())</script> BroNix — Сделано со вкусом
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div class="app-sidebar-menu">
        <div class="h-100" data-simplebar>
            <div id="sidebar-menu">
                <div class="logo-box border-bottom">
                    <a href="{{ route('owner.dashboard') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/admin/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/admin/images/logo-light.png') }}" alt="" height="24">
                        </span>
                    </a>
                    <a href="{{ route('owner.dashboard') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/admin/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/admin/images/logo-dark.png') }}" alt="" height="24">
                        </span>
                    </a>
                </div>

                <ul id="side-menu">
                    <li class="menu-title text-muted fs-11 text-uppercase fw-bold mt-2">{{ __('Меню владельца') }}</li>

                    <li>
                        <a href="{{ route('owner.dashboard') }}" class="{{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                            <i data-feather="home"></i>
                            <span>{{ __('Панель управления') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('owner.businesses.index') }}" class="{{ request()->routeIs('owner.businesses.index', 'owner.businesses.show', 'owner.businesses.edit') ? 'active' : '' }}">
                            <i data-feather="briefcase"></i>
                            <span>{{ __('Мои бизнесы') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('owner.businesses.create') }}" class="{{ request()->routeIs('owner.businesses.create') ? 'active' : '' }}">
                            <i data-feather="plus-circle"></i>
                            <span>{{ __('Создать бизнес') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <i data-feather="settings"></i>
                            <span>{{ __('Настройки аккаунта') }}</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('home') }}">
                            <i data-feather="globe"></i>
                            <span>{{ __('Публичный сайт') }}</span>
                        </a>
                    </li>

                    <li class="border-top mt-2 pt-2">
                        <a href="{{ route('logout') }}" class="text-danger" onclick="event.preventDefault(); document.getElementById('owner-sidebar-logout-form').submit();">
                            <i data-feather="log-out" class="text-danger"></i>
                            <span>{{ __('Выйти') }}</span>
                        </a>
                        <form id="owner-sidebar-logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/admin/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/app.js') }}"></script>

<script>
    // Скрипт переключения темы удален, так как элементы интерфейса отсутствуют.
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof feather !== 'undefined') feather.replace();
    });
</script>

<script>
    document.querySelectorAll('.schedule-row').forEach((row) => {
        const checkbox = row.querySelector('.day-off');
        const start = row.querySelector('.start-time');
        const end = row.querySelector('.end-time');

        if (!checkbox || !start || !end) return;

        function toggle() {
            row.style.opacity = checkbox.checked ? '0.5' : '1';
            start.disabled = checkbox.checked;
            end.disabled = checkbox.checked;
        }

        function switchToWorkDayIfTimeEntered() {
            if (start.value || end.value) {
                checkbox.checked = false;
                row.style.opacity = '1';
                start.disabled = false;
                end.disabled = false;
            }
        }

        checkbox.addEventListener('change', toggle);
        start.addEventListener('input', switchToWorkDayIfTimeEntered);
        end.addEventListener('input', switchToWorkDayIfTimeEntered);

        toggle();
    });
</script>
</body>
</html>