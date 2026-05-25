@extends('owner.layouts.app')

@section('title', __('Добавить бизнес'))
@section('page_title', __('Добавить бизнес'))

@section('content')
    <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width:850px;">
        <div class="card-body p-4 p-md-5">

            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4">
                    <h6 class="fw-bold mb-2">⚠️ Пожалуйста, исправьте следующие ошибки:</h6>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('owner.businesses.store') }}" enctype="multipart/form-data">
                @csrf
                <h5 class="fw-bold mb-3 text-dark"> Основная информация</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Название заведения</label>
                        <input name="name" class="form-control py-2.5 rounded-3" placeholder="Например: Салон красоты 'Элегант'" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Номер телефона</label>
                        <input name="phone" class="form-control py-2.5 rounded-3" placeholder="+992 XXX XX XX" value="{{ old('phone') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-semibold text-muted">Описание заведения</label>
                        <textarea name="description" class="form-control rounded-3" rows="3" placeholder="Расскажите о вашем бизнесе...">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Категория бизнеса</label>
                        <select name="business_type_id" class="form-select py-2.5 rounded-3" required>
                            <option value="" disabled selected>Выберите категорию...</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('business_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4 mb-4">
                    <label class="form-label small fw-semibold text-muted">Главное изображение / Логотип</label>
                    <input type="file" name="image" class="form-control rounded-3 py-2" accept="image/*">
                </div>

                <div class="mt-4 border border-light-subtle rounded-4 p-4 bg-light bg-opacity-50 shadow-sm mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold text-dark"> Оказываемые услуги</h5>
                        <button type="button" id="add-service" class="btn btn-sm btn-primary px-3 rounded-3 fw-semibold">+ Добавить услугу</button>
                    </div>

                    <div id="services-wrapper">
                        @php $oldServices = old('services', [[]]); @endphp
                        @foreach($oldServices as $index => $oldService)
                            <div class="row g-2 align-items-center service-row mb-2">
                                <div class="col-md-5"><input type="text" name="services[{{ $index }}][name]" class="form-control rounded-3 py-2" value="{{ $oldService['name'] ?? '' }}" placeholder="Название услуги" required></div>
                                <div class="col-md-3"><input type="number" step="0.01" name="services[{{ $index }}][price]" class="form-control rounded-3 py-2" value="{{ $oldService['price'] ?? '' }}" placeholder="Цена" required></div>
                                <div class="col-md-3"><input type="text" name="services[{{ $index }}][duration]" class="form-control rounded-3 py-2" value="{{ $oldService['duration'] ?? '' }}" placeholder="Длительность"></div>
                                <div class="col-md-1 text-end"><button type="button" class="btn btn-outline-danger btn-sm remove-btn rounded-3 px-2.5 py-1.5">✕</button></div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 border border-light-subtle p-4 rounded-4 bg-white shadow-sm mb-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <h5 class="mb-0 fw-bold text-dark">График работы</h5>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-xs btn-outline-primary rounded-2 px-3" onclick="applyToAllDays()">Скопировать Пн на все дни</button>
                            <button type="button" class="btn btn-xs btn-outline-success rounded-2 px-3" onclick="set24_7()">Режим 24/7</button>
                        </div>
                    </div>
                    @foreach(['Monday'=>'Понедельник', 'Tuesday'=>'Вторник', 'Wednesday'=>'Среда', 'Thursday'=>'Четверг', 'Friday'=>'Пятница', 'Saturday'=>'Суббота', 'Sunday'=>'Воскресенье'] as $key => $day)
                        <div class="row align-items-center py-2 border-bottom">
                            <div class="col-md-3"><span class="fw-semibold text-secondary">{{ $day }}</span></div>
                            <div class="col-md-3"><input type="time" name="schedule[{{ $key }}][start]" class="form-control start-time" value="{{ old("schedule.$key.start", '09:00') }}"></div>
                            <div class="col-md-3"><input type="time" name="schedule[{{ $key }}][end]" class="form-control end-time" value="{{ old("schedule.$key.end", '18:00') }}"></div>
                            <div class="col-md-3 text-end"><input type="checkbox" class="form-check-input day-off" name="schedule[{{ $key }}][day_off]" value="1" {{ old("schedule.$key.day_off") ? 'checked' : '' }}> Выходной</div>
                        </div>
                    @endforeach
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Точный адрес</label>
                        <input name="address" id="address" class="form-control py-2.5 rounded-3" placeholder="Нажмите на карту для автозаполнения" value="{{ old('address') }}" required>
                    </div>
                    <div class="col-12 mt-3">
                        <label class="form-label small fw-semibold text-muted">Укажите место на карте (Худжанд)</label>
                        <div id="map" style="height: 300px; border-radius: 15px; border: 1px solid #ddd;"></div>
                        <div class="row g-2 mt-2">
                            <div class="col-6"><input type="text" name="latitude" id="lat" class="form-control" placeholder="Широта" required readonly></div>
                            <div class="col-6"><input type="text" name="longitude" id="lng" class="form-control" placeholder="Долгота" required readonly></div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold">Создать бизнес</button>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([40.2735, 69.6392], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            var marker;

            map.on('click', function(e) {
                if (marker) map.removeLayer(marker);
                marker = L.marker(e.latlng).addTo(map);
                document.getElementById('lat').value = e.latlng.lat.toFixed(6);
                document.getElementById('lng').value = e.latlng.lng.toFixed(6);

                fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${e.latlng.lat}&lon=${e.latlng.lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.display_name) document.getElementById('address').value = data.display_name;
                    });
            });
        });

        function applyToAllDays() {
            const firstStart = document.querySelector('.start-time').value;
            const firstEnd = document.querySelector('.end-time').value;
            const firstDayOff = document.querySelector('.day-off').checked;
            document.querySelectorAll('.start-time').forEach(e => e.value = firstStart);
            document.querySelectorAll('.end-time').forEach(e => e.value = firstEnd);
            document.querySelectorAll('.day-off').forEach(e => e.checked = firstDayOff);
        }

        function set24_7() {
            document.querySelectorAll('.start-time').forEach(e => e.value = "00:00");
            document.querySelectorAll('.end-time').forEach(e => e.value = "23:59");
            document.querySelectorAll('.day-off').forEach(e => e.checked = false);
        }

        let serviceIndex = document.querySelectorAll('.service-row').length;
        document.getElementById('add-service').addEventListener('click', function () {
            const wrapper = document.getElementById('services-wrapper');
            const row = document.createElement('div');
            row.className = 'row g-2 align-items-center service-row mb-2';
            row.innerHTML = `<div class="col-md-5"><input type="text" name="services[${serviceIndex}][name]" class="form-control rounded-3 py-2" placeholder="Название услуги" required></div>
                             <div class="col-md-3"><input type="number" step="0.01" name="services[${serviceIndex}][price]" class="form-control rounded-3 py-2" placeholder="Цена" required></div>
                             <div class="col-md-3"><input type="text" name="services[${serviceIndex}][duration]" class="form-control rounded-3 py-2" placeholder="Длительность"></div>
                             <div class="col-md-1 text-end"><button type="button" class="btn btn-outline-danger btn-sm remove-btn rounded-3">✕</button></div>`;
            wrapper.appendChild(row);
            serviceIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-btn')) e.target.closest('.service-row').remove();
        });
    </script>
@endsection