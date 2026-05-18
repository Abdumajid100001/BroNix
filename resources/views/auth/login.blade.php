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
            --auth-accent: #eb6d2f;
            --auth-accent-soft: rgba(235, 109, 47, 0.16);
            --auth-highlight: #ffbf47;
            --auth-ink: #122238;
            --auth-muted: #61738c;
            --auth-line: rgba(18, 34, 56, 0.12);
            --auth-surface: rgba(255, 255, 255, 0.88);
            --auth-surface-strong: rgba(255, 255, 255, 0.96);
            --auth-navy: #10213a;
            --auth-ocean: #193d6b;
        }

        * {
            box-sizing: border-box;
        }

        body.auth-page {
            min-height: 100vh;
            margin: 0;
            font-family: "Manrope", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(255, 191, 71, 0.24), transparent 26%),
                radial-gradient(circle at right center, rgba(27, 94, 161, 0.18), transparent 28%),
                linear-gradient(135deg, #fff7f2 0%, #f7fbff 44%, #eef4ff 100%);
            color: var(--auth-ink);
        }

        body.auth-page::before {
            content: "";
            position: fixed;
            inset: 18px;
            border: 1px solid rgba(18, 34, 56, 0.06);
            border-radius: 32px;
            pointer-events: none;
        }

        .auth-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 28px 0;
        }

        .auth-frame {
            position: relative;
            overflow: hidden;
            border-radius: 36px;
            background: var(--auth-surface);
            border: 1px solid rgba(255, 255, 255, 0.45);
            box-shadow: 0 30px 90px rgba(18, 34, 56, 0.14);
            backdrop-filter: blur(18px);
        }

        .auth-form-panel {
            position: relative;
            z-index: 1;
            padding: 42px 38px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.88), var(--auth-surface-strong));
        }

        .auth-story-panel {
            position: relative;
            overflow: hidden;
            padding: 48px;
            color: #fff;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.14), transparent 26%),
                radial-gradient(circle at bottom left, rgba(255, 191, 71, 0.24), transparent 24%),
                linear-gradient(155deg, var(--auth-navy) 0%, var(--auth-ocean) 56%, #28538a 100%);
        }

        .auth-story-panel::after {
            content: "";
            position: absolute;
            right: -90px;
            bottom: -90px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
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

        .auth-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 38px;
            padding: 0 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            font-size: 0.86rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
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
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .story-title {
            margin: 22px 0 18px;
            font-size: clamp(2.5rem, 3vw, 4.2rem);
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

        .story-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 30px;
        }

        .story-stat {
            padding: 18px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
        }

        .story-stat strong {
            display: block;
            font-size: 1.55rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .story-stat span {
            display: block;
            color: rgba(255, 255, 255, 0.74);
            font-size: 0.92rem;
            line-height: 1.5;
        }

        .story-points {
            display: grid;
            gap: 14px;
            margin-top: 28px;
        }

        .story-point {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            padding: 16px 18px;
            border-radius: 22px;
            background: rgba(9, 19, 34, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .story-point__icon {
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--auth-highlight);
            font-size: 1rem;
        }

        .story-point strong {
            display: block;
            font-size: 1rem;
            margin-bottom: 6px;
        }

        .story-point span {
            display: block;
            color: rgba(255, 255, 255, 0.76);
            font-size: 0.93rem;
            line-height: 1.6;
        }

        .form-shell {
            max-width: 460px;
            margin-inline: auto;
        }

        .form-chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 36px;
            padding: 0 14px;
            border-radius: 999px;
            background: rgba(235, 109, 47, 0.09);
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
            border: 1px solid transparent;
            font-size: 0.95rem;
        }

        .auth-alert--success {
            background: rgba(37, 181, 129, 0.11);
            border-color: rgba(37, 181, 129, 0.18);
            color: #0f6e54;
        }

        .auth-alert--danger {
            background: rgba(220, 53, 69, 0.09);
            border-color: rgba(220, 53, 69, 0.14);
            color: #a62f43;
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
            border-color: rgba(235, 109, 47, 0.4);
            box-shadow: 0 0 0 4px rgba(235, 109, 47, 0.12);
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

        .meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin: 6px 0 24px;
            flex-wrap: wrap;
        }

        .form-check-label,
        .meta-link {
            font-size: 0.94rem;
        }

        .meta-link {
            color: var(--auth-ink);
            font-weight: 700;
            text-decoration: none;
        }

        .meta-link:hover {
            color: var(--auth-accent);
        }

        .submit-btn {
            width: 100%;
            min-height: 58px;
            border: none;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--auth-accent) 0%, #f08d2f 100%);
            color: #fff;
            font-size: 1rem;
            font-weight: 800;
            box-shadow: 0 16px 36px rgba(235, 109, 47, 0.26);
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
            border-color: rgba(235, 109, 47, 0.28);
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

            .story-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .story-title,
            .form-title {
                font-size: 1.95rem;
            }

            .story-stats,
            .social-grid {
                grid-template-columns: 1fr;
            }

            .meta-row {
                align-items: flex-start;
                flex-direction: column;
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
                                    <span class="brand-mark__icon"><i class="bi bi-stars"></i></span>
                                    <span>BroNix</span>
                                </a>

                                <div class="auth-kicker mt-4">
                                    <i class="bi bi-lightning-charge-fill"></i>
                                    <span>Панель управления бронированием</span>
                                </div>

                                <h1 class="story-title">Вход в BroNix без лишних кликов</h1>
                                <p class="story-copy">
                                    Управляйте каталогом, слотами записи и клиентскими заявками в одном ритме.
                                    Всё, что нужно для повседневной работы бизнеса, собрано в одном кабинете.
                                </p>

                                <div class="story-stats">
                                    <div class="story-stat">
                                        <strong>1</strong>
                                        <span>единая точка входа для владельца, клиента и команды</span>
                                    </div>
                                    <div class="story-stat">
                                        <strong>24/7</strong>
                                        <span>доступ к заказам, расписанию и данным с любого устройства</span>
                                    </div>
                                    <div class="story-stat">
                                        <strong>Live</strong>
                                        <span>актуальные заявки и движения по бронированиям без задержек</span>
                                    </div>
                                </div>

                                <div class="story-points">
                                    <div class="story-point">
                                        <span class="story-point__icon"><i class="bi bi-grid-1x2-fill"></i></span>
                                        <div>
                                            <strong>Быстрый обзор</strong>
                                            <span>Откройте кабинет и сразу увидите бизнесы, услуги и ближайшие действия.</span>
                                        </div>
                                    </div>
                                    <div class="story-point">
                                        <span class="story-point__icon"><i class="bi bi-calendar2-check-fill"></i></span>
                                        <div>
                                            <strong>Запись под контролем</strong>
                                            <span>Переходите от каталога к бронированию и оплате по единому сценарию.</span>
                                        </div>
                                    </div>
                                    <div class="story-point">
                                        <span class="story-point__icon"><i class="bi bi-shield-lock-fill"></i></span>
                                        <div>
                                            <strong>Безопасный доступ</strong>
                                            <span>Работайте через защищённую авторизацию и держите доступы в порядке.</span>
                                        </div>
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
                                        <i class="bi bi-box-arrow-in-right"></i>
                                        <span>Личный кабинет</span>
                                    </div>

                                    <h2 class="form-title">С возвращением</h2>
                                    <p class="form-copy">
                                        Введите данные аккаунта, чтобы продолжить работу с платформой, заявками и расписанием.
                                    </p>

                                    @if (session('status'))
                                        <div class="auth-alert auth-alert--success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="auth-alert auth-alert--danger" role="alert">
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
                                                    autofocus
                                                    placeholder="you@example.com"
                                                >
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

                                        <div class="meta-row">
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
                                                <a class="meta-link" href="{{ route('password.request') }}">Забыли пароль?</a>
                                            @endif
                                        </div>

                                        <button class="submit-btn" type="submit">Войти в кабинет</button>
                                    </form>

                                    <div class="divider">или продолжить через</div>

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
                                        Ещё нет аккаунта?
                                        <a href="{{ route('register') }}">Создать профиль</a>
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