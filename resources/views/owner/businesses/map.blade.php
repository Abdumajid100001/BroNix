<style>
    .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    .badge-service { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; transition: 0.3s; }
    .badge-service:hover { border-color: #0d6efd; transform: translateY(-2px); }
    .modal-content { border: none !important; border-radius: 24px !important; overflow: hidden; }
</style>

<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-map me-2 text-primary"></i>Ваши локации</h4>
        <a href="{{ route('owner.businesses.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            + Создать бизнес
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div id="map" style="height: 75vh; width: 100%;"></div>
    </div>

    <div class="modal fade" id="businessModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg p-0">
                <div id="modalBody"></div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('map').setView([40.2735, 69.6392], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        var businesses = @json($businesses);
        var myModal = new bootstrap.Modal(document.getElementById('businessModal'));

        businesses.forEach(function(b) {
            if (b.latitude && b.longitude) {
                var marker = L.marker([b.latitude, b.longitude]).addTo(map);
                
                marker.on('click', function() {
                    let services = (b.services || []).map(s => `
                        <div class="badge-service p-2 px-3 me-2 mb-2 d-inline-block">
                            <span class="small fw-bold">${s.name}</span><br>
                            <small class="text-primary">${s.price} с.</small>
                        </div>`).join('');

                    document.getElementById('modalBody').innerHTML = `
                        <div class="position-relative">
                            <img src="/storage/${b.image}" class="w-100" style="height: 250px; object-fit: cover;">
                            <button class="btn btn-light btn-sm rounded-pill position-absolute top-0 end-0 m-3" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg"></i>
                            </button>
                            <div class="p-4 mt-n5 bg-white position-relative" style="border-radius: 24px 24px 0 0; margin-top: -30px;">
                                <h3 class="fw-bold mb-1">${b.name}</h3>
                                <div class="text-muted small mb-3"><i class="bi bi-geo-alt"></i> ${b.address}</div>
                                
                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <div class="small text-uppercase text-muted fw-bold mb-1">Телефон</div>
                                        <div class="fw-semibold">${b.phone || '—'}</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="small text-uppercase text-muted fw-bold mb-1">Категория</div>
                                        <div class="fw-semibold">${b.type ? b.type.name : '—'}</div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="small text-uppercase text-muted fw-bold mb-2">Услуги</div>
                                    <div class="d-flex flex-wrap">${services || 'Услуги не указаны'}</div>
                                </div>

                                <a href="/owner/businesses/${b.id}/edit" class="btn btn-dark w-100 rounded-pill py-3 fw-bold">
                                    Редактировать карточку
                                </a>
                            </div>
                        </div>
                    `;
                    myModal.show();
                });
            }
        });
    });
</script>
