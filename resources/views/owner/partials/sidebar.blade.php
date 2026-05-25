<style>

    #sidebar-menu { padding: 0 15px; }
    
    #side-menu li { margin-bottom: 4px; }
    
    #side-menu li a {
        display: flex;
        align-items: center;
        padding: 12px 16px !important;
        border-radius: 12px !important;
        color: #64748b !important;
        transition: all 0.3s ease !important;
        font-weight: 500;
    }

    #side-menu li a i { margin-right: 12px; width: 18px; height: 18px; }

    
    #side-menu li a.active {
        background: #0d6efd !important; 
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    
    #side-menu li a:hover:not(.active) {
        background: #f1f5f9;
        color: #1e293b !important;
    }

    
    .menu-title {
        padding: 20px 10px 10px 10px !important;
        font-size: 0.75rem !important;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8 !important;
    }
</style>
<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">
            <div class="logo-box">
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
                <li class="menu-title">{{ __('Меню владельца') }}</li>

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

                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('owner-sidebar-logout-form').submit();">
                        <i data-feather="log-out"></i>
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
