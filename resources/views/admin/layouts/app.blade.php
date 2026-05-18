<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    @php
        $adminTitle = match (true) {
            request()->routeIs('dashboard') => __('Личный кабинет'),
            request()->routeIs('admin.layouts.app') => __('Панель управления'),
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
        $documentTitle = str_contains($pageTitle, 'BroNix') ? $pageTitle : $pageTitle . ' | BroNix';
    @endphp
    <title>{{ $documentTitle }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('Панель администратора BroNix.') }}" />
    <meta name="author" content="BroNix" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/bronix-admin.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('assets/admin/js/head.js') }}"></script>
    @stack('admin_head')
</head>
<body class="admin-shell">
<div class="admin-app" id="adminApp">
    @include('admin.partials.sidebar')

    <div class="admin-main">
        @include('admin.partials.header', ['adminTitle' => $adminTitle])
        @include('admin.partials.content')
        @include('admin.partials.footer')
    </div>
</div>
</body>
</html>
