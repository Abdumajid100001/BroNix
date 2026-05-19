<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход | BroNix</title>
    <meta name="description" content="Войдите в BroNix, чтобы управлять бизнесом, бронированиями и клиентскими заявками в одном кабинете.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/public/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/public/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/public/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/public/css/main.css') }}" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #ff6b35;
            --brand-gradient: linear-gradient(135deg, #ff6b35 0%, #ff4b1f 100%);
            --bg-gradient: radial-gradient(circle at 0% 0%, rgba(255, 107, 53, 0.08) 0%, transparent 40%),
                           radial-gradient(circle at 100% 100%, rgba(0, 75, 160, 0.05) 0%, transparent 40%),
                           linear-gradient(180deg, #f9fbff 0%, #f4f7fc 100%);
            --text-main: #1e2530;
            --text-muted: #627289;
            --border-color: rgba(0, 0, 0, 0.08);
            --card-bg: rgba(255, 255, 255, 0.85);
        }

        body.auth-page {
            min-height: 100vh;
            margin: 0;
            font-family: "Manrope", sans-serif;
            background: var(--bg-gradient);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-container {
            width: 100%;
            max-width: 1100px;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        /* Правая панель (Визуальная) */
        .auth-marketing-side {
            background: linear-gradient(145deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .auth-marketing-side::before {
            content: '';
            position: absolute;
            top: 0; right: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at 80% 20%, rgba(255, 107, 53, 0.15) 0%, transparent 50%);
            pointer-events: none;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            text-decoration: none;
        }

        .brand-logo i {
            color: var(--brand-primary);
        }

        .features-list {
            margin: 40px 0;
        }

        .feature-item {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .feature-icon {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-primary);
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .feature-text h5 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .feature-text p {
            font-size: 0.9rem;
            color: #94a3b8;
            margin: 0;
            line-height: 1.5;
        }

        /* Левая панель (Форма) */
        .auth-form-side {
            padding: 50px 60px;
        }

        @media (max-width: 991px) {
            .auth-form-side { padding: 40px 30px; }
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: color 0.2s;
            margin-bottom: 30px;
        }

        .back-link:hover { color: var(--brand-primary); }

        .form-header h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .form-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        /* Поля ввода */
        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group-custom label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i.prefix-icon {
            position: absolute;
            left: 16px;
            color: var(--text-muted);
            font-size: 1.1rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            background: #fff;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-main);
            transition: all 0.2s ease;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
        }

        .input-wrapper input:focus + i.prefix-icon {
            color: var(--brand-primary);
        }

        .password-toggle-btn {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
        }

        /* Кнопки и чекбоксы */
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 0.9rem;
        }

        .form-check-input:checked {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
        }

        .forgot-password {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
        }
        .forgot-password:hover { color: var(--brand-primary); }

        .btn-submit {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 14px;
            background: var(--brand-gradient);
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(255, 107, 53, 0.2);
            transition: transform 0.2s, filter 0.2s;
        }

        .btn-submit:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        /* Разделитель */
        .auth-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 24px 0;
            color: var(--text-muted);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .auth-divider::before, .auth-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }
        .auth-divider:not(:empty)::before { margin-right: .5em; }
        .auth-divider:not(:empty)::after { margin-left: .5em; }

        /* Социальные кнопки */
        .social-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 30px;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border: 1px solid var(--border-color);
            background: #fff;
            border-radius: 12px;
            color: var(--text-main);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-social:hover {
            background: #f8fafc;
            border-color: rgba(0,0,0,0.15);
        }

        .auth-footer {
            text-align: center;
            font-size: 0.9rem;
            color: var(--text-muted);
            margin: 0;
        }

        .auth-footer a {
            color: var(--brand-primary);
            text-decoration: none;
            font-weight: 700;
        }

        /* Кастомные алерты */
        .custom-alert {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .custom-alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fee2e2;
        }
        .custom-alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #dcfce7;
        }
    </style>
</head>
<body class="auth-page">

<div class="auth-container">
    <div class="row g-0">
        
        <!-- Левая сторона: Форма входа -->
        <div class="col-lg-6 order-2 order-lg-1">
            <div class="auth-form-side">
                <a href="{{ route('home') }}" class="back-link">
                    <i class="bi bi-arrow-left"></i> На главную
                </a>

                <div class="form-header">
                    <h2>С возвращением</h2>
                    <p>Введите данные аккаунта для доступа к панели BroNix</p>
                </div>

                <!-- Вывод статуса сессии -->
                @if (session('status'))
                    <div class="custom-alert custom-alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Вывод ошибок валидации -->
                @if ($errors->any())
                    <div class="custom-alert custom-alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Форма отправки -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="input-group-custom">
                        <label for="email">Email адрес</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username" autofocus placeholder="name@example.com">
                            <i class="bi bi-envelope prefix-icon"></i>
                        </div>
                    </div>

                    <div class="input-group-custom">
                        <label for="password">Пароль</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                            <i class="bi bi-shield-lock prefix-icon"></i>
                            <button class="password-toggle-btn" type="button" data-password-toggle data-target="password" aria-label="Показать пароль">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Запомнить меня</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="forgot-password" href="{{ route('password.request') }}">Забыли пароль?</a>
                        @endif
                    </div>

                    <button class="btn-submit" type="submit">Войти в личный кабинет</button>
                </form>

                <div class="auth-divider">или войти через</div>

                <div class="social-row">
                    <a class="btn-social" href="{{ route('social.redirect', ['provider' => 'google']) }}">
                        <i class="bi bi-google"></i> Google
                    </a>
                    <a class="btn-social" href="{{ route('social.redirect', ['provider' => 'github']) }}">
                        <i class="bi bi-github"></i> GitHub
                    </a>
                </div>

                <p class="auth-footer">
                    Ещё нет аккаунта? <a href="{{ route('register') }}">Создать профиль</a>
                </p>
            </div>
        </div>

        <!-- Правая сторона: Маркетинговый блок -->
        <div class="col-lg-6 order-1 order-lg-2 d-none d-lg-flex">
            <div class="auth-marketing-side w-100">
                <a href="{{ route('home') }}" class="brand-logo">
                    <i class="bi bi-lightning-charge-fill"></i>
                    <span>BroNix</span>
                </a>

                <div class="features-list">
                    <h3 class="mb-4" style="font-weight: 800; font-size: 1.8rem; line-height: 1.3;">Управляйте бронированиями без лишних кликов</h3>
                    
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-calendar-check"></i></div>
                        <div class="feature-text">
                            <h5>Контроль 24/7</h5>
                            <p>Доступ к расписанию, активным слотам и заказам в реальном времени с любого устройства.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <div class="feature-text">
                            <h5>Рост эффективности</h5>
                            <p>Единая точка входа для всей вашей команды, автоматические уведомления и аналитика.</p>
                        </div>
                    </div>
                </div>

                <div style="font-size: 0.85rem; color: #64748b;">
                    © {{ date('Y') }} BroNix. Все права защищены.
                </div>
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('assets/public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.target);
            if (!input) return;

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