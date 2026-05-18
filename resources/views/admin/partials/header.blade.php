<header class="topbar-custom">
    <div class="admin-topbar">
        <div class="admin-topbar-start">
            <button type="button" class="admin-sidebar-toggle" aria-label="{{ __('Открыть меню') }}">
                <i data-feather="menu"></i>
            </button>
            <div class="admin-topbar-title">{{ $adminTitle }}</div>
        </div>

        <div class="admin-topbar-end">
            @if (request()->routeIs('admin.bookings.manage'))
                <form method="GET" action="{{ route('admin.bookings.manage') }}" class="admin-topbar-search">
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <i data-feather="search" class="admin-topbar-search-icon"></i>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        class="form-control"
                        placeholder="{{ __('Поиск по клиенту, email, услуге...') }}"
                    >
                </form>
            @else
                <form method="GET" action="{{ route('admin.search') }}" class="admin-topbar-search">
                    <i data-feather="search" class="admin-topbar-search-icon"></i>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        class="form-control"
                        placeholder="{{ __('Поиск по страницам...') }}"
                    >
                </form>
            @endif

            <button type="button" class="admin-icon-button" aria-label="{{ __('Уведомления') }}">
                <i data-feather="bell"></i>
            </button>

            <div class="dropdown">
                <button
                    class="admin-user-button dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    <span>{{ auth()->user()->name ?? __('Administrator') }}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end admin-user-dropdown">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">{{ __('Мой аккаунт') }}</a>
                    <a href="{{ route('home') }}" class="dropdown-item">{{ __('Открыть сайт') }}</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">{{ __('Выйти') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
