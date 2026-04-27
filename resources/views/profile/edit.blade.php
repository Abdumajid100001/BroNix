<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <title>{{ __('Мой аккаунт') }} | BroNix</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('Управление аккаунтом в BroNix.') }}" />
    <meta name="author" content="BroNix" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/admin/js/head.js') }}"></script>
</head>

<body data-menu-color="light" data-sidebar="default">
<div id="app-layout">
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
                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="pro-user-name ms-1">{{ auth()->user()->name ?? __('Пользователь') }} <i class="mdi mdi-chevron-down"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">{{ __('Аккаунт') }}</h6>
                            </div>

                            <a href="{{ route('profile.edit') }}" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-circle-outline fs-16 align-middle"></i>
                                <span>{{ __('Мой аккаунт') }}</span>
                            </a>

                            <div class="dropdown-divider"></div>

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

    @include('admin.partials.sidebar')

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">{{ __('Мой аккаунт') }}</h4>
                        <p class="text-muted mb-0 mt-1">{{ __('Обновите данные профиля, пароль и настройки доступа к аккаунту.') }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">{{ __('Информация профиля') }}</h5>

                                @if (session('status') === 'profile-updated')
                                    <div class="alert alert-success" role="alert">
                                        {{ __('Профиль успешно обновлён.') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{ __('Полное имя') }}</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
                                        @error('name')
                                            <div class="text-danger mt-1 small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('Email адрес') }}</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                        @error('email')
                                            <div class="text-danger mt-1 small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">{{ __('Сохранить изменения') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">{{ __('Обновить пароль') }}</h5>

                                @if (session('status') === 'password-updated')
                                    <div class="alert alert-success" role="alert">
                                        {{ __('Пароль успешно обновлён.') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">{{ __('Текущий пароль') }}</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="current-password">
                                        @if ($errors->updatePassword->has('current_password'))
                                            <div class="text-danger mt-1 small">{{ $errors->updatePassword->first('current_password') }}</div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">{{ __('Новый пароль') }}</label>
                                        <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                                        @if ($errors->updatePassword->has('password'))
                                            <div class="text-danger mt-1 small">{{ $errors->updatePassword->first('password') }}</div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">{{ __('Подтвердите новый пароль') }}</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                                        @if ($errors->updatePassword->has('password_confirmation'))
                                            <div class="text-danger mt-1 small">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary">{{ __('Обновить пароль') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card border border-danger">
                            <div class="card-body">
                                <h5 class="card-title text-danger mb-3">{{ __('Удалить аккаунт') }}</h5>
                                <p class="text-muted">{{ __('Это действие необратимо. Введите пароль, чтобы подтвердить удаление аккаунта.') }}</p>

                                <form method="POST" action="{{ route('profile.destroy') }}">
                                    @csrf
                                    @method('DELETE')

                                    <div class="mb-3">
                                        <label for="delete_password" class="form-label">{{ __('Текущий пароль') }}</label>
                                        <input type="password" class="form-control" id="delete_password" name="password" autocomplete="current-password">
                                        @if ($errors->userDeletion->has('password'))
                                            <div class="text-danger mt-1 small">{{ $errors->userDeletion->first('password') }}</div>
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-danger">{{ __('Удалить аккаунт') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col fs-13 text-muted text-center">
                        &copy; <script>document.write(new Date().getFullYear())</script> BroNix
                    </div>
                </div>
            </div>
        </footer>
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
</body>
</html>
