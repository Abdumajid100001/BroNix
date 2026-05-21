  <section class="section booking-section" id="booking">
        <div class="section-inner">
            <div class="booking-layout">
                <div class="booking-info observe">
                    <div class="section-label">Бронирование</div>
                    <h3>Забронируйте место за пару кликов</h3>
                    <p>Больше никаких звонков и ожидания ответа. Выберите бизнес, дату и время — мы мгновенно подтвердим вашу бронь.</p>
                    <div class="booking-steps">
                        <div class="booking-step">
                            <div class="booking-step-num">1</div>
                            <div><h4>Выберите бизнес</h4><p>Найдите подходящий ресторан, салон или студию</p></div>
                        </div>
                        <div class="booking-step">
                            <div class="booking-step-num">2</div>
                            <div><h4>Укажите дату и время</h4><p>Выберите удобное время из доступных слотов</p></div>
                        </div>
                        <div class="booking-step">
                            <div class="booking-step-num">3</div>
                            <div><h4>Получите подтверждение</h4><p>Мгновенное подтверждение на email и в приложении</p></div>
                        </div>
                    </div>
                </div>
                <div class="booking-card observe observe-delay-2">
                    <h3>Запись на бронирование</h3>
                    <p class="booking-card-subtitle">Заполните форму и получите подтверждение за 1 минуту</p>
                    <form class="booking-form" onsubmit="handleBooking(event)">
                        <div class="booking-field">
                            <label>Ваше имя</label>
                            <input type="text" class="booking-input" placeholder="Иван Иванов" required>
                        </div>
                        <div class="booking-field">
                            <label>Телефон</label>
                            <input type="tel" class="booking-input" placeholder="+7 (999) 123-45-67" required>
                        </div>
                        <div class="booking-field">
                            <label>Бизнес</label>
                            <input type="text" id="bookingBusiness" class="booking-input" placeholder="Выберите бизнес" required>
                        </div>
                        <div class="booking-row">
                            <div class="booking-field">
                                <label>Дата</label>
                                <input type="date" class="booking-input" required>
                            </div>
                            <div class="booking-field">
                                <label>Время</label>
                                <input type="time" class="booking-input" required>
                            </div>
                        </div>
                        <div class="booking-field">
                            <label>Количество гостей</label>
                            <select class="booking-input">
                                <option>1 человек</option>
                                <option selected>2 человека</option>
                                <option>3 человека</option>
                                <option>4 человека</option>
                                <option>5+ человек</option>
                            </select>
                        </div>
                        <button type="submit" class="booking-submit">Забронировать →</button>
                    </form>
                </div>
            </div>
        </div>
    </section>