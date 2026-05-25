@extends('owner.app') {{-- Проверь, если твой лайаут называется по-другому, например layouts.app, замени имя --}}

@section('content')
<div class="p-6 max-w-[1600px] mx-auto space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Бронирования клиентов</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Полный список записей во все ваши заведения</p>
        </div>
        
        <div class="relative w-full md:w-80">
            <input type="text" 
                   placeholder="Поиск по клиенту или услуге..." 
                   class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-800/60 backdrop-blur-xl border border-gray-200 dark:border-gray-700/80 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 dark:text-gray-200 transition">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800/40 backdrop-blur-md rounded-2xl border border-gray-100 dark:border-gray-700/50 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-gray-700/30 text-gray-600 dark:text-gray-400 text-xs font-semibold uppercase tracking-wider border-b border-gray-100 dark:border-gray-700/60">
                        <th class="p-4 pl-6">ID</th>
                        <th class="p-4">Клиент</th>
                        <th class="p-4">Заведение</th>
                        <th class="p-4">Услуга</th>
                        <th class="p-4">Дата и Время визита</th>
                        <th class="p-4">Стоимость</th>
                        <th class="p-4 pr-6">Статус</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/40 text-sm text-gray-700 dark:text-gray-300">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50/40 dark:hover:bg-gray-700/20 transition-colors duration-150">
                            <td class="p-4 pl-6 font-medium text-gray-400 dark:text-gray-500">#{{ $booking->id }}</td>
                            <td class="p-4">
                                <div class="font-semibold text-gray-900 dark:text-white">
                                    {{ $booking->user ? $booking->user->name : 'Гость' }}
                                </div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $booking->user ? $booking->user->email : '' }}
                                </div>
                            </td>
                            <td class="p-4 font-medium text-gray-800 dark:text-gray-200">
                                {{ $booking->business ? $booking->business->name : '—' }}
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 bg-blue-50/50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-medium">
                                    {{ $booking->service ? $booking->service->name : 'Услуга удалена' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->locale('ru')->isoFormat('D MMMM YYYY') }}
                                </div>
                                <div class="text-xs text-blue-500 dark:text-blue-400 font-medium mt-0.5">
                                    {{ $booking->start_time ?? '--:--' }}
                                </div>
                            </td>
                            <td class="p-4 font-bold text-gray-900 dark:text-white">
                                {{ $booking->service ? number_format($booking->service->price, 0, '.', ' ') : 0 }} сомони
                            </td>
                            <td class="p-4 pr-6">
                                @if($booking->status === 'confirmed')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Подтверждено
                                    </span>
                                @elseif($booking->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        В ожидании
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Отменено
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-gray-400 dark:text-gray-500">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-base font-medium">Активных бронирований не найдено</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="p-4 bg-gray-50/30 dark:bg-gray-700/10 border-t border-gray-100 dark:border-gray-700/60 px-6">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection