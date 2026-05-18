<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация | BroNix</title>
    <meta name="description" content="Создайте аккаунт BroNix и начните работать с каталогом, онлайн-записью и клиентскими заявками в одном кабинете.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/public/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/public/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/public/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/public/css/main.css') }}" rel="stylesheet">

    <style>
        :root {
            --auth-accent: #1a9b6b;
            --auth-accent-soft: rgba(26, 155, 107, 0.14);
            --auth-highlight: #7dd7ff;
            --auth-ink: #122238;
            --auth-muted: #61738c;
            --auth-line: rgba(18, 34, 56, 0.12);
            --auth-surface: rgba(255, 255, 255, 0.9);
            --auth-surface-strong: rgba(255, 255, 255, 0.97);
            --auth-deep: #10213a;
            --auth-forest: #154f57;
        }

        * {
            box-sizing: border-box;
        }

        body.auth-page {
            min-height: 100vh;
            margin: 0;
            font-family: "Manrope", sans-serif;
            background:
                radial-gradient(circle at top right, rgba(125, 215, 255, 0.22), transparent 28%),
                radial-gradient(circle at bottom left, rgba(26, 155, 107, 0.18), transparent 26%),
                linear-gradient(135deg, #f5fffb 0%, #f3fbff 48%, #eef5ff 100%);
            color: var(--auth-ink);
        }

        body.auth-page::before {
            content: "";
            position: fixed;
            inset: 18px;
            border-radius: 32px;
            border: 1px solid rgba(18, 34, 56, 0.06);
            pointer-events: none;
        }

        .auth-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 28px 0;
        }

        .auth-frame {
            overflow: hidden;
            border-radius: 36px;
            background: var(--auth-surface);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 30px 90px rgba(18, 34, 56, 0.14);
            backdrop-filter: blur(18px);
        }

        .auth-form-panel {
            padding: 42px 38px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.88), var(--auth-surface-strong));
        }

        .auth-story-panel {
            position: relative;
            overflow: hidden;
            padding: 48px;
            color: #fff;
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.12), transparent 24%),
                radial-gradient(circle at bottom right, rgba(125, 215, 255, 0.22), transparent 22%),
                linear-gradient(155deg, var(--auth-deep) 0%, #155b69 52%, #1a9b6b 100%);
        }

        .auth-story-panel::after {
            content: "";
            position: absolute;
            left: -90px;
            bottom: -90px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .brand-mark {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: inherit;
            font-weight: 800;
            font-size: 1.1rem;
        }

        .brand-mark__icon {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .auth-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 38px;
            padding: 0 16px;
            margin-top: 24px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            font-size: 0.86rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .story-title {
            margin: 22px 0 18px;
            font-size: clamp(2.45rem, 3vw, 4.15rem);
            line-height: 0.96;
            font-weight: 800;
            max-width: 560px;
        }

        .story-copy {
            max-width: 560px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            line-height: 1.75;
        }

        .story-flow {
            display: grid;
            gap: 14px;
            margin-top: 28px;
        }

        .story-step {
            position: relative;
            display: grid;
            grid-template-columns: 54px 1fr;
            gap: 14px;
            align-items: start;
            padding: 18px;
            border-radius: 24px;
            background: rgba(11, 25, 42, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .story-step__index {
            width: 54px;
            height: 54px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.12);
            color: var(--auth-highlight);
            font-weight: 800;
            font-size: 1.15rem;
        }

        .story-step strong {
            display: block;
            font-size: 1rem;
            margin-bottom: 6px;
        }

        .story-step span {
            display: block;
            color: rgba(255, 255, 255, 0.76);
            font-size: 0.93rem;
            line-height: 1.6;
        }

        .story-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 28px;
        }

        .story-stat {
            padding: 18px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .story-stat strong {
            display: block;
            font-size: 1.45rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .story-stat span {
            display: block;
            color: rgba(255, 255, 255, 0.74);
            font-size: 0.92rem;
            line-height: 1.5;
        }

        .auth-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--auth-ink);
            text-decoration: none;
            font-weight: 700;
        }

        .auth-back:hover {
            color: var(--auth-accent);
        }

        .form-shell {
            max-width: 470px;
            margin-inline: auto;
        }

        .form-chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 36px;
            padding: 0 14px;
            border-radius: 999px;
            background: var(--auth-accent-soft);
            color: var(--auth-accent);
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .form-title {
            margin: 18px 0 12px;
            font-size: 2.2rem;
            line-height: 1.02;
            font-weight: 800;
        }

        .form-copy {
            margin: 0 0 26px;
            color: var(--auth-muted);
            line-height: 1.75;
        }

        .auth-alert {
            padding: 14px 16px;
            border-radius: 18px;
            margin-bottom: 18px;
            border: 1px solid rgba(220, 53, 69, 0.14);
            background: rgba(220, 53, 69, 0.09);
            color: #a62f43;
            font-size: 0.95rem;
        }

        .auth-alert ul {
            margin: 0;
            padding-left: 18px;
        }

        .field-row {
            margin-bottom: 18px;
        }

        .field-label {
            display: inline-block;
            margin-bottom: 10px;
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--auth-ink);
        }

        .field-shell {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 60px;
            padding: 0 16px;
            border-radius: 18px;
            background: #fff;
            border: 1px solid var(--auth-line);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .field-shell:focus-within {
            border-color: rgba(26, 155, 107, 0.38);
            box-shadow: 0 0 0 4px rgba(26, 155, 107, 0.12);
            transform: translateY(-1px);
        }

        .field-icon {
            color: var(--auth-accent);
            font-size: 1rem;
        }

        .field-shell input {
            flex: 1;
            min-height: 58px;
            border: none;
            background: transparent;
            color: var(--auth-ink);
            font-size: 0.98rem;
            outline: none;
            box-shadow: none;
            padding: 0;
        }

        .field-shell input::placeholder {
            color: #90a0b4;
        }

        .field-toggle {
            flex-shrink: 0;
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 12px;
            background: rgba(18, 34, 56, 0.05);
            color: var(--auth-muted);
        }

        .role-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .role-card {
            display: block;
            margin: 0;
            cursor: pointer;
        }

        .role-card__input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .role-card__body {
            display: flex;
            flex-direction: column;
            gap: 10px;
            height: 100%;
            padding: 18px;
            border-radius: 22px;
            border: 1px solid var(--auth-line);
            background: rgba(255, 255, 255, 0.82);
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease, background-color 0.2s ease;
        }

        .role-card:hover .role-card__body {
            transform: translateY(-1px);
        }

        .role-card__input:checked + .role-card__body {
            border-color: rgba(26, 155, 107, 0.34);
            background: rgba(26, 155, 107, 0.08);
            box-shadow: 0 16px 36px rgba(26, 155, 107, 0.14);
            transform: translateY(-2px);
        }

        .role-card__icon {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(26, 155, 107, 0.1);
            color: var(--auth-accent);
            font-size: 1rem;
        }

        .role-card__title {
            display: block;
            font-size: 1rem;
            font-weight: 800;
            color: var(--auth-ink);
        }

        .role-card__text {
            display: block;
            color: var(--auth-muted);
            font-size: 0.92rem;
            line-height: 1.6;
        }

        .password-note {
            margin-top: 10px;
            color: var(--auth-muted);
            font-size: 0.86rem;
            line-height: 1.6;
        }

        .submit-btn {
            width: 100%;
            min-height: 58px;
            border: none;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--auth-accent) 0%, #157b93 100%);
            color: #fff;
            font-size: 1rem;
            font-weight: 800;
            box-shadow: 0 16px 38px rgba(26, 155, 107, 0.24);
        }

        .submit-btn:hover {
            filter: brightness(1.02);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 26px 0 18px;
            color: var(--auth-muted);
            font-size: 0.88rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--auth-line);
        }

        .social-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .social-btn {
            min-height: 54px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 18px;
            border: 1px solid var(--auth-line);
            background: #fff;
            color: var(--auth-ink);
            text-decoration: none;
            font-weight: 700;
            transition: border-color 0.2s ease, transform 0.2s ease, color 0.2s ease;
        }

        .social-btn:hover {
            border-color: rgba(26, 155, 107, 0.28);
            color: var(--auth-accent);
            transform: translateY(-1px);
        }

        .auth-footer {
            margin-top: 22px;
            color: var(--auth-muted);
            font-size: 0.95rem;
        }

        .auth-footer a {
            color: var(--auth-ink);
            font-weight: 800;
            text-decoration: none;
        }

        .auth-footer a:hover {
            color: var(--auth-accent);
        }

        @media (max-width: 1199.98px) {
            .auth-story-panel,
            .auth-form-panel {
                padding: 36px;
            }
        }

        @media (max-width: 991.98px) {
            body.auth-page::before {
                inset: 10px;
                border-radius: 24px;
            }

            .auth-frame {
                border-radius: 28px;
            }

            .auth-story-panel,
            .auth-form-panel {
                padding: 30px 24px;
            }
        }

        @media (max-width: 575.98px) {
            .form-title,
            .story-title {
                font-size: 1.95rem;
            }

            .role-grid,
            .story-stats,
            .social-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="auth-page">
<section class="auth-shell">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-11">
                <div class="auth-frame">
                    <div class="row g-0 align-items-stretch">
                        <div class="col-lg-7 order-2 order-lg-1">
                            <div class="auth-story-panel h-100">
                                <a href="{{ route('home') }}" class="brand-mark">
                                    <span class="brand-mark__icon"><i class="bi bi-calendar2-check"></i></span>
                                    <span>BroNix</span>
                                </a>

                                <div class="auth-kicker">
                                    <i class="bi bi-stars"></i>
                                    <span>Новый аккаунт</span>
                                </div>

                                <h1 class="story-title">Создайте профиль и соберите свою витрину за пару минут</h1>
                                <p class="story-copy">
                                    Регистрация в BroNix открывает доступ к каталогу, бронированиям и управлению услугами.
                                    Выберите роль и сразу начните работать в подходящем сценарии.
                                </p>

                                <div class="story-flow">
                                    <div class="story-step">
                                        <span class="story-step__index">1</span>
                                        <div>
                                            <strong>Выберите тип аккаунта</strong>
                                            <span>Клиенту нужен быстрый доступ к записям, владельцу — управление бизнесом и расписанием.</span>
                                        </div>
                                    </div>
                                    <div class="story-step">
                                        <span class="story-step__index">2</span>
                                        <div>
                                            <strong>Заполните базовые данные</strong>
                                            <span>Имя, email и пароль создают основу для безопасного входа и персонального кабинета.</span>
                                        </div>
                                    </div>
                                    <div class="story-step">
                                        <span class="story-step__index">3</span>
                                        <div>
                                            <strong>Запускайте работу сразу</strong>
                                            <span>После регистрации можно переходить к каталогу, бронированию и настройке своего профиля.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="story-stats">
                                    <div class="story-stat">
                                        <strong>2 роли</strong>
                                        <span>клиентский и бизнес-сценарий внутри одной платформы</span>
                                    </div>
                                    <div class="story-stat">
                                        <strong>1 старт</strong>
                                        <span>регистрация без лишних шагов и дублирующих экранов</span>
                                    </div>
                                    <div class="story-stat">
                                        <strong>Гибко</strong>
                                        <span>подходит для записи, каталога и управления услугами</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 order-1 order-lg-2">
                            <div class="auth-form-panel h-100 d-flex align-items-center">
                                <div class="form-shell w-100">
                                    <a href="{{ route('home') }}" class="auth-back mb-4">
                                        <i class="bi bi-arrow-left"></i>
                                        <span>На главную</span>
                                    </a>

                                    <div class="form-chip">
                                        <i class="bi bi-person-plus-fill"></i>
                                        <span>Регистрация</span>
                                    </div>

                                    <h2 class="form-title">Создайте аккаунт</h2>
                                    <p class="form-copy">
                                        Заполните форму ниже и выберите роль, с которой хотите начать работу в BroNix.
                                    </p>

                                    @if ($errors->any())
                                        <div class="auth-alert" role="alert">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="field-row">
                                            <label for="name" class="field-label">Имя</label>
                                            <div class="field-shell">
                                                <span class="field-icon"><i class="bi bi-person"></i></span>
                                                <input
                                                    id="name"
                                                    type="text"
                                                    name="name"
                                                    value="{{ old('name') }}"
                                                    required
                                                    autocomplete="name"
                                                    autofocus
                                                    placeholder="Введите ваше имя"
                                                >
                                            </div>
                                        </div>

                                        <div class="field-row">
                                            <label for="email" class="field-label">Email</label>
                                            <div class="field-shell">
                                                <span class="field-icon"><i class="bi bi-at"></i></span>
                                                <input
                                                    id="email"
                                                    type="email"
                                                    name="email"
                                                    value="{{ old('email') }}"
                                                    required
                                                    autocomplete="username"
                                                    placeholder="you@example.com"
                                                >
                                            </div>
                                        </div>

                                        <div class="field-row">
                                            <span class="field-label">Тип аккаунта</span>
                                            <div class="role-grid">
                                                <label class="role-card">
                                                    <input
                                                        class="role-card__input"
                                                        type="radio"
                                                        name="account_type"
                                                        value="user"
                                                        {{ old('account_type', 'user') === 'user' ? 'checked' : '' }}
                                                    >
                                                    <span class="role-card__body">
                                                        <span class="role-card__icon"><i class="bi bi-person"></i></span>
                                                        <span class="role-card__title">Клиент</span>
                                                        <span class="role-card__text">Для поиска услуг, записи и управления своими бронированиями.</span>
                                                    </span>
                                                </label>

                                                <label class="role-card">
                                                    <input
                                                        class="role-card__input"
                                                        type="radio"
                                                        name="account_type"
                                                        value="owner"
                                                        {{ old('account_type') === 'owner' ? 'checked' : '' }}
                                                    >
                                                    <span class="role-card__body">
                                                        <span class="role-card__icon"><i class="bi bi-building"></i></span>
                                                        <span class="role-card__title">Владелец</span>
                                                        <span class="role-card__text">Для добавления бизнеса, услуг, расписания и управления заявками.</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="field-row">
                                            <label for="password" class="field-label">Пароль</label>
                                            <div class="field-shell">
                                                <span class="field-icon"><i class="bi bi-lock"></i></span>
                                                <input
                                                    id="password"
                                                    type="password"
                                                    name="password"
                                                    required
                                                    autocomplete="new-password"
                                                    placeholder="Придумайте пароль"
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
                                            <div class="password-note">Используйте не менее 8 символов, чтобы аккаунт был защищённее.</div>
                                        </div>

                                        <div class="field-row">
                                            <label for="password_confirmation" class="field-label">Повторите пароль</label>
                                            <div class="field-shell">
                                                <span class="field-icon"><i class="bi bi-shield-check"></i></span>
                                                <input
                                                    id="password_confirmation"
                                                    type="password"
                                                    name="password_confirmation"
                                                    required
                                                    autocomplete="new-password"
                                                    placeholder="Повторите пароль"
                                                >
                                                <button
                                                    class="field-toggle"
                                                    type="button"
                                                    data-password-toggle
                                                    data-target="password_confirmation"
                                                    aria-label="Показать пароль"
                                                >
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <button class="submit-btn" type="submit">Создать аккаунт</button>
                                    </form>

                                    <div class="divider">или зарегистрироваться через</div>

                                    <div class="social-grid">
                                        <a class="social-btn" href="{{ route('social.redirect', ['provider' => 'google']) }}">
                                            <i class="bi bi-google"></i>
                                            <span>Google</span>
                                        </a>
                                        <a class="social-btn" href="{{ route('social.redirect', ['provider' => 'github']) }}">
                                            <i class="bi bi-github"></i>
                                            <span>GitHub</span>
                                        </a>
                                    </div>

                                    <p class="auth-footer mb-0">
                                        Уже есть аккаунт?
                                        <a href="{{ route('login') }}">Войти</a>
                                    </p>
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