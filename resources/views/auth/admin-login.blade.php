<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход администратора | BroNix</title>
    <meta name="description" content="Авторизация администратора в BroNix для управления бизнесами, категориями и бронированиями.">

    <link href="{{ asset('assets/public/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/public/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/public/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <style>
        :root {
            --admin-login-bg: #0b1220;
            --admin-login-surface: rgba(12, 23, 42, 0.88);
            --admin-login-card: #ffffff;
            --admin-login-line: rgba(148, 163, 184, 0.22);
            --admin-login-ink: #0f172a;
            --admin-login-muted: #64748b;
            --admin-login-accent: #2563eb;
            --admin-login-accent-dark: #1d4ed8;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.28), transparent 28%),
                radial-gradient(circle at bottom right, rgba(34, 197, 94, 0.18), transparent 24%),
                linear-gradient(145deg, #020817 0%, #0b1220 54%, #111f3d 100%);
            color: #fff;
        }

        .admin-login-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 32px 0;
        }

        .admin-login-frame {
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 32px;
            background: rgba(255, 255, 255, 0.04);
            box-shadow: 0 30px 100px rgba(2, 8, 23, 0.4);
            backdrop-filter: blur(20px);
        }

        .admin-login-side {
            height: 100%;
            padding: 42px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.03), rgba(255, 255, 255, 0)),
                var(--admin-login-surface);
        }

        .admin-login-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 800;
            text-decoration: none;
        }

        .admin-login-brand__mark {
            width: 46px;
            height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--admin-login-accent), #38bdf8);
            box-shadow: 0 16px 32px rgba(37, 99, 235, 0.3);
        }

        .admin-login-chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 38px;
            margin-top: 26px;
            padding: 0 16px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.16);
            border: 1px solid rgba(96, 165, 250, 0.2);
            color: #bfdbfe;
            font-size: 0.84rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .admin-login-title {
            margin: 26px 0 16px;
            font-size: clamp(2.3rem, 4vw, 4.2rem);
            line-height: 0.95;
            font-weight: 800;
        }

        .admin-login-copy {
            max-width: 520px;
            color: rgba(226, 232, 240, 0.86);
            font-size: 1rem;
            line-height: 1.8;
        }

        .admin-login-points {
            display: grid;
            gap: 14px;
            margin-top: 28px;
        }

        .admin-login-point {
            display: flex;
            gap: 14px;
            padding: 16px 18px;
            border-radius: 20px;
            background: rgba(15, 23, 42, 0.38);
            border: 1px solid rgba(148, 163, 184, 0.12);
        }

        .admin-login-point__icon {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(37, 99, 235, 0.14);
            color: #93c5fd;
        }

        .admin-login-point strong {
            display: block;
            margin-bottom: 6px;
            font-size: 1rem;
        }

        .admin-login-point span {
            display: block;
            color: rgba(226, 232, 240, 0.78);
            line-height: 1.6;
        }

        .admin-login-form {
            height: 100%;
            padding: 42px;
            background: var(--admin-login-card);
            color: var(--admin-login-ink);
        }

        .admin-login-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--admin-login-muted);
            font-weight: 700;
            text-decoration: none;
        }

        .admin-login-back:hover {
            color: var(--admin-login-accent);
        }

        .admin-login-form h2 {
            margin: 24px 0 12px;
            font-size: 2rem;
            font-weight: 800;
            line-height: 1.05;
        }

        .admin-login-form p {
            margin: 0 0 24px;
            color: var(--admin-login-muted);
            line-height: 1.7;
        }

        .admin-login-note,
        .admin-login-errors,
        .admin-login-status {
            padding: 14px 16px;
            border-radius: 18px;
            margin-bottom: 18px;
            font-size: 0.95rem;
        }

        .admin-login-note {
            background: rgba(37, 99, 235, 0.08);
            border: 1px solid rgba(37, 99, 235, 0.14);
            color: #1d4ed8;
        }

        .admin-login-status {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.18);
            color: #15803d;
        }

        .admin-login-errors {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.15);
            color: #b91c1c;
        }

        .admin-login-errors ul {
            margin: 0;
            padding-left: 18px;
        }

        .field-row {
            margin-bottom: 18px;
        }

        .field-row label {
            display: inline-block;
            margin-bottom: 10px;
            font-size: 0.92rem;
            font-weight: 700;
        }

        .field-shell {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 58px;
            padding: 0 16px;
            border: 1px solid var(--admin-login-line);
            border-radius: 18px;
            background: #fff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field-shell:focus-within {
            border-color: rgba(37, 99, 235, 0.32);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .field-shell i {
            color: var(--admin-login-accent);
        }

        .field-shell input {
            width: 100%;
            min-height: 56px;
            border: none;
            outline: none;
            background: transparent;
            color: var(--admin-login-ink);
        }

        .field-shell input::placeholder {
            color: #94a3b8;
        }

        .field-toggle {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border: none;
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.06);
            color: var(--admin-login-muted);
        }

        .field-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin: 4px 0 24px;
        }

        .field-meta a {
            color: var(--admin-login-accent);
            font-weight: 700;
            text-decoration: none;
        }

        .field-meta a:hover {
            color: var(--admin-login-accent-dark);
        }

        .submit-btn {
            width: 100%;
            min-height: 58px;
            border: none;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--admin-login-accent), var(--admin-login-accent-dark));
            color: #fff;
            font-size: 1rem;
            font-weight: 800;
            box-shadow: 0 18px 34px rgba(37, 99, 235, 0.24);
        }

        .submit-btn:hover {
            filter: brightness(1.04);
        }

        .admin-login-footer {
            margin-top: 22px;
            color: var(--admin-login-muted);
        }

        .admin-login-footer a {
            color: var(--admin-login-ink);
            font-weight: 700;
            text-decoration: none;
        }

        .admin-login-footer a:hover {
            color: var(--admin-login-accent);
        }

        @media (max-width: 991.98px) {
            .admin-login-side,
            .admin-login-form {
                padding: 28px 22px;
            }
        }
    </style>
</head>
<body>
<section class="admin-login-shell">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-11">
                <div class="admin-login-frame">
                    <div class="row g-0">
                        <div class="col-lg-7">
                            <div class="admin-login-side">
                                <a href="{{ route('home') }}" class="admin-login-brand">
                                    <span class="admin-login-brand__mark"><i class="bi bi-shield-lock"></i></span>
                                    <span>BroNix Admin</span>
                                </a>

                                <div class="admin-login-chip">
                                    <i class="bi bi-stars"></i>
                                    <span>Панель администратора</span>
                                </div>

                                <h1 class="admin-login-title">Управление всей платформой из одного кабинета</h1>
                                <div class="admin-login-copy">
                                    Авторизуйтесь как администратор, чтобы контролировать все бизнесы, категории и бронирования
                                    на платформе. После входа откроется админ-панель с полным обзором и быстрыми действиями.
                                </div>

                                <div class="admin-login-points">
                                    <div class="admin-login-point">
                                        <span class="admin-login-point__icon"><i class="bi bi-buildings"></i></span>
                                        <div>
                                            <strong>Все бизнесы под контролем</strong>
                                            <span>Редактируйте карточки компаний, проверяйте владельцев и следите за наполнением каталога.</span>
                                        </div>
                                    </div>
                                    <div class="admin-login-point">
                                        <span class="admin-login-point__icon"><i class="bi bi-calendar-check"></i></span>
                                        <div>
                                            <strong>Управление бронированиями</strong>
                                            <span>Просматривайте все записи клиентов, фильтруйте их и меняйте статусы прямо в панели.</span>
                                        </div>
                                    </div>
                                    <div class="admin-login-point">
                                        <span class="admin-login-point__icon"><i class="bi bi-diagram-3"></i></span>
                                        <div>
                                            <strong>Структура платформы</strong>
                                            <span>Поддерживайте актуальные типы бизнесов и быстро переходите между ключевыми разделами системы.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="admin-login-form">
                                <a href="{{ route('home') }}" class="admin-login-back">
                                    <i class="bi bi-arrow-left"></i>
                                    <span>На главную</span>
                                </a>

                                <h2>Вход для администратора</h2>
                                <p>Используйте учётную запись с ролью <strong>admin</strong>. После входа вы будете перенаправлены в админ-панель.</p>

                                <div class="admin-login-note">
                                    Доступ к этой форме предназначен только для администраторов платформы.
                                </div>

                                @if (session('status'))
                                    <div class="admin-login-status" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="admin-login-errors" role="alert">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('login') }}" method="POST">
                                    @csrf

                                    <div class="field-row">
                                        <label for="email">Email</label>
                                        <div class="field-shell">
                                            <i class="bi bi-at"></i>
                                            <input
                                                id="email"
                                                type="email"
                                                name="email"
                                                value="{{ old('email') }}"
                                                required
                                                autocomplete="username"
                                                autofocus
                                                placeholder="admin@example.com"
                                            >
                                        </div>
                                    </div>

                                    <div class="field-row">
                                        <label for="password">Пароль</label>
                                        <div class="field-shell">
                                            <i class="bi bi-lock"></i>
                                            <input
                                                id="password"
                                                type="password"
                                                name="password"
                                                required
                                                autocomplete="current-password"
                                                placeholder="Введите пароль"
                                            >
                                            <button
                                                class="field-toggle"
                                                type="button"
                                                data-password-toggle
                                                data-target="password"
                                                aria-label="Показать пароль"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="field-meta">
                                        <div class="form-check mb-0">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                id="remember"
                                                name="remember"
                                                {{ old('remember') ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="remember">Запомнить меня</label>
                                        </div>

                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}">Забыли пароль?</a>
                                        @endif
                                    </div>

                                    <button class="submit-btn" type="submit">Открыть админ-панель</button>
                                </form>

                                <div class="admin-login-footer">
                                    Нужен обычный кабинет?
                                    <a href="{{ route('login') }}">Перейти к стандартному входу</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('assets/public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.target);

            if (!input) {
                return;
            }

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            const icon = button.querySelector('i');

            if (icon) {
                icon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
            }
        });
    });
</script>
</body>
</html>
