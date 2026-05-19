@extends('owner.layouts.app')

@section('title', 'Панель управления владельца')

@section('content')
<div class="container-fluid py-3" style="max-width: 1040px; margin: 0 auto;">

    {{-- Передаем CSRF-токен для бесперебойной работы POST-запросов (подтверждение/отмена) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="dashboard-grid">
        
        {{-- ЛЕВАЯ ПАНЕЛЬ: АНАЛИТИКА ТРАФИКА И УСЛУГ --}}
        <div class="analytics-panel">
            
            <div class="panel-header">
                <div class="brand-block">
                    <h5 class="m-0 fw-bold header-text">Платформа управления</h5>
                    <span class="platform-badge">FREE СИСТЕМА</span>
                </div>
                
                {{-- УПРАВЛЕНИЕ ТЕМОЙ И ИНФО О ПОЛЬЗОВАТЕЛЕ --}}
                <div class="d-flex align-items-center gap-3">
                    <button id="themeToggleBtn" class="theme-toggle-btn" title="Переключить тему">🌓</button>
                    <span class="user-badge">⚡ {{ $user->name }}</span>
                </div>
            </div>

            {{-- Микро-метрики эффективности системы --}}
            <div class="micro-stats">
                <div class="m-stat">
                    <span class="m-label">Всего записей</span>
                    <span class="m-val text-primary-light">{{ $stats['total_bookings'] }}</span>
                </div>
                <div class="m-stat">
                    <span class="m-label">Сегодняшние</span>
                    <span class="m-val text-success" id="todayConfirmedCounter">{{ $stats['confirmed_today'] }}</span>
                </div>
                <div class="m-stat">
                    <span class="m-label">Новые (Ожидают)</span>
                    <span class="m-val text-warning" id="pendingCounter">{{ $stats['pending_bookings'] }}</span>
                </div>
            </div>

            {{-- Интерактивный график посещаемости по дням --}}
            <div class="chart-section mb-4">
                <div class="section-title">📊 График загруженности (Записи по дням недели)</div>
                <div style="position: relative; height: 150px; width: 100%;">
                    <canvas id="trafficChart"></canvas>
                </div>
            </div>

            <div class="row g-3">
                {{-- Популярные услуги --}}
                <div class="col-12 col-md-6">
                    <div class="section-title">🔥 Популярные услуги</div>
                    <div class="top-services-list">
                        @forelse($topServices as $index => $ts)
                            <div class="top-service-item">
                                <div class="ts-rank">{{ $index + 1 }}</div>
                                <div class="ts-info">
                                    <span class="ts-name text-truncate" style="max-width: 170px;">{{ $ts['name'] }}</span>
                                    <span class="ts-count">{{ $ts['count'] }} забронировано</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-muted text-center py-2 style-muted-text">Нет статистики услуг</div>
                        @endforelse
                    </div>
                </div>

                {{-- Недавняя активность (Лента логов с кнопками управления) --}}
                <div class="col-12 col-md-6">
                    <div class="section-title">🔔 Последние действия</div>
                    <div class="activity-list">
                        @forelse($recentBookings as $rb)
                            <div class="activity-item" id="activity-row-{{ $rb->id }}">
                                <div class="activity-left">
                                    <span class="act-time">{{ $rb->start_time }}</span>
                                    <div class="d-flex flex-column">
                                        <span class="act-service text-truncate" style="max-width: 110px;">{{ $rb->service ? $rb->service->name : 'Услуга' }}</span>
                                        <span class="act-client text-truncate" style="max-width: 110px;">Кл: {{ $rb->user ? $rb->user->name : 'Гость' }}</span>
                                    </div>
                                </div>
                                
                                {{-- Блок управления действиями --}}
                                <div class="action-status-container" id="action-container-{{ $rb->id }}">
                                    @if(($rb->status ?? 'pending') === 'pending')
                                        <div class="btn-group-actions">
                                            <button class="btn-action-ok" onclick="handleBookingAction({{ $rb->id }}, 'confirm', this)" title="Подтвердить бронь">ОК</button>
                                            <button class="btn-action-cancel" onclick="handleBookingAction({{ $rb->id }}, 'cancel', this)" title="Отменить бронь">Отмена</button>
                                        </div>
                                    @elseif($rb->status === 'confirmed')
                                        <span class="badge-panel-status status-confirmed">Одобрено</span>
                                    @elseif($rb->status === 'cancelled')
                                        <span class="badge-panel-status status-cancelled">Отменено</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-muted text-center py-2 style-muted-text">Нет активности</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        {{-- ПРАВАЯ ПАНЕЛЬ: ВАШ КАЛЕНДАРЬ С ЖИВЫМИ ЧАСАМИ --}}
        <div class="calendar-panel">
            <div class="mini-calendar">
                {{-- HEADER --}}
                <div class="mini-header">
                    <button id="prevMonth">‹</button>
                    <div id="monthName"></div>
                    <button id="nextMonth">›</button>
                </div>

                {{-- LIVE CLOCK --}}
                <div class="mini-clock">
                    <div id="liveTime"></div>
                    <div id="liveDate"></div>
                </div>

                {{-- WEEKDAYS --}}
                <div class="mini-weekdays">
                    <div>Пн</div><div>Вт</div><div>Ср</div>
                    <div>Чт</div><div>Пт</div><div>Сб</div><div>Вс</div>
                </div>

                {{-- DAYS CONTAINER --}}
                <div class="mini-days" id="daysContainer"></div>
            </div>
        </div>

    </div>

</div>

{{-- MODAL WINDOW --}}
<div id="bookingModal" class="booking-modal-overlay">
    <div class="booking-modal-content">
        <div class="booking-modal-header">
            <h5 id="modalTitle">Бронирования</h5>
            <button class="booking-modal-close" id="closeModalBtn">&times;</button>
        </div>
        <div class="booking-modal-body" id="modalBookingList"></div>
    </div>
</div>

{{-- Подключаем Chart.js через официальный CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* НАСТРОЙКА CSS-ПЕРЕМЕННЫХ ДЛЯ ДВУХ ТЕМ (ТЕМНАЯ ПО УМОЛЧАНИЮ) */
:root {
    --bg-body: #121214;
    --bg-card: #1e1e1e;
    --bg-inner: #161618;
    --border-color: #2a2a2e;
    --text-main: #ffffff;
    --text-muted: #888888;
    --text-item: #dddddd;
    --bg-badge: #2a2a2e;
    --border-badge: #3a3a3f;
}

[data-theme="light"] {
    --bg-body: #f4f6fa;
    --bg-card: #ffffff;
    --bg-inner: #f8fafc;
    --border-color: #e2e8f0;
    --text-main: #1e293b;
    --text-muted: #64748b;
    --text-item: #334155;
    --bg-badge: #f1f5f9;
    --border-badge: #cbd5e1;
}

body {
    background: var(--bg-body);
    font-family: system-ui, -apple-system, sans-serif;
    transition: background 0.3s ease;
}

/* Сетка интерфейса */
.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 24px;
    align-items: start;
}

@media (max-width: 930px) {
    .dashboard-grid { grid-template-columns: 1fr; }
    .calendar-panel { display: flex; justify-content: center; }
}

/* Главный контейнер аналитики */
.analytics-panel {
    background: var(--bg-card);
    color: var(--text-main);
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,.05);
    border: 1px solid var(--border-color);
    transition: background 0.3s ease, border 0.3s ease;
}

.panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.brand-block { display: flex; flex-direction: column; }
.header-text { color: var(--text-main) !important; font-size: 16px; }

.platform-badge {
    font-size: 9px;
    background: #0d6efd;
    color: #fff;
    font-weight: bold;
    padding: 1px 6px;
    border-radius: 4px;
    width: fit-content;
    margin-top: 3px;
    letter-spacing: 0.5px;
}
.user-badge {
    font-size: 12px;
    background: var(--bg-badge);
    padding: 4px 12px;
    border-radius: 20px;
    color: var(--text-main);
    border: 1px solid var(--border-badge);
}

/* Переключатель темы оформления */
.theme-toggle-btn {
    background: var(--bg-badge);
    border: 1px solid var(--border-badge);
    font-size: 14px;
    cursor: pointer;
    padding: 4px 10px;
    border-radius: 12px;
    transition: transform 0.2s ease;
}
.theme-toggle-btn:active { transform: scale(0.9); }

/* Элементы показателей */
.micro-stats {
    display: flex;
    justify-content: space-between;
    background: var(--bg-inner);
    border-radius: 14px;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid var(--border-color);
}
.m-stat { display: flex; flex-direction: column; align-items: center; flex: 1; }
.m-stat:not(:last-child) { border-right: 1px solid var(--border-color); }
.m-label { font-size: 10px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 3px; font-weight: 500; }
.m-val { font-size: 15px; font-weight: 800; }
.text-primary-light { color: #0d6efd; }

.section-title {
    font-size: 11px;
    color: var(--text-muted);
    margin-bottom: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.style-muted-text { font-size: 11px; color: var(--text-muted); }

/* Рендеринг списков заведений и логов */
.top-services-list, .activity-list { display: flex; flex-direction: column; gap: 8px; }
.top-service-item, .activity-item {
    display: flex;
    align-items: center;
    background: var(--bg-inner);
    padding: 10px;
    border-radius: 10px;
    border: 1px solid var(--border-color);
}
.activity-item { justify-content: space-between; font-size: 12px; }
.ts-rank {
    background: var(--bg-badge);
    color: #0d6efd;
    font-weight: 800;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    font-size: 11px;
}
.ts-info { display: flex; flex-direction: column; }
.ts-name { font-size: 12px; color: var(--text-item); font-weight: 500; }
.ts-count { font-size: 10px; color: var(--text-muted); }

.activity-left { display: flex; align-items: center; gap: 10px; }
.act-time {
    color: #28a745; font-weight: bold; background: rgba(40,167,69,0.12);
    padding: 2px 6px; border-radius: 6px; font-size: 11px;
}
.act-service { color: var(--text-item); font-weight: 500; }
.act-client { color: var(--text-muted); font-size: 11px; }

/* КНОПКИ ДЕЙСТВИЙ И БЕЙДЖИ СТАТУСОВ */
.btn-group-actions {
    display: flex;
    gap: 6px;
    align-items: center;
}
.btn-action-ok {
    background: #28a745;
    border: none;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
}
.btn-action-ok:hover { background: #218838; }
.btn-action-ok:active { transform: scale(0.95); }

.btn-action-cancel {
    background: #dc3545;
    border: none;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
}
.btn-action-cancel:hover { background: #c82333; }
.btn-action-cancel:active { transform: scale(0.95); }

.badge-panel-status {
    font-size: 11px;
    padding: 3px 8px;
    border-radius: 6px;
    font-weight: 600;
}
.badge-panel-status.status-confirmed {
    background: rgba(40, 167, 69, 0.12);
    color: #28a745;
}
.badge-panel-status.status-cancelled {
    background: rgba(220, 53, 69, 0.12);
    color: #dc3545;
}

/* ТЕМНЫЙ ФИРМЕННЫЙ КАЛЕНДАРЬ */
.mini-calendar {
    width: 320px; background: var(--bg-card); color: var(--text-main); border-radius: 18px; padding: 12px; 
    box-shadow: 0 10px 25px rgba(0,0,0,.08); border: 1px solid var(--border-color);
}
.mini-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
.mini-header button { width: 28px; height: 28px; border-radius: 8px; border: none; background: var(--bg-badge); color: var(--text-main); cursor: pointer; }
#monthName { font-size: 14px; font-weight: 600; }
.mini-clock { text-align: center; margin-bottom: 10px; }
#liveTime { font-size: 22px; font-weight: 300; }
#liveDate { font-size: 11px; color: var(--text-muted); }
.mini-weekdays { display: grid; grid-template-columns: repeat(7, 1fr); font-size: 10px; color: var(--text-muted); text-align: center; }
.mini-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; margin-top: 6px; }
.day { aspect-ratio: 1; display: flex; align-items: center; justify-content: center; font-size: 11px; border-radius: 6px; cursor: pointer; transition: .2s; color: var(--text-main); }
.day:hover { background: var(--bg-badge); }
.day.booked { background: #28a745 !important; color: #fff !important; font-weight: 700; }
.day.disabled { opacity: .2; pointer-events: none; color: var(--text-muted); }
.day.today { background: #0d6efd !important; color: #fff !important; font-weight: 700; border: 1px solid #0a58ca; }
.day.active { outline: 2px solid #0d6efd; }

/* СТИЛИЗАЦИЯ ДИНАМИЧЕСКОГО ОКНА */
.booking-modal-overlay {
    display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(4px); z-index: 9999;
    justify-content: center; align-items: center;
}
.booking-modal-overlay.show { display: flex; }
.booking-modal-content {
    background: var(--bg-card); color: var(--text-main); width: 360px; max-width: 90%; border-radius: 18px; padding: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2); animation: fadeInModal 0.25s ease; border: 1px solid var(--border-color);
}
@keyframes fadeInModal { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.booking-modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 10px; margin-bottom: 15px; }
.booking-modal-header h5 { margin: 0; font-size: 15px; font-weight: 600; }
.booking-modal-close { background: none; border: none; color: var(--text-muted); font-size: 24px; cursor: pointer; }
.booking-modal-close:hover { color: var(--text-main); }
.booking-item { background: var(--bg-inner); border: 1px solid var(--border-color); padding: 12px; border-radius: 10px; margin-bottom: 10px; }
.booking-header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
.booking-service { color: #28a745; font-weight: 600; font-size: 13px; }
.booking-time { font-size: 11px; color: #fff; background: #218838; padding: 1px 6px; border-radius: 10px; }
.booking-detail-line { font-size: 12px; color: var(--text-item); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ================= ОБРАБОТКА И ХРАНЕНИЕ ТЕМЫ ОФОРМЛЕНИЯ ================= */
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const currentTheme = localStorage.getItem('theme') || 'dark'; // Dark по умолчанию
    document.documentElement.setAttribute('data-theme', currentTheme);

    themeToggleBtn.addEventListener('click', () => {
        let theme = document.documentElement.getAttribute('data-theme');
        let newTheme = (theme === 'dark') ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        // Интерактивное обновление параметров осей графика без перезагрузки
        if(window.trafficChartInstance) {
            const isDark = newTheme === 'dark';
            window.trafficChartInstance.options.scales.y.grid.color = isDark ? '#252529' : '#e2e8f0';
            window.trafficChartInstance.options.scales.y.ticks.color = isDark ? '#555' : '#64748b';
            window.trafficChartInstance.options.scales.x.ticks.color = isDark ? '#888' : '#334155';
            window.trafficChartInstance.update();
        }
    });

    /* ================= ИНИЦИАЛИЗАЦИЯ И ПОСТРОЕНИЕ ГРАФИКА НАГРУЗКИ ================= */
    const ctx = document.getElementById('trafficChart').getContext('2d');
    
    const fillGradient = ctx.createLinearGradient(0, 0, 0, 150);
    fillGradient.addColorStop(0, 'rgba(13, 110, 253, 0.22)');
    fillGradient.addColorStop(1, 'rgba(13, 110, 253, 0.00)');

    const isInitiallyDark = (localStorage.getItem('theme') || 'dark') === 'dark';

    window.trafficChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                data: {!! json_encode($chartData) !!},
                borderColor: '#0d6efd',
                backgroundColor: fillGradient,
                borderWidth: 3,
                tension: 0.35,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    grid: { color: isInitiallyDark ? '#252529' : '#e2e8f0' }, 
                    ticks: { color: isInitiallyDark ? '#555' : '#64748b', font: { size: 10 }, stepSize: 1 } 
                },
                x: { 
                    grid: { display: false }, 
                    ticks: { color: isInitiallyDark ? '#888' : '#334155', font: { size: 11, weight: 'bold' } } 
                }
            }
        }
    });

    /* ================= AJAX ПОДТВЕРЖДЕНИЕ И ОТМЕНА С ГЛАВНОЙ СТРАНИЦЫ ================= */
    window.handleBookingAction = function(id, actionType, buttonElement) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const container = document.getElementById('action-container-' + id);
        
        // Временно блокируем кнопки
        const buttons = container.querySelectorAll('button');
        buttons.forEach(b => b.disabled = true);
        buttonElement.innerText = "⏳";

        // Определяем URL в зависимости от типа действия
        const url = actionType === 'confirm' ? '/owner/bookings/confirm/' : '/owner/bookings/cancel/';

        fetch(url + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(r => r.json())
        .then(response => {
            if(response.success) {
                // Изменяем интерфейс строки на бейдж статуса
                if(actionType === 'confirm') {
                    container.innerHTML = `<span class="badge-panel-status status-confirmed">Одобрено</span>`;
                    
                    // Увеличиваем счетчик "Сегодняшние"
                    const todayCounter = document.getElementById('todayConfirmedCounter');
                    if(todayCounter) {
                        let cVal = parseInt(todayCounter.innerText) || 0;
                        todayCounter.innerText = cVal + 1;
                    }
                } else {
                    container.innerHTML = `<span class="badge-panel-status status-cancelled">Отменено</span>`;
                }

                // Уменьшаем счетчик "Новые (Ожидают)"
                const pendingCounter = document.getElementById('pendingCounter');
                if(pendingCounter) {
                    let pVal = parseInt(pendingCounter.innerText) || 0;
                    if(pVal > 0) pendingCounter.innerText = pVal - 1;
                }
            } else {
                alert(response.message || "Ошибка операции");
                buttons.forEach(b => b.disabled = false);
                buttonElement.innerText = actionType === 'confirm' ? 'ОК' : 'Отмена';
            }
        })
        .catch(err => {
            alert("Ошибка сети при отправке запроса");
            buttons.forEach(b => b.disabled = false);
            buttonElement.innerText = actionType === 'confirm' ? 'ОК' : 'Отмена';
        });
    }

    /* ================= АВТОНОМНЫЙ ДВИЖОК КАЛЕНДАРЯ И ЖИВЫХ ЧАСОВ ================= */
    let currentDate = new Date();
    let minDate = new Date(); minDate.setHours(0,0,0,0);
    let maxDate = new Date(); maxDate.setMonth(maxDate.getMonth() + 2);

    function getToday(){
        const t = new Date(); t.setHours(0,0,0,0); return t;
    }

    function clock(){
        const now = new Date();
        document.getElementById('liveTime').innerText = now.toLocaleTimeString('ru-RU',{hour:'2-digit',minute:'2-digit'});
        document.getElementById('liveDate').innerText = now.toLocaleDateString('ru-RU',{day:'2-digit',month:'short'});
    }
    setInterval(clock,1000); clock();

    const daysContainer = document.getElementById('daysContainer');
    const monthName = document.getElementById('monthName');

    function render(){
        daysContainer.innerHTML = '';
        const y = currentDate.getFullYear();
        const m = currentDate.getMonth();

        const first = new Date(y,m,1);
        const last = new Date(y,m+1,0);
        const months = ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];

        monthName.innerText = months[m] + ' ' + y;

        let start = first.getDay();
        if(start === 0) start = 7;

        for(let i=1;i<start;i++){
            daysContainer.appendChild(document.createElement('div'));
        }

        for(let d=1; d<=last.getDate(); d++){
            const el = document.createElement('div');
            el.classList.add('day'); el.innerText = d;

            const today = getToday();
            const current = new Date(y,m,d); current.setHours(0,0,0,0);

            if(current < today){ el.classList.add('disabled'); }
            if(current.getTime() === today.getTime()){ el.classList.add('today'); }

            el.onclick = () => {
                if(el.classList.contains('disabled')) return;
                document.querySelectorAll('.day').forEach(x=>x.classList.remove('active'));
                el.classList.add('active');

                const date = y+'-'+String(m+1).padStart(2,'0')+'-'+String(d).padStart(2,'0');
                const formattedDate = `${d} ${months[m]} ${y}`;
                loadBookings(date, formattedDate);
            };
            daysContainer.appendChild(el);
        }
        loadMonth(y,m);
    }
    render();

    document.getElementById('prevMonth').onclick = ()=>{
        let temp = new Date(currentDate); temp.setMonth(temp.getMonth()-1);
        if(temp < minDate) return;
        currentDate.setMonth(currentDate.getMonth()-1); render();
    };

    document.getElementById('nextMonth').onclick = ()=>{
        let temp = new Date(currentDate); temp.setMonth(temp.getMonth()+1);
        if(temp > maxDate) return;
        currentDate.setMonth(currentDate.getMonth()+1); render();
    };

    function loadBookings(date, formattedDate){
        const modal = document.getElementById('bookingModal');
        const modalList = document.getElementById('modalBookingList');
        const modalTitle = document.getElementById('modalTitle');

        modalTitle.innerText = `Бронирования на ${formattedDate}`;
        modalList.innerHTML = '<div style="color:var(--text-muted); font-size:13px; text-align:center; padding:15px;">Загрузка данных...</div>';
        modal.classList.add('show');

        fetch('/owner/bookings/day/'+date)
        .then(r=>r.json())
        .then(data=>{
            let html='';
            if(data.length===0){
                html='<div style="color:var(--text-muted);font-size:12px;text-align:center;padding:15px;">Нет броней на этот день</div>';
            } else {
                data.forEach(b=>{
                    let statusTxt = '⏳ Ожидает';
                    if(b.status === 'confirmed') statusTxt = '✅ Одобрено';
                    if(b.status === 'cancelled') statusTxt = '❌ Отменено';

                    html+=`
                    <div class="booking-item">
                        <div class="booking-header-row">
                            <div class="booking-service">📌 ${b.service}</div>
                            <div class="booking-time">⏱ ${b.start_time}</div>
                        </div>
                        <div class="booking-detail-line" style="display:flex; justify-content:space-between; align-items:center;">
                            <div><strong>👤 Клиент:</strong> <span style="font-weight:500;">${b.client}</span></div>
                            <span style="font-size:11px; opacity:0.8;">${statusTxt}</span>
                        </div>
                    </div>`;
                });
            }
            modalList.innerHTML = html;
        })
        .catch(err => {
            modalList.innerHTML = '<div style="color:#dc3545;font-size:12px;text-align:center;padding:15px;">Ошибка сети</div>';
        });
    }

    const modal = document.getElementById('bookingModal');
    const closeBtn = document.getElementById('closeModalBtn');
    function closeModal() {
        modal.classList.remove('show');
        document.querySelectorAll('.day').forEach(x=>x.classList.remove('active'));
    }
    closeBtn.onclick = closeModal;
    window.onclick = function(event) { if (event.target === modal) { closeModal(); } }

    function loadMonth(y,m){
        fetch(`/owner/bookings/month/${y}-${String(m+1).padStart(2,'0')}`)
        .then(r=>r.json())
        .then(days=>{
            document.querySelectorAll('.day').forEach(el=>el.classList.remove('booked'));
            days.forEach(date=>{
                const d = new Date(date).getDate();
                document.querySelectorAll('.day').forEach(el=>{
                    if(+el.innerText === d){ el.classList.add('booked'); }
                });
            });
        });
    }
});
</script>
@endsection