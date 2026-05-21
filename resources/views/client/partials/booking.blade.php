<!-- ===== BOOKINGS SECTION ===== -->
            <div id="section-bookings" class="hidden fade-in">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-dark-900">Мои бронирования</h2>
                        <p class="text-sm text-dark-400">Все ваши бронирования в одном месте</p>
                    </div>
                    <button class="bg-gradient-to-r from-primary-500 to-purple-600 text-white px-6 py-2.5 rounded-xl font-medium text-sm hover:shadow-lg transition-all flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <span>Новое бронирование</span>
                    </button>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4" id="bookingsCards">
                    <!-- Filled by JS -->
                </div>
            </div>