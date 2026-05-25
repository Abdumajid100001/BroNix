<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AI Бизнес-Аналитика</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: #1e293b; }
        .glass-card { background: white; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05); }
    </style>
</head>
<body class="antialiased">

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <div class="text-indigo-600 font-bold text-xs uppercase tracking-widest mb-1 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span> Модуль Gemini 1.5
                </div>
                <h1 class="text-2xl font-bold text-slate-900">Сравнительный ИИ-Анализ</h1>
            </div>
            
            <div class="flex items-center gap-2 bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm">
                <select id="businessA" class="bg-slate-50 text-sm rounded-lg px-3 py-2 border border-slate-200 outline-none">
                    <option value="1">Стадион «Спартак»</option>
                    <option value="3">Комплекс «Истиклол»</option>
                </select>
                <span class="text-xs font-bold text-slate-400 px-1">VS</span>
                <select id="businessB" class="bg-slate-50 text-sm rounded-lg px-3 py-2 border border-slate-200 outline-none">
                    <option value="2">Арена «ЛТД»</option>
                    <option value="4">Спорткомплекс «Рамис»</option>
                </select>
                <button id="analyzeBtn" onclick="runAiAnalysis()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm px-5 py-2 rounded-lg transition">
                    Анализировать
                </button>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-1 flex flex-col gap-6">
                <div class="glass-card rounded-2xl p-6">
                    <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest">Объект А</span>
                    <h3 id="nameA" class="text-lg font-bold text-slate-900 mt-1">---</h3>
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <p class="text-[10px] text-slate-500 uppercase">Брони</p>
                            <p id="bookingsA" class="font-bold text-slate-900">0</p>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <p class="text-[10px] text-slate-500 uppercase">Выручка</p>
                            <p id="revenueA" class="font-bold text-emerald-600">0 TJS</p>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <span class="text-[10px] font-bold text-violet-500 uppercase tracking-widest">Объект Б</span>
                    <h3 id="nameB" class="text-lg font-bold text-slate-900 mt-1">---</h3>
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <p class="text-[10px] text-slate-500 uppercase">Брони</p>
                            <p id="bookingsB" class="font-bold text-slate-900">0</p>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <p class="text-[10px] text-slate-500 uppercase">Выручка</p>
                            <p id="revenueB" class="font-bold text-emerald-600">0 TJS</p>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-4">
                    <div id="radarChart"></div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="glass-card rounded-2xl p-8 min-h-[500px] flex flex-col">
                    <div id="aiOutput" class="prose prose-slate max-w-none text-slate-700">
                        <div id="placeholderView" class="text-center py-20">
                            <div class="text-4xl mb-4">📊</div>
                            <h3 class="text-lg font-semibold text-slate-800">Выберите объекты для сравнения</h3>
                            <p class="text-slate-500 text-sm">ИИ сформирует глубокий отчет по эффективности</p>
                        </div>
                    </div>
                    <div id="aiLoader" class="hidden text-center py-20 text-indigo-600 font-medium">
                        ИИ анализирует данные...
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script>
            let radarChartInstance = null;

            async function runAiAnalysis() {
                const analyzeBtn = document.getElementById('analyzeBtn');
                const placeholderView = document.getElementById('placeholderView');
                const aiOutput = document.getElementById('aiOutput');
                const aiLoader = document.getElementById('aiLoader');

                placeholderView.classList.add('hidden');
                aiOutput.classList.add('hidden');
                aiLoader.classList.remove('hidden');
                analyzeBtn.disabled = true;

                try {
                    const response = await fetch('/ai/compare-businesses', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            business_a_id: document.getElementById('businessA').value,
                            business_b_id: document.getElementById('businessB').value
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        document.getElementById('nameA').innerText = result.data.business_A.name;
                        document.getElementById('bookingsA').innerText = result.data.business_A.total_bookings_count;
                        document.getElementById('revenueA').innerText = result.data.business_A.revenue_somoni + ' TJS';
                        document.getElementById('nameB').innerText = result.data.business_B.name;
                        document.getElementById('bookingsB').innerText = result.data.business_B.total_bookings_count;
                        document.getElementById('revenueB').innerText = result.data.business_B.revenue_somoni + ' TJS';
                        
                        aiOutput.innerHTML = marked.parse(result.ai_analysis);
                        renderRadarChart(result.data.business_A, result.data.business_B);
                    }
                } catch (e) {
                    aiOutput.innerHTML = '<p class="text-red-500">Ошибка соединения с сервером.</p>';
                } finally {
                    aiLoader.classList.add('hidden');
                    aiOutput.classList.remove('hidden');
                    analyzeBtn.disabled = false;
                }
            }

            function renderRadarChart(a, b) {
                const options = {
                    series: [{ name: a.name, data: [a.total_bookings_count, a.average_rating * 10, 80] }, 
                            { name: b.name, data: [b.total_bookings_count, b.average_rating * 10, 50] }],
                    chart: { type: 'radar', height: 250, toolbar: { show: false } },
                    colors: ['#4f46e5', '#8b5cf6'],
                    xaxis: { categories: ['Брони', 'Рейтинг', 'Загрузка'] }
                };
                if(radarChartInstance) radarChartInstance.destroy();
                radarChartInstance = new ApexCharts(document.querySelector("#radarChart"), options);
                radarChartInstance.render();
            }
        </script>
</body>
</html>