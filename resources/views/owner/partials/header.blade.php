<style>
    .topbar-custom {
        background: rgba(255, 255, 255, 0.75) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        padding: 0.75rem 0;
        transition: all 0.3s ease;
    }
    .nav-user {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        padding: 0.5rem 1.25rem !important;
        border-radius: 50px !important;
        transition: all 0.2s;
    }
    .nav-user:hover {
        background: #edf2f7;
    }
    .profile-dropdown {
        border-radius: 16px !important;
        overflow: hidden;
        border: none !important;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
    }
</style>

<div class="topbar-custom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                <li>
                    <button class="button-toggle-menu nav-link p-0 me-3 text-dark">
                        <i data-feather="menu" style="width:22px; height:22px;"></i>
                    </button>
                </li>
                <li class="d-none d-lg-block">
                    <h5 class="mb-0 fw-bold text-dark">{{ $pageTitle }}</h5>
                </li>
            </ul>

            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                <li class="dropdown">
                    <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#">
                        <span class="pro-user-name fw-semibold">{{ auth()->user()->name ?? __('Пользователь') }}</span>
                        <i class="mdi mdi-chevron-down ms-1"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown p-2">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-uppercase text-muted fs-11 fw-bold">{{ __('Аккаунт') }}</h6>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item py-2">
                            <i class="mdi mdi-account-cog-outline fs-16 me-2"></i> {{ __('Настройки') }}
                        </a>
                        <div class="dropdown-divider my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger">
                                <i class="mdi mdi-logout fs-16 me-2"></i> {{ __('Выйти') }}
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>