@extends('owner.layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm rounded-4 mx-auto" style="max-width:920px;">
        <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Редактирование бизнеса: {{ $business->name }}</h4>
            
            <form method="POST" action="{{ route('owner.businesses.update', $business) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Скрытые поля для координат --}}
                <input type="hidden" name="latitude" id="lat" value="{{ old('latitude', $business->latitude) }}">
                <input type="hidden" name="longitude" id="lng" value="{{ old('longitude', $business->longitude) }}">

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Название</label>
                        <input name="name" value="{{ old('name', $business->name) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Категория</label>
                        <select name="business_type_id" class="form-select">
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" @selected(old('business_type_id', $business->business_type_id) == $type->id)>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Адрес</label>
                        <input name="address" value="{{ old('address', $business->address) }}" class="form-control" id="addressInput">
                    </div>
                    
                    {{-- Карта выбора локации --}}
                    <div class="col-12">
                        <div id="map" style="height: 300px; border-radius: 1rem;" class="border"></div>
                    </div>
                </div>

                {{-- Секция услуг (как в Create) --}}
                <div class="border rounded-4 p-3 mb-4 bg-light">
                    <h5 class="fw-bold mb-3">Услуги</h5>
                    @foreach($business->services as $index => $service)
                        <div class="row g-2 mb-2">
                            <input type="hidden" name="services[{{ $index }}][id]" value="{{ $service->id }}">
                            <div class="col-md-5"><input name="services[{{ $index }}][name]" value="{{ $service->name }}" class="form-control" placeholder="Название услуги"></div>
                            <div class="col-md-3"><input name="services[{{ $index }}][price]" value="{{ $service->price }}" class="form-control" placeholder="Цена"></div>
                            <div class="col-md-4"><input name="services[{{ $index }}][duration]" value="{{ $service->duration }}" class="form-control" placeholder="Время"></div>
                        </div>
                    @endforeach
                </div>

                {{-- Секция графика (как в Create) --}}
                <div class="border rounded-4 p-3 mb-4 bg-light">
                    <h5 class="fw-bold mb-3">График работы</h5>
                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                        @php $sched = $business->schedules->where('day_of_week', $day)->first(); @endphp
                        <div class="row align-items-center py-1">
                            <div class="col-md-3">{{ $day }}</div>
                            <div class="col-md-3"><input type="time" name="schedule[{{ $day }}][start]" value="{{ $sched ? substr($sched->start_time, 0, 5) : '' }}" class="form-control"></div>
                            <div class="col-md-3"><input type="time" name="schedule[{{ $day }}][end]" value="{{ $sched ? substr($sched->end_time, 0, 5) : '' }}" class="form-control"></div>
                            <div class="col-md-3">
                                <input type="checkbox" name="schedule[{{ $day }}][day_off]" value="1" @checked($sched?->is_day_off)> Выходной
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 shadow">Сохранить изменения</button>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('map').setView([{{ $business->latitude ?? 40.2735 }}, {{ $business->longitude ?? 69.6392 }}], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        var marker = L.marker([{{ $business->latitude ?? 40.2735 }}, {{ $business->longitude ?? 69.6392 }}], {draggable: true}).addTo(map);

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('lat').value = e.latlng.lat;
            document.getElementById('lng').value = e.latlng.lng;
        });

        marker.on('dragend', function() {
            document.getElementById('lat').value = marker.getLatLng().lat;
            document.getElementById('lng').value = marker.getLatLng().lng;
        });
    });
</script>
@endsection