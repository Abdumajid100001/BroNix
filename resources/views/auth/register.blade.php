<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация | BroNix</title>
    <meta name="description" content="Создайте аккаунт BroNix и начните управлять бронированиями.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/public/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/public/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/public/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/public/css/main.css') }}" rel="stylesheet">

    <style>
        :root {
            --brx-primary: #ff5a2b; /* Фирменный оранжевый */
            --brx-primary-hover: #e0481d;
            --brx-primary-soft: rgba(255, 90, 43, 0.06);
            --brx-dark-panel: #111625; /* Темный фон для Hero-блока */
            
            --brx-bg: #f8fafc;
            --brx-ink: #0f172a;
            --brx-muted: #64748b;
            --brx-line: rgba(15, 23, 42, 0.08);
            
            /* Настройки премиальной карточки */
            --card-bg: rgba(255, 255, 255, 0.9);
            --card-border: rgba(255, 255, 255, 0.7);
            --card-shadow: 0 30px 80px rgba(15, 23, 42, 0.08);
        }

        body.auth-page {
            min-height: 100vh;
            margin: 0;
            font-family: "Manrope", sans-serif;
            background-color: var(--brx-bg);
            color: var(--brx-ink);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 40px 20px;
        }

        /* Элегантное неоновое свечение на фоне (Aurora UI) */
        body.auth-page::before,
        body.auth-page::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.5;
            pointer-events: none;
            z-index: 1;
        }

        body.auth-page::before {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 90, 43, 0.12) 0%, transparent 70%);
            top: -10%;
            right: -10%;
        }

        body.auth-page::after {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(15, 23, 42, 0.04) 0%, transparent 70%);
            bottom: -15%;
            left: -10%;
        }

        .auth-container {
            width: 100%;
            max-width: 1050px; /* Ширина под двухколоночную карточку */
            position: relative;
            z-index: 10;
        }

        /* Центрированная двухколоночная карточка */
        .auth-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: 32px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        /* Левая сторона: Форма */
        .auth-form-column {
            padding: 45px 50px;
        }

        /* Правая сторона: Hero-блок преимуществ */
        .auth-hero-column {
            background: var(--brx-dark-panel);
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            position: relative;
        }

        /* Свечение внутри темного Hero-блока */
        .auth-hero-column::before {
            content: "";
            position: absolute;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255, 90, 43, 0.1) 0%, transparent 70%);
            top: -50px;
            right: -50px;
            pointer-events: none;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--brx-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: color 0.2s;
            margin-bottom: 24px;
        }
        .back-link:hover { color: var(--brx-ink); }

        .form-header h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 6px;
            letter-spacing: -0.03em;
            color: #0b132a;
        }

        .form-header p {
            color: var(--brx-muted);
            font-size: 0.95rem;
            margin-bottom: 28px;
        }

        /* Поля ввода (Input) */
        .input-group-custom {
            margin-bottom: 18px;
        }

        .input-group-custom label {
            display: block;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 7px;
            color: #334155;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i.input-icon {
            position: absolute;
            left: 16px;
            color: var(--brx-primary);
            font-size: 1.1rem;
            pointer-events: none;
        }

        .input-wrapper input {
            width: 100%;
            padding: 13px 16px 13px 46px;
            border: 1px solid var(--brx-line);
            border-radius: 14px;
            background: #f8fafc;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--brx-ink);
            transition: all 0.2s ease;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: var(--brx-primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(255, 90, 43, 0.08);
        }

        /* Выбор Ролей */
        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .role-card {
            position: relative;
            display: block;
            cursor: pointer;
        }

        .role-card input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .role-box {
            display: block;
            padding: 12px;
            border-radius: 14px;
            border: 1px solid var(--brx-line);
            background: #ffffff;
            text-align: center;
            transition: all 0.2s ease;
        }

        .role-box i {
            font-size: 1.2rem;
            display: block;
            margin-bottom: 4px;
            color: var(--brx-muted);
        }

        .role-box span {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--brx-muted);
        }

        .role-card:hover .role-box { border-color: #cbd5e1; }

        .role-card input:checked + .role-box {
            border-color: var(--brx-primary);
            background: var(--brx-primary-soft);
        }

        .role-card input:checked + .role-box i,
        .role-card input:checked + .role-box span {
            color: var(--brx-primary);
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: var(--brx-muted);
            cursor: pointer;
        }

        /* Кнопка отправки */
        .btn-submit {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #ff6b3d 0%, var(--brx-primary) 100%);
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            box-shadow: 0 8px 22px rgba(255, 90, 43, 0.15);
            transition: all 0.2s ease;
            cursor: pointer;
            margin-top: 8px;
        }

        .btn-submit:hover {
            filter: brightness(1.04);
            transform: translateY(-1px);
            box-shadow: 0 10px 24px rgba(255, 90, 43, 0.25);
        }

        /* Разделитель */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 22px 0 16px;
            color: #94a3b8;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
        }
        .divider::before, .divider::after { content: ""; flex: 1; border-bottom: 1px solid var(--brx-line); }
        .divider:not(:empty)::before { margin-right: 1.5em; }
        .divider:not(:empty)::after { margin-left: 1.5em; }

        /* Социальные кнопки */
        .social-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            border: 1px solid var(--brx-line);
            border-radius: 14px;
            background: #ffffff;
            color: var(--brx-ink);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-social:hover { background: #f1f5f9; border-color: #cbd5e1; }

        .form-footer {
            margin-top: 24px;
            text-align: center;
            font-size: 0.92rem;
            color: var(--brx-muted);
        }
        .form-footer a { color: var(--brx-primary); font-weight: 700; text-decoration: none; }
        .form-footer a:hover { text-decoration: underline; }

        /* СТИЛИ HERO СЕКЦИИ (Правая панель карточки) */
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffffff;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: -0.03em;
        }
        .brand-logo i { color: var(--brx-primary); }

        .info-title {
            color: #ffffff;
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.03em;
            margin: 40px 0;
        }

        .step-list {
            display: grid;
            gap: 24px;
        }

        .step-item {
            display: flex;
            gap: 18px;
            align-items: flex-start;
        }

        .step-icon {
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brx-primary);
            font-size: 1rem;
            flex-shrink: 0;
        }

        .step-text h4 {
            color: #ffffff;
            font-size: 1.05rem;
            font-weight: 700;
            margin: 0 0 4px 0;
        }

        .step-text p {
            color: #94a3b8;
            font-size: 0.9rem;
            line-height: 1.4;
            margin: 0;
        }

        .info-footer {
            color: #475569;
            font-size: 0.85rem;
            margin-top: 40px;
        }

        /* Адаптивность: на планшетах и мобилках прячем Hero-блок и оставляем только форму */
        @media (max-width: 991px) {
            .auth-hero-column { display: none; }
            .auth-card { max-width: 540px; margin: 0 auto; }
            .auth-form-column { padding: 35px 25px; }
        }

        @media (max-width: 575px) {
            .role-selector { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body class="auth-page">

<div class="auth-container">
    
    <div class="auth-card">
        <div class="row g-0">
            
            <div class="col-lg-6">
                <div class="auth-form-column">
                    <a href="{{ route('home') }}" class="back-link">
                        <i class="bi bi-arrow-left"></i> На главную
                    </a>

                    <div class="form-header">
                        <h2>Создать профиль</h2>
                        <p>Присоединяйтесь к BroNix и начните работу</p>
                    </div>

                    {{-- Ошибки валидации Laravel --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-4 py-3 mb-4" style="font-size: 0.85rem;">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="input-group-custom">
                            <label for="name">Ваше имя</label>
                            <div class="input-wrapper">
                                <i class="bi bi-person input-icon"></i>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Иван Иванов">
                            </div>
                        </div>

                        <div class="input-group-custom">
                            <label for="email">Email адрес</label>
                            <div class="input-wrapper">
                                <i class="bi bi-envelope input-icon"></i>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="user@gmail.com">
                            </div>
                        </div>

                        <div class="input-group-custom">
                            <label>Кто вы?</label>
                            <div class="role-selector">
                                <label class="role-card">
                                    <input type="radio" name="account_type" value="user" {{ old('account_type', 'user') === 'user' ? 'checked' : '' }}>
                                    <span class="role-box">
                                        <i class="bi bi-emoji-smile"></i>
                                        <span>Я клиент</span>
                                    </span>
                                </label>
                                <label class="role-card">
                                    <input type="radio" name="account_type" value="owner" {{ old('account_type') === 'owner' ? 'checked' : '' }}>
                                    <span class="role-box">
                                        <i class="bi bi-briefcase"></i>
                                        <span>Я бизнес</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="input-group-custom">
                            <label for="password">Пароль</label>
                            <div class="input-wrapper">
                                <i class="bi bi-shield-lock input-icon"></i>
                                <input type="password" id="password" name="password" required placeholder="••••••••">
                                <button class="password-toggle" type="button" data-password-toggle data-target="password" aria-label="Показать пароль">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button class="btn-submit" type="submit">Зарегистрироваться</button>
                    </form>

                    <div class="divider">или через соцсети</div>

                    <div class="social-row">
                        <a class="btn-social" href="{{ route('social.redirect', ['provider' => 'google']) }}">
                            <i class="bi bi-google text-danger"></i> Google
                        </a>
                        <a class="btn-social" href="{{ route('social.redirect', ['provider' => 'github']) }}">
                            <i class="bi bi-github"></i> GitHub
                        </a>
                    </div>

                    <p class="form-footer">
                        Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
                    </p>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block">
                <div class="auth-hero-column">
                    <a href="{{ route('home') }}" class="brand-logo">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <span>BroNix</span>
                    </a>

                    <div class="info-body">
                        <h1 class="info-title">Удобное бронирование начинается здесь</h1>
                        
                        <div class="step-list">
                            <div class="step-item">
                                <div class="step-icon"><i class="bi bi-1-circle"></i></div>
                                <div class="step-text">
                                    <h4>Создайте аккаунт</h4>
                                    <p>Это займет не более 30 секунд. Все данные надежно защищены.</p>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-icon"><i class="bi bi-2-circle"></i></div>
                                <div class="step-text">
                                    <h4>Настройте профиль</h4>
                                    <p>Добавьте свои данные или информацию о вашем бизнесе.</p>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-icon"><i class="bi bi-3-circle"></i></div>
                                <div class="step-text">
                                    <h4>Начните работу</h4>
                                    <p>Бронируйте услуги или принимайте заказы от клиентов в один клик.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-footer">
                        <span>© {{ date('Y') }} BroNix. Платформа для вашего роста.</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script src="{{ asset('assets/public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    // Переключение видимости пароля
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