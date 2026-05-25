@php
    $menuItems = [
        [
            'label' => __('Бронирования'),
            'icon' => 'calendar',
            // Используем Route::has для проверки существования роута
            'route' => Route::has('admin.bookings.manage') ? route('admin.bookings.manage') : route('owner.bookings.index'),
            'active' => request()->routeIs('admin.bookings.*'),
        ],
        [
            'label' => __('Бизнесы'),
            'icon' => 'briefcase',
            'route' => Route::has('admin.businesses.index') ? route('admin.businesses.index') : '#',
            'active' => request()->routeIs('admin.businesses.*'),
        ],
        [
            'label' => __('Типы бизнесов'),
            'icon' => 'tag',
            'route' => Route::has('admin.businesses-types.index') ? route('admin.businesses-types.index') : '#',
            'active' => request()->routeIs('admin.businesses-types.*'),
        ],
        [
            'label' => __('Панель'),
            'icon' => 'grid',
            'route' => Route::has('admin.layouts.app') ? route('admin.layouts.app') : url('/admin'),
            'active' => request()->routeIs('admin.layouts.app'),
        ],
        [
            'label' => __('Настройки'),
            'icon' => 'settings',
            'route' => route('profile.edit'),
            'active' => request()->routeIs('profile.edit'),
        ],
    ];
@endphp

<aside class="app-sidebar-menu">
    <div class="admin-sidebar-shell">
        <a href="{{ route('admin.layouts.app') }}" class="admin-brand">
            <span class="admin-brand-text">ADMIN</span>
        </a>

        <div class="admin-sidebar-nav" data-simplebar>
            <ul class="admin-nav-list">
                @foreach ($menuItems as $item)
                    <li>
                        <a href="{{ $item['route'] }}" class="admin-nav-link {{ $item['active'] ? 'active' : '' }}">
                            <span class="admin-nav-icon">
                                <i data-feather="{{ $item['icon'] }}"></i>
                            </span>
                            <span class="admin-nav-label">{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="admin-logout-form">
            @csrf
            <button type="submit" class="admin-nav-link admin-logout-link">
                <span class="admin-nav-icon">
                    <i data-feather="log-out"></i>
                </span>
                <span class="admin-nav-label">{{ __('Выйти') }}</span>
            </button>
        </form>
    </div>
</aside>
