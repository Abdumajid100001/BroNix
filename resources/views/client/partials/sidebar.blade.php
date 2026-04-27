<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">
            <div class="logo-box">
                <a href="{{ route('client.dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/clients/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/clients/images/logo-light.png') }}" alt="" height="24">
                    </span>
                </a>
                <a href="{{ route('client.dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/clients/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/clients/images/logo-dark.png') }}" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul id="side-menu">
                <li class="menu-title">{{ __('Меню клиента') }}</li>

                <li>
                    <a href="{{ route('client.dashboard') }}" class="{{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                        <i data-feather="home"></i>
                        <span>{{ __('Личный кабинет') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('business.page') }}" class="{{ request()->routeIs('business.page') ? 'active' : '' }}">
                        <i data-feather="briefcase"></i>
                        <span>{{ __('Бизнесы') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('booking.page') }}" class="{{ request()->routeIs('booking.page') ? 'active' : '' }}">
                        <i data-feather="calendar"></i>
                        <span>{{ __('Записаться') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i data-feather="user"></i>
                        <span>{{ __('Профиль') }}</span>
                    </a>
                </li>

                <li class="menu-title mt-2">{{ __('Переходы') }}</li>
                <li>
                    <a href="{{ route('home') }}">
                        <i data-feather="globe"></i>
                        <span>{{ __('Публичный сайт') }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
