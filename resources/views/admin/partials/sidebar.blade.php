<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">
            <div class="logo-box">
                <a href="{{ route('admin.layouts.app') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/admin/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/admin/images/logo-light.png') }}" alt="" height="24">
                    </span>
                </a>
                <a href="{{ route('admin.layouts.app') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/admin/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/admin/images/logo-dark.png') }}" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul id="side-menu">
                <li class="menu-title">{{ __('Меню') }}</li>

                <li>
                    <a href="{{ route('admin.layouts.app') }}" class="{{ request()->routeIs('admin.layouts.app') ? 'active' : '' }}">
                        <i data-feather="home"></i>
                        <span>{{ __('Админ-панель') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.businesses.index') }}" class="{{ request()->routeIs('admin.businesses.*') ? 'active' : '' }}">
                        <i data-feather="briefcase"></i>
                        <span>{{ __('Бизнесы') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.businesses-types.index') }}" class="{{ request()->routeIs('admin.businesses-types.*') ? 'active' : '' }}">
                        <i data-feather="layers"></i>
                        <span>{{ __('Типы бизнесов') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.bookings.manage') }}" class="{{ request()->routeIs('admin.bookings.manage') ? 'active' : '' }}">
                        <i data-feather="calendar"></i>
                        <span>{{ __('Управление бронированиями') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i data-feather="settings"></i>
                        <span>{{ __('Настройки аккаунта') }}</span>
                    </a>
                </li>

                <li class="menu-title mt-2">{{ __('Переходы') }}</li>

                <li>
                    <a href="{{ route('home') }}">
                        <i data-feather="globe"></i>
                        <span>{{ __('Публичный сайт') }}</span>
                    </a>
                </li>

                <li class="menu-title mt-2">{{ __('Аккаунт') }}</li>

                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('admin-sidebar-logout-form').submit();">
                        <i data-feather="log-out"></i>
                        <span>{{ __('Выйти') }}</span>
                    </a>
                    <form id="admin-sidebar-logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>

        <div class="clearfix"></div>
    </div>
</div>
