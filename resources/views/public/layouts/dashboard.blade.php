<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Bronix | Бесплатное приложение</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css2?family=inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef8ff',
                            100: '#d9eeff',
                            200: '#bce2ff',
                            300: '#8ed1ff',
                            400: '#59b6ff',
                            500: '#3b98ff',
                            600: '#1b75f5',
                            700: '#145fe1',
                            800: '#174db7',
                            900: '#19438f',
                            950: '#132957',
                        },
                        dark: {
                            900: '#0a0e1a',
                            800: '#0f1525',
                            700: '#161d30',
                            600: '#1e2640',
                            500: '#283250',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes gradientMove {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .shimmer-text {
            background: linear-gradient(90deg, #3b98ff 0%, #8ed1ff 25%, #3b98ff 50%, #8ed1ff 75%, #3b98ff 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 4s linear infinite;
        }
        .gradient-border {
            position: relative;
        }
        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(135deg, rgba(59,152,255,0.4), rgba(142,209,255,0.1), rgba(59,152,255,0.4));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }
        .glass {
            background: rgba(15, 21, 37, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .glass-light {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
        }
        .nav-link-hover {
            position: relative;
        }
        .nav-link-hover::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b98ff, #8ed1ff);
            border-radius: 1px;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link-hover:hover::after,
        .nav-link-hover.active::after {
            width: 100%;
        }
        .btn-glow {
            box-shadow: 0 0 20px rgba(59, 152, 255, 0.3), 0 0 40px rgba(59, 152, 255, 0.1);
            transition: all 0.3s ease;
        }
        .btn-glow:hover {
            box-shadow: 0 0 30px rgba(59, 152, 255, 0.5), 0 0 60px rgba(59, 152, 255, 0.2);
            transform: translateY(-2px);
        }
        .bg-grid {
            background-image:
                linear-gradient(rgba(59,152,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59,152,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .dropdown-animate {
            animation: slideDown 0.2s ease forwards;
        }
        .mobile-menu {
            animation: slideUp 0.3s ease forwards;
        }
        .lang-pill:hover {
            background: rgba(59, 152, 255, 0.1);
            border-color: rgba(59, 152, 255, 0.3);
        }
        .mobile-nav-toggle {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .mobile-nav-toggle:hover {
            transform: scale(1.1);
            color: #3b98ff;
        }
        .hero-gradient {
            background: radial-gradient(ellipse at 50% 0%, rgba(59,152,255,0.15) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 50%, rgba(142,209,255,0.08) 0%, transparent 50%),
                        radial-gradient(ellipse at 20% 80%, rgba(59,152,255,0.06) 0%, transparent 50%);
        }
    </style>
</head>

<body class="bg-dark-900 text-white font-sans antialiased overflow-x-hidden">
    <!-- Header -->
    <header id="header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500" :class="{ 'scrolled': isScrolled }">
        <div id="headerBg" class="absolute inset-0 transition-all duration-500"></div>

        <!-- Bottom border line -->
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brand-500/30 to-transparent"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-3 group">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-lg shadow-brand-500/25 transition-all duration-300 group-hover:shadow-brand-500/40 group-hover:scale-105">
                            <span class="text-white font-black text-lg leading-none">B</span>
                        </div>
                        <div class="absolute -inset-0.5 rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 opacity-0 group-hover:opacity-20 blur-sm transition-opacity duration-300"></div>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-lg font-bold bg-gradient-to-r from-white via-white to-white/80 bg-clip-text text-transparent">Bronix</span>
                        <span class="block text-[10px] font-medium text-brand-400/80 tracking-wider uppercase -mt-0.5">Бесплатное приложение</span>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden xl:flex items-center">
                    <ul class="flex items-center gap-1">
                        <li>
                            <a href="#" class="nav-link-hover active relative px-4 py-2 text-sm font-medium text-brand-400 transition-colors duration-200">
                                Главная страница
                            </a>
                        </li>
                        <li>
                            <a href="{{route('business.page')}}" class="nav-link-hover relative px-4 py-2 text-sm font-medium text-slate-300 hover:text-white transition-colors duration-200">
                                Бизнесы
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link-hover relative px-4 py-2 text-sm font-medium text-slate-300 hover:text-white transition-colors duration-200">
                                Бронирование
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link-hover relative px-4 py-2 text-sm font-medium text-slate-300 hover:text-white transition-colors duration-200">
                                Контакт
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Right Actions -->
                <div class="flex items-center gap-3">
                    <!-- Language Selector -->
                    <div class="relative" id="langDropdown">
                        <button type="button" onclick="toggleLangDropdown()" class="lang-pill flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-300 bg-white/5 border border-white/10 rounded-full hover:text-white transition-all duration-200">
                            <i class="bi bi-globe text-[10px] text-brand-400"></i>
                            <span>RU</span>
                            <i class="bi bi-chevron-down text-[8px] opacity-50 transition-transform duration-200" id="langArrow"></i>
                        </button>

                        <div id="langMenu" class="hidden absolute right-0 top-full mt-2 w-44 rounded-xl border border-white/10 bg-dark-800/95 backdrop-blur-xl shadow-2xl shadow-black/50 overflow-hidden z-50">
                            <div class="p-1.5">
                                <a href="#" class="flex items-center gap-2.5 px-3 py-2 text-sm text-white bg-brand-500/10 rounded-lg transition-colors">
                                    <span class="w-5 h-5 rounded-full bg-brand-500/20 flex items-center justify-center text-[10px]">🇺🇸</span>
                                    English
                                    <i class="bi bi-check2 text-brand-400 ml-auto"></i>
                                </a>
                                <a href="#" class="flex items-center gap-2.5 px-3 py-2 text-sm text-slate-300 hover:text-white hover:bg-white/5 rounded-lg transition-colors">
                                    <span class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center text-[10px]">🇷🇺</span>
                                    Русский
                                </a>
                                <a href="#" class="flex items-center gap-2.5 px-3 py-2 text-sm text-slate-300 hover:text-white hover:bg-white/5 rounded-lg transition-colors">
                                    <span class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center text-[10px]">tj</span>
                                    Таджикскый
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <a href="{{ route('login') }}" class="hidden sm:flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-300 border border-white/10 rounded-xl hover:text-white hover:border-white/20 hover:bg-white/5 transition-all duration-200">
                        <i class="bi bi-box-arrow-in-right text-sm"></i>
                        <span>Войти</span>
                    </a>

                    <!-- Register Button -->
                    <a href="{{route('register')}}" class="hidden sm:flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-brand-600 to-brand-500 rounded-xl btn-glow hover:from-brand-500 hover:to-brand-400 transition-all duration-300">
                        <i class="bi bi-rocket-takeoff text-sm"></i>
                        <span>Старт</span>
                    </a>

                    <!-- Mobile Menu Toggle -->
                    <button onclick="toggleMobileMenu()" class="xl:hidden mobile-nav-toggle p-2 text-slate-300 hover:text-white rounded-lg hover:bg-white/5 transition-all" id="mobileToggle">
                        <i class="bi bi-list text-2xl" id="menuIcon"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <!-- Mobile Menu -->

    <!-- Spacer for fixed header -->
    <div class="h-20"></div>

    <!-- Hero Section (for context) -->
    <section class="relative min-h-[calc(100vh-5rem)] flex items-center justify-center hero-gradient bg-grid overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-brand-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-brand-400/5 rounded-full blur-3xl"></div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-8 text-xs font-semibold text-brand-300 bg-brand-500/10 border border-brand-500/20 rounded-full">
                <span class="w-2 h-2 bg-brand-400 rounded-full animate-pulse"></span>
                Бесплатная бизнес-платформа
            </div>

            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black tracking-tight mb-6">
                <span class="text-white">Создайте свою</span><br>
                <span class="shimmer-text">Бизнес Империю</span>
            </h1>

            <p class="max-w-2xl mx-auto text-base sm:text-lg text-slate-400 mb-10 leading-relaxed">
                Мощная бесплатная платформа для управления бронированиями, демонстрации вашего бизнеса и связи с клиентами по всему миру.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{route('register')}}" class="w-full sm:w-auto px-8 py-4 text-sm font-bold text-white bg-gradient-to-r from-brand-600 to-brand-500 rounded-xl btn-glow hover:from-brand-500 hover:to-brand-400 transition-all duration-300 flex items-center justify-center gap-2">
                    <i class="bi bi-rocket-takeoff text-lg"></i>
                    <span>Начните бесплатно сегодня</span>
                </a>
                <a href="#" class="w-full sm:w-auto px-8 py-4 text-sm font-semibold text-slate-300 border border-white/10 rounded-xl hover:text-white hover:border-white/20 hover:bg-white/5 transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="bi bi-play-circle text-lg"></i>
                    <span>Посмотреть демо</span>
                </a>
            </div>

            <!-- Stats -->
            <div class="mt-20 grid grid-cols-3 gap-8 max-w-lg mx-auto">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-black text-white">10K+</div>
                    <div class="text-xs text-slate-500 mt-1">Бизнесы</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-black text-white">50K+</div>
                    <div class="text-xs text-slate-500 mt-1">Бронирование</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-black text-white">99%</div>
                    <div class="text-xs text-slate-500 mt-1">Комфорт</div>
                </div>
            </div>
        </div>
    </section>
<br>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Title -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 text-xs font-bold text-brand-300 bg-brand-500/10 border border-brand-500/20 rounded-full">
                    <span class="w-2 h-2 bg-brand-400 rounded-full animate-pulse"></span>
                    Найдите лучшие бизнесы
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight mb-4">
                    <span class="text-white dark:text-white">Наши</span>
                    <span class="shimmer-text"> Партнёры</span>
                </h1>
                <p class="max-w-2xl mx-auto text-base font-bold text-slate-400 dark:text-slate-400">
                    Лучшие бизнесы вашего города с онлайн-бронированием
                </p>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

                <!-- Card 1: Barber House -->
                <div class="fade-in-up card-hover rounded-2xl overflow-hidden bg-[#1e293b] dark:bg-[#1e293b] border border-white/10 shadow-xl shadow-black/20">
                    <!-- Card Header with Gradient -->
                    <div class="relative h-56 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-800 overflow-hidden">
                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 text-xs font-bold text-black bg-white/90 rounded-full shadow-lg">Барбершоп</span>
                        </div>
                        <!-- Status Badge -->
                        <div class="absolute top-4 right-4">
                            <span class="flex items-center gap-1.5 px-3 py-1 text-xs font-bold text-green-600 bg-white/90 rounded-full shadow-lg">
                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                Открыто
                            </span>
                        </div>
                        <!-- Icon -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-24 h-24 rounded-full bg-white/10 backdrop-blur-sm flex items-center justify-center border border-white/20">
                                <i class="bi bi-scissors text-4xl text-white/60"></i>
                            </div>
                        </div>
                        <!-- Business Name Overlay -->
                        <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/60 to-transparent">
                            <span class="px-3 py-1 text-xs font-bold text-white/80 bg-white/10 rounded-full backdrop-blur-sm">BARBER HOUSE</span>
                        </div>
                        <!-- Heart Button -->
                        <button class="absolute bottom-4 right-4 w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30 hover:bg-white/30 transition-all">
                            <i class="bi bi-heart text-white text-sm"></i>
                        </button>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5">
                        <!-- Title -->
                        <div class="mb-3">
                            <h3 class="text-lg font-black text-black dark:text-white mb-2">Barber House Premium</h3>
                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-1">
                                    <i class="bi bi-star-fill text-amber-400 text-sm"></i>
                                    <span class="text-sm font-black text-black dark:text-white">4.8</span>
                                </div>
                                <span class="text-xs font-bold text-slate-400">(124 отзыва)</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-4 leading-relaxed">
                            Премиальный барбершоп с опытными мастерами. Стрижки, бритьё и уход за бородой на высшем уровне.
                        </p>

                        <!-- Address & Phone -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-geo-alt-fill text-brand-400 text-sm"></i>
                                <span class="text-sm font-bold text-black dark:text-slate-200">ул. Рудаки 45, Душанбе</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="bi bi-telephone-fill text-brand-400 text-sm"></i>
                                <span class="text-sm font-bold text-black dark:text-slate-200">+992 901 234 567</span>
                            </div>
                        </div>

                        <!-- Schedule -->
                        <div class="rounded-xl bg-[#f1f5f9] dark:bg-[#161d30] p-4 mb-4">
                            <div class="flex items-center justify-between mb-3">
                                <span class="flex items-center gap-2 text-sm font-black text-green-600">
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    Открыто сейчас
                                </span>
                                <span class="text-xs font-bold text-slate-400">09:00 - 21:00</span>
                            </div>
                            <div class="flex gap-1.5">
                                <button class="day-btn w-8 h-8 rounded-lg text-xs font-bold bg-white dark:bg-[#1e2640] text-slate-500 dark:text-slate-300 border border-slate-200 dark:border-white/10">Пн</button>
                                <button class="day-btn w-8 h-8 rounded-lg text-xs font-bold bg-white dark:bg-[#1e2640] text-slate-500 dark:text-slate-300 border border-slate-200 dark:border-white/10">Вт</button>
                                <button class="day-btn active w-8 h-8 rounded-lg text-xs font-bold">Ср</button>
                                <button class="day-btn w-8 h-8 rounded-lg text-xs font-bold bg-white dark:bg-[#1e2640] text-slate-500 dark:text-slate-300 border border-slate-200 dark:border-white/10">Чт</button>
                                <button class="day-btn w-8 h-8 rounded-lg text-xs font-bold bg-white dark:bg-[#1e2640] text-slate-500 dark:text-slate-300 border border-slate-200 dark:border-white/10">Пт</button>
                                <button class="day-btn w-8 h-8 rounded-lg text-xs font-bold bg-white dark:bg-[#1e2640] text-slate-500 dark:text-slate-300 border border-slate-200 dark:border-white/10">Сб</button>
                                <button class="day-btn w-8 h-8 rounded-lg text-xs font-bold bg-white dark:bg-[#1e2640] text-slate-500 dark:text-slate-300 border border-slate-200 dark:border-white/10">Вс</button>
                            </div>
                        </div>

                        <!-- Services -->
                        <div class="rounded-xl bg-[#f8fafc] dark:bg-[#0f1525] p-4 mb-4">
                            <div class="flex items-center gap-2 mb-3">
                                <i class="bi bi-briefcase-fill text-brand-400 text-sm"></i>
                                <span class="text-sm font-black text-black dark:text-white">Услуги</span>
                            </div>
                            <div class="space-y-2">
                                <div class="service-row flex items-center justify-between py-1.5 px-2 -mx-2 rounded-lg">
                                    <span class="text-sm font-bold text-black dark:text-slate-200">Мужская стрижка</span>
                                    <span class="text-xs font-black text-slate-400">150 сом • 45 мин</span>
                                </div>
                                <div class="service-row flex items-center justify-between py-1.5 px-2 -mx-2 rounded-lg">
                                    <span class="text-sm font-bold text-black dark:text-slate-200">Стрижка бороды</span>
                                    <span class="text-xs font-black text-slate-400">80 сом • 30 мин</span>
                                </div>
                                <div class="service-row flex items-center justify-between py-1.5 px-2 -mx-2 rounded-lg">
                                    <span class="text-sm font-bold text-black dark:text-slate-200">Королевское бритьё</span>
                                    <span class="text-xs font-black text-slate-400">120 сом • 40 мин</span>
                                </div>
                            </div>
                            <button class="flex items-center gap-1 mt-2 text-xs font-black text-brand-500 hover:text-brand-400 transition-colors">
                                <i class="bi bi-plus-circle-fill text-[10px]"></i>
                                ещё 2 услуг
                            </button>
                        </div>

                        <!-- Book Button -->
                        <button class="w-full py-3 text-sm font-black text-white bg-gradient-to-r from-violet-600 to-purple-600 rounded-xl hover:from-violet-500 hover:to-purple-500 transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40">
                            <i class="bi bi-calendar-check"></i>
                            Забронировать
                        </button>
                    </div>
                </div>

            </div>
        </div>
    <script>
        let isScrolled = false;
        let langOpen = false;
        let mobileOpen = false;
        let currentTheme = localStorage.getItem('theme') || 'dark';

        function initTheme() {
            if (currentTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            applyThemeStyles();
            updateMobileThemeLabel();
        }

        function applyThemeStyles() {
            const isDark = document.documentElement.classList.contains('dark');
            const body = document.body;
            const headerBg = document.getElementById('headerBg');
            const logoText = document.getElementById('logoText');
            const langPill = document.getElementById('langPill');
            const langMenu = document.getElementById('langMenu');
            const mobileMenuPanel = document.getElementById('mobileMenuPanel');

            if (isDark) {
                body.className = "bg-[#0a0e1a] text-white font-sans antialiased overflow-x-hidden";
                if (headerBg) {
                    headerBg.className = isScrolled
                        ? 'absolute inset-0 glass-dark border-b border-white/5'
                        : 'absolute inset-0 bg-[#0a0e1a]/50';
                }
                if (logoText) {
                    logoText.className = "text-lg font-bold text-white";
                }
            } else {
                body.className = "bg-[#f8fafc] text-[#0f172a] font-sans antialiased overflow-x-hidden";
                if (headerBg) {
                    headerBg.className = isScrolled
                        ? 'absolute inset-0 glass-light border-b border-slate-200/50'
                        : 'absolute inset-0 bg-[#f8fafc]/70';
                }
                if (logoText) {
                    logoText.className = "text-lg font-bold text-[#0f172a]";
                }
            }
        }

        function updateMobileThemeLabel() {
            const isDark = document.documentElement.classList.contains('dark');
            const label = document.getElementById('mobileThemeLabel');
            if (label) {
                label.textContent = isDark ? 'Dark Mode' : 'Light Mode';
            }
        }

        function toggleTheme() {
            const html = document.documentElement;
            const body = document.body;

            body.classList.add('theme-transition');

            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                currentTheme = 'light';
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                currentTheme = 'dark';
                localStorage.setItem('theme', 'dark');
            }

            applyThemeStyles();
            updateMobileThemeLabel();
            handleScroll();

            setTimeout(() => {
                body.classList.remove('theme-transition');
            }, 400);
        }

        function handleScroll() {
            const headerBg = document.getElementById('headerBg');
            if (!headerBg) return;

            const isDark = document.documentElement.classList.contains('dark');

            if (window.scrollY > 50) {
                if (!isScrolled) {
                    isScrolled = true;
                    headerBg.className = isDark
                        ? 'absolute inset-0 glass-dark border-b border-white/5'
                        : 'absolute inset-0 glass-light border-b border-slate-200/50';
                }
            } else {
                if (isScrolled) {
                    isScrolled = false;
                    headerBg.className = isDark
                        ? 'absolute inset-0 bg-[#0a0e1a]/50'
                        : 'absolute inset-0 bg-[#f8fafc]/70';
                }
            }
        }

        window.addEventListener('scroll', handleScroll);

        function toggleLangDropdown() {
            langOpen = !langOpen;
            const menu = document.getElementById('langMenu');
            const arrow = document.getElementById('langArrow');
            if (langOpen) {
                menu.classList.remove('hidden');
                menu.classList.add('dropdown-animate');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                menu.classList.add('hidden');
                menu.classList.remove('dropdown-animate');
                arrow.style.transform = 'rotate(0deg)';
            }
        }

        function toggleMobileMenu() {
            mobileOpen = !mobileOpen;
            const menu = document.getElementById('mobileMenu');
            const icon = document.getElementById('menuIcon');
            if (mobileOpen) {
                menu.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                icon.className = 'bi bi-x-lg text-2xl text-slate-300';
            } else {
                menu.classList.add('hidden');
                document.body.style.overflow = '';
                icon.className = 'bi bi-list text-2xl text-slate-300';
            }
        }

        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('langDropdown');
            if (langOpen && !dropdown.contains(e.target)) {
                toggleLangDropdown();
            }
        });

        // Initialize on load
        initTheme();
        handleScroll();
    </script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef8ff',
                            100: '#d9eeff',
                            200: '#bce2ff',
                            300: '#8ed1ff',
                            400: '#59b6ff',
                            500: '#3b98ff',
                            600: '#1b75f5',
                            700: '#145fe1',
                            800: '#174db7',
                            900: '#19438f',
                            950: '#132957',
                        },
                        dark: {
                            900: '#0a0e1a',
                            800: '#0f1525',
                            700: '#161d30',
                            600: '#1e2640',
                            500: '#283250',
                        }
                    }
                }
            }
        }
    </script>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://fonts.bunny.net/css2?family=inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'system-ui', 'sans-serif'],
                        },
                        colors: {
                            brand: {
                                50: '#eef8ff',
                                100: '#d9eeff',
                                200: '#bce2ff',
                                300: '#8ed1ff',
                                400: '#59b6ff',
                                500: '#3b98ff',
                                600: '#1b75f5',
                                700: '#145fe1',
                                800: '#174db7',
                                900: '#19438f',
                                950: '#132957',
                            }
                        }
                    }
                }
            }
        </script>
        <style>
            @keyframes shimmer {
                0% { background-position: -200% center; }
                100% { background-position: 200% center; }
            }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes checkBounce {
                0% { transform: scale(0); }
                50% { transform: scale(1.2); }
                100% { transform: scale(1); }
            }
            .shimmer-text {
                background: linear-gradient(90deg, #3b98ff 0%, #8ed1ff 25%, #3b98ff 50%, #8ed1ff 75%, #3b98ff 100%);
                background-size: 200% auto;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: shimmer 4s linear infinite;
            }
            .glass-dark {
                background: rgba(15, 21, 37, 0.85);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
            }
            .glass-light {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
            }
            .theme-toggle-btn {
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
            }
            .theme-toggle-btn:hover { transform: scale(1.1); }
            .theme-toggle-btn:active { transform: scale(0.95); }
            .theme-toggle-btn .icon-sun,
            .theme-toggle-btn .icon-moon {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            }
            .theme-toggle-btn .icon-sun {
                opacity: 0;
                transform: translate(-50%, -50%) rotate(90deg) scale(0);
            }
            .theme-toggle-btn .icon-moon {
                opacity: 1;
                transform: translate(-50%, -50%) rotate(0deg) scale(1);
            }
            html:not(.dark) .theme-toggle-btn .icon-sun {
                opacity: 1;
                transform: translate(-50%, -50%) rotate(0deg) scale(1);
            }
            html:not(.dark) .theme-toggle-btn .icon-moon {
                opacity: 0;
                transform: translate(-50%, -50%) rotate(-90deg) scale(0);
            }
            .form-input {
                transition: all 0.3s ease;
            }
            .form-input:focus {
                box-shadow: 0 0 0 3px rgba(59, 152, 255, 0.2);
                border-color: rgba(59, 152, 255, 0.5) !important;
            }
            .form-input.error {
                border-color: rgba(239, 68, 68, 0.5) !important;
                box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
            }
            .submit-btn {
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            .submit-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 30px rgba(59, 152, 255, 0.4);
            }
            .submit-btn:active { transform: translateY(0); }
            .submit-btn .btn-text { transition: all 0.3s ease; }
            .submit-btn .btn-loader {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                opacity: 0;
                transition: all 0.3s ease;
            }
            .submit-btn.loading .btn-text { opacity: 0; }
            .submit-btn.loading .btn-loader { opacity: 1; }
            .rating-star {
                transition: all 0.2s ease;
                cursor: pointer;
            }
            .rating-star:hover,
            .rating-star.active { transform: scale(1.25); }
            .feedback-type-card {
                transition: all 0.3s ease;
                cursor: pointer;
            }
            .feedback-type-card:hover {
                transform: translateY(-2px);
                border-color: rgba(59, 152, 255, 0.5);
            }
            .feedback-type-card.selected {
                border-color: rgba(59, 152, 255, 0.8);
                background: rgba(59, 152, 255, 0.1);
            }
            .success-animation {
                animation: fadeInUp 0.6s ease forwards;
            }
            .error-shake {
                animation: shake 0.5s ease;
            }
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
            .check-bounce {
                animation: checkBounce 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            }
            .theme-transition * {
                transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease !important;
            }
        </style>


    <!-- Feedback Section -->
    <section class="relative min-h-[calc(100vh-5rem)] overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 bg-grid-dark dark:bg-grid-dark"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-brand-500/[0.02] to-transparent"></div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-brand-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-purple-500/5 rounded-full blur-3xl"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <!-- Page Header -->
            <div class="text-center mb-12" style="animation: fadeInUp 0.6s ease forwards;">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 text-xs font-black text-brand-300 bg-brand-500/10 border border-brand-500/20 rounded-full">
                    <i class="bi bi-chat-dots text-brand-400"></i>
                    Мы ценим ваше мнение
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight mb-4">
                    <span class="text-black dark:text-white">Обратная</span>
                    <span class="shimmer-text"> связь</span>
                </h1>
                <p class="max-w-2xl mx-auto text-base font-black text-slate-400">
                    Расскажите нам, что вы думаете о платформе Bronix
                </p>
            </div>

            <!-- Feedback Form Container -->
            <div style="animation: fadeInUp 0.6s ease 0.2s forwards; opacity: 0;" class="rounded-3xl overflow-hidden bg-[#1e293b] dark:bg-[#1e293b] border border-white/10 shadow-2xl shadow-black/30">
                <div class="flex flex-col lg:flex-row">

                    <!-- Left Panel - Info -->
                    <div class="relative lg:w-5/12 bg-gradient-to-br from-brand-600 via-brand-700 to-purple-700 p-8 lg:p-10 flex flex-col justify-between min-h-[300px] lg:min-h-0">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>

                        <div class="relative z-10">
                            <div class="inline-flex items-center gap-2 px-4 py-2 mb-6 text-xs font-black text-white bg-white/10 rounded-full backdrop-blur-sm">
                                <i class="bi bi-heart-fill text-sm"></i>
                                Ваше мнение важно
                            </div>

                            <h2 class="text-2xl lg:text-3xl font-black text-white leading-tight mb-4">
                                Помогите нам стать лучше
                            </h2>

                            <p class="text-sm font-black text-white/80 leading-relaxed mb-8">
                                Ваши отзывы помогают нам улучшать платформу и создавать лучший опыт для всех пользователей.
                            </p>

                            <!-- Contact Info -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-envelope text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-white/50">Email</p>
                                        <p class="text-sm font-black text-white">нет ещё</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-telegram text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-white/50">Telegram</p>
                                        <p class="text-sm font-black text-white">@bronix_Platform</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-clock text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-white/50">Время ответа</p>
                                        <p class="text-sm font-black text-white">До 24 часов</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative z-10 mt-8 flex items-center gap-3">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-white/20 border-2 border-white/30 flex items-center justify-center">
                                    <i class="bi bi-person-fill text-xs text-white"></i>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-white/20 border-2 border-white/30 flex items-center justify-center">
                                    <i class="bi bi-person-fill text-xs text-white"></i>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-white/20 border-2 border-white/30 flex items-center justify-center">
                                    <i class="bi bi-person-fill text-xs text-white"></i>
                                </div>
                            </div>
                            <span class="text-xs font-black text-white/60">10K+ пользователей</span>
                        </div>
                    </div>

                    <!-- Right Panel - Form -->
                    <div class="lg:w-7/12 p-8 lg:p-10">
                        <div class="mb-8">
                            <h3 class="text-2xl font-black text-black dark:text-white mb-2">Оставьте отзыв</h3>
                            <p class="text-sm font-black text-slate-400">Заполните форму — мы обязательно ответим</p>
                        </div>

                        <form id="feedbackForm" onsubmit="handleFeedback(event)" class="space-y-6">

                            <!-- Feedback Type Selection -->
                            <div>
                                <label class="block text-sm font-black text-black dark:text-white mb-3">Тип обращения</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <div class="feedback-type-card rounded-xl bg-white dark:bg-[#161d30] border border-slate-200 dark:border-white/10 p-4 text-center" onclick="selectFeedbackType(this, 'suggestion')">
                                        <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center mx-auto mb-2">
                                            <i class="bi bi-lightbulb text-amber-400"></i>
                                        </div>
                                        <span class="text-xs font-black text-black dark:text-white">Предложение</span>
                                    </div>
                                    <div class="feedback-type-card rounded-xl bg-white dark:bg-[#161d30] border border-slate-200 dark:border-white/10 p-4 text-center" onclick="selectFeedbackType(this, 'bug')">
                                        <div class="w-10 h-10 rounded-lg bg-red-500/10 flex items-center justify-center mx-auto mb-2">
                                            <i class="bi bi-bug text-red-400"></i>
                                        </div>
                                        <span class="text-xs font-black text-black dark:text-white">Ошибка</span>
                                    </div>
                                    <div class="feedback-type-card rounded-xl bg-white dark:bg-[#161d30] border border-slate-200 dark:border-white/10 p-4 text-center" onclick="selectFeedbackType(this, 'question')">
                                        <div class="w-10 h-10 rounded-lg bg-brand-500/10 flex items-center justify-center mx-auto mb-2">
                                            <i class="bi bi-question-lg text-brand-400"></i>
                                        </div>
                                        <span class="text-xs font-black text-black dark:text-white">Вопрос</span>
                                    </div>
                                    <div class="feedback-type-card rounded-xl bg-white dark:bg-[#161d30] border border-slate-200 dark:border-white/10 p-4 text-center" onclick="selectFeedbackType(this, 'praise')">
                                        <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center mx-auto mb-2">
                                            <i class="bi bi-emoji-smile text-green-400"></i>
                                        </div>
                                        <span class="text-xs font-black text-black dark:text-white">Похвала</span>
                                    </div>
                                </div>
                                <input type="hidden" id="feedbackType" value="">
                                <p id="typeError" class="hidden text-xs font-black text-red-400 mt-2">
                                    <i class="bi bi-exclamation-circle"></i> Выберите тип обращения
                                </p>
                            </div>

                            <!-- Name & Email -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-black text-black dark:text-white mb-2">
                                        Имя <span class="text-red-400">*</span>
                                    </label>
                                    <input type="text" id="fbName" placeholder="Ваше имя" class="form-input w-full px-4 py-3.5 text-sm font-black text-black dark:text-white bg-white dark:bg-[#161d30] border border-slate-200 dark:border-white/10 rounded-xl placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none">
                                    <p id="nameError" class="hidden text-xs font-black text-red-400 mt-1">
                                        <i class="bi bi-exclamation-circle"></i> Укажите имя
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-black text-black dark:text-white mb-2">
                                        Email <span class="text-red-400">*</span>
                                    </label>
                                    <input type="email" id="fbEmail" placeholder="you@example.com" class="form-input w-full px-4 py-3.5 text-sm font-black text-black dark:text-white bg-white dark:bg-[#161d30] border border-slate-200 dark:border-white/10 rounded-xl placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none">
                                    <p id="emailError" class="hidden text-xs font-black text-red-400 mt-1">
                                        <i class="bi bi-exclamation-circle"></i> Укажите корректный email
                                    </p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-black text-black dark:text-white mb-2">Телефон</label>
                                <input type="tel" id="fbPhone" placeholder="+992 _ __ __ __" class="form-input w-full px-4 py-3.5 text-sm font-black text-black dark:text-white bg-white dark:bg-[#161d30] border border-slate-200 dark:border-white/10 rounded-xl placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none">
                            </div>
                            <!-- Message -->
                            <div>
                                <label class="block text-sm font-black text-black dark:text-white mb-2">
                                    Сообщение <span class="text-red-400">*</span>
                                </label>
                                <textarea id="fbMessage" rows="5" placeholder="Расскажите подробнее..." class="form-input w-full px-4 py-3.5 text-sm font-black text-black dark:text-white bg-white dark:bg-[#161d30] border border-slate-200 dark:border-white/10 rounded-xl placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:outline-none resize-y"></textarea>
                                <div class="flex items-center justify-between mt-2">
                                    <p id="messageError" class="hidden text-xs font-black text-red-400">
                                        <i class="bi bi-exclamation-circle"></i> Сообщение слишком короткое (мин. 10 символов)
                                    </p>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="flex items-center justify-between pt-4 border-t border-white/5">
                                <div class="flex items-center gap-2 text-xs font-black text-slate-400">
                                    <i class="bi bi-shield-check text-brand-400"></i>
                                    <span>Данные защищены SSL</span>
                                </div>
                                <button type="submit" id="submitBtn" class="submit-btn inline-flex items-center gap-2 px-8 py-3.5 text-sm font-black text-white bg-gradient-to-r from-brand-600 to-brand-500 rounded-xl shadow-lg shadow-brand-500/20">
                                    <span class="btn-text"><i class="bi bi-send"></i> Отправить отзыв</span>
                                    <span class="btn-loader"><i class="bi bi-arrow-repeat animate-spin text-lg"></i></span>
                                </button>
                            </div>
                        </form>

                        <!-- Success Message -->
                        <div id="successMessage" class="hidden mt-6 success-animation">
                            <div class="rounded-xl bg-emerald-500/10 border border-emerald-500/20 p-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 flex items-center justify-center flex-shrink-0 check-bounce">
                                        <i class="bi bi-check-circle-fill text-emerald-400 text-2xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-black text-emerald-400 mb-1">Отзыв отправлен!</h4>
                                        <p class="text-sm font-black text-slate-400 mb-3">Спасибо за ваше мнение. Мы свяжемся с вами в ближайшее время.</p>
                                        <div class="flex items-center gap-4 text-xs font-black text-slate-400">
                                            <span><i class="bi bi-clock mr-1"></i>Ответ до 24 часов</span>
                                            <span><i class="bi bi-envelope mr-1"></i>На ваш email</span>
                                        </div>
                                    </div>
                                </div>
                                <button onclick="resetForm()" class="mt-4 text-sm font-black text-brand-400 hover:text-brand-300 transition-colors flex items-center gap-1">
                                    <i class="bi bi-arrow-clockwise"></i>
                                    Отправить ещё один отзыв
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        let currentTheme = localStorage.getItem('theme') || 'dark';
        let currentRating = 0;
        let langOpen = false;
        let isScrolled = false;

        function initTheme() {
            if (currentTheme === 'dark') { document.documentElement.classList.add('dark'); }
            else { document.documentElement.classList.remove('dark'); }
            applyThemeStyles();
        }

        function applyThemeStyles() {
            var isDark = document.documentElement.classList.contains('dark');
            var body = document.body;
            var headerBg = document.getElementById('headerBg');
            var logoText = document.getElementById('logoText');

            if (isDark) {
                body.className = "bg-[#0a0e1a] text-white font-sans antialiased overflow-x-hidden";
                headerBg.className = isScrolled
                    ? 'absolute inset-0 glass-dark border-b border-white/5'
                    : 'absolute inset-0 bg-[#0a0e1a]/50';
                logoText.className = "text-lg font-black text-white";
            } else {
                body.className = "bg-[#f8fafc] text-[#0f172a] font-sans antialiased overflow-x-hidden";
                headerBg.className = isScrolled
                    ? 'absolute inset-0 glass-light border-b border-slate-200/50'
                    : 'absolute inset-0 bg-[#f8fafc]/70';
                logoText.className = "text-lg font-black text-[#0f172a]";
            }
        }

        function toggleTheme() {
            var html = document.documentElement;
            var body = document.body;
            body.classList.add('theme-transition');

            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                currentTheme = 'light';
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                currentTheme = 'dark';
                localStorage.setItem('theme', 'dark');
            }

            applyThemeStyles();

            setTimeout(function() { body.classList.remove('theme-transition'); }, 400);
        }

        function handleScroll() {
            var headerBg = document.getElementById('headerBg');
            if (!headerBg) return;
            var isDark = document.documentElement.classList.contains('dark');

            if (window.scrollY > 50) {
                if (!isScrolled) {
                    isScrolled = true;
                    headerBg.className = isDark
                        ? 'absolute inset-0 glass-dark border-b border-white/5'
                        : 'absolute inset-0 glass-light border-b border-slate-200/50';
                }
            } else {
                if (isScrolled) {
                    isScrolled = false;
                    headerBg.className = isDark
                        ? 'absolute inset-0 bg-[#0a0e1a]/50'
                        : 'absolute inset-0 bg-[#f8fafc]/70';
                }
            }
        }

        window.addEventListener('scroll', handleScroll);

        function toggleLangDropdown() {
            langOpen = !langOpen;
            var menu = document.getElementById('langMenu');
            var arrow = document.getElementById('langArrow');
            if (langOpen) {
                menu.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                menu.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
            }
        }

        document.addEventListener('click', function(e) {
            if (langOpen && !e.target.closest('#langPill') && !e.target.closest('#langMenu')) {
                toggleLangDropdown();
            }
        });

        // ========== FEEDBACK FORM FUNCTIONS ==========

        function selectFeedbackType(el, type) {
            document.querySelectorAll('.feedback-type-card').forEach(function(card) { card.classList.remove('selected'); });
            el.classList.add('selected');
            document.getElementById('feedbackType').value = type;
            document.getElementById('typeError').classList.add('hidden');
        }

        function setRating(rating) {
            currentRating = rating;
            var stars = document.querySelectorAll('.rating-star');
            var labels = ['', 'Плохо', 'Ниже среднего', 'Нормально', 'Хорошо', 'Отлично!'];

            stars.forEach(function(star, index) {
                if (index < rating) {
                    star.classList.add('active');
                    star.innerHTML = '<i class="bi bi-star-fill"></i>';
                    star.classList.remove('text-slate-300', 'dark:text-slate-600');
                    star.classList.add('text-amber-400');
                } else {
                    star.classList.remove('active');
                    star.innerHTML = '<i class="bi bi-star"></i>';
                    star.classList.remove('text-amber-400');
                    star.classList.add('text-slate-300', 'dark:text-slate-600');
                }
            });

            document.getElementById('ratingText').textContent = labels[rating] || '';
        }

        // Character counter
        document.getElementById('fbMessage').addEventListener('input', function() {
            var count = this.value.length;
            document.getElementById('charCount').textContent = count + ' / 1000';
            if (count > 1000) {
                this.value = this.value.substring(0, 1000);
                document.getElementById('charCount').textContent = '1000 / 1000';
            }
        });

        function handleFileSelect(input) {
            var fileName = input.files[0] ? input.files[0].name : 'Выберите файл (макс. 5MB)';
            document.getElementById('fileName').textContent = fileName;
        }

        function validateForm() {
            var isValid = true;

            // Type
            if (!document.getElementById('feedbackType').value) {
                document.getElementById('typeError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('typeError').classList.add('hidden');
            }

            // Name
            var name = document.getElementById('fbName').value.trim();
            if (!name) {
                document.getElementById('fbName').classList.add('error');
                document.getElementById('nameError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('fbName').classList.remove('error');
                document.getElementById('nameError').classList.add('hidden');
            }

            // Email
            var email = document.getElementById('fbEmail').value.trim();
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email || !emailRegex.test(email)) {
                document.getElementById('fbEmail').classList.add('error');
                document.getElementById('emailError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('fbEmail').classList.remove('error');
                document.getElementById('emailError').classList.add('hidden');
            }

            // Message
            var message = document.getElementById('fbMessage').value.trim();
            if (message.length < 10) {
                document.getElementById('fbMessage').classList.add('error');
                document.getElementById('messageError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('fbMessage').classList.remove('error');
                document.getElementById('messageError').classList.add('hidden');
            }

            return isValid;
        }

        function handleFeedback(e) {
            e.preventDefault();

            if (!validateForm()) {
                var form = document.getElementById('feedbackForm');
                form.classList.add('error-shake');
                setTimeout(function() { form.classList.remove('error-shake'); }, 500);
                return;
            }

            var btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.disabled = true;

            // Simulate sending
            setTimeout(function() {
                btn.classList.remove('loading');
                btn.disabled = false;

                document.getElementById('successMessage').classList.remove('hidden');
                document.getElementById('feedbackForm').style.display = 'none';

                document.getElementById('successMessage').scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 2000);
        }

        function resetForm() {
            document.getElementById('feedbackForm').style.display = 'block';
            document.getElementById('successMessage').classList.add('hidden');
            document.getElementById('feedbackForm').reset();
            document.getElementById('fileName').textContent = 'Выберите файл (макс. 5MB)';
            document.getElementById('charCount').textContent = '0 / 1000';
            document.getElementById('ratingText').textContent = '';
            document.querySelectorAll('.feedback-type-card').forEach(function(card) { card.classList.remove('selected'); });
            document.querySelectorAll('.rating-star').forEach(function(star) {
                star.classList.remove('active', 'text-amber-400');
                star.classList.add('text-slate-300', 'dark:text-slate-600');
                star.innerHTML = '<i class="bi bi-star"></i>';
            });
            currentRating = 0;
        }

        initTheme();
        handleScroll();
    </script>
    </body>
    </html>


