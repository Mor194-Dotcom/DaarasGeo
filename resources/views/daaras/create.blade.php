{{-- @extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h2 class="mt-4 text-center">
            <i class="fas fa-plus-circle me-2 text-success"></i> Ajouter un nouveau Daara
        </h2>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('daaras.store') }}" method="POST">
            @csrf

            <div class="card shadow-sm my-4">
                <div class="card-header fw-semibold">
                    <i class="fas fa-school me-2"></i> Informations générales
                </div>
                <div class="card-body row g-3">

                    <div class="col-md-6">
                        <label for="nom" class="form-label fw-semibold">Nom du Daara :</label>
                        <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom') }}"
                            required>
                    </div>

                    @php $user = Auth::user(); @endphp

                    @if ($user->isAdmin())
                        <div class="col-md-6">
                            <label for="responsable_id" class="form-label fw-semibold">Responsable :</label>
                            <select name="responsable_id" class="form-select" required>
                                @if ($responsables->isEmpty())
                                    <option disabled selected>⚠️ Aucun responsable disponible</option>
                                @else
                                    <option value="">— Choisir un responsable —</option>
                                    @foreach ($responsables as $r)
                                        <option value="{{ $r->id }}">

                                            {{ $r->utilisateur->prenom }} {{ $r->utilisateur->nom }} —
                                            {{ $r->utilisateur->email }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @elseif($user->isResponsable())
                        {{-- Champ invisible pour envoyer son propre ID
                        <input type="hidden" name="responsable_id" value="{{ optional($user->responsableDaara)->id }}">
                    @endif

                    <div class="col-md-12">
                        <label for="adresse" class="form-label fw-semibold">Adresse :</label>
                        <input type="text" name="adresse" id="adresse" class="form-control"
                            value="{{ old('adresse') }}">
                    </div>
                    <div class="mb-3">
                        <label for="rayon">Rayon de sécurité (en mètres)</label>
                        <input type="number" name="rayon" class="form-control" required min="10"
                            value="{{ old('rayon', 150) }}">
                    </div>

                    <div class="col-md-12 mt-4">
                        <label class="form-label fw-semibold"> Localisation sur la carte :</label>

                        <input id="map-search" type="text" class="form-control mb-2" placeholder="Rechercher un lieu…">

                        <select id="map-style" class="form-select mb-2 w-auto">
                            <option value="roadmap">🛣️ Roadmap</option>
                            <option value="satellite">🛰️ Satellite</option>
                            <option value="terrain">⛰️ Terrain</option>
                            <option value="hybrid">🧪 Hybrid</option>
                        </select>


                        <div id="map" style="height: 400px;"></div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label fw-semibold">Latitude :</label>
                                <input type="text" name="latitude" id="latitude" class="form-control"
                                    value="{{ old('latitude') }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label fw-semibold">Longitude :</label>
                                <input type="text" name="longitude" id="longitude" class="form-control"
                                    value="{{ old('longitude') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let map = L.map('map').setView([14.6928, -17.4467], 13);
            let marker;
            let fondActuel;

            const tileLayers = {
                roadmap: 'https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',
                satellite: 'https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',
                terrain: 'https://mt1.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',
                hybrid: 'https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}'
            };


            function chargerFond(type) {
                if (fondActuel) map.removeLayer(fondActuel);
                fondActuel = L.tileLayer(tileLayers[type], {
                    maxZoom: 20,
                    attribution: '© Google Maps (non officiel)'
                }).addTo(map);
            }


            chargerFond('roadmap');

            marker = L.marker([14.6928, -17.4467], {
                draggable: true
            }).addTo(map);
            updateCoords(marker.getLatLng());

            marker.on('dragend', function() {
                updateCoords(marker.getLatLng());
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateCoords(e.latlng);
            });

            function updateCoords(latlng) {
                document.getElementById('latitude').value = latlng.lat.toFixed(6);
                document.getElementById('longitude').value = latlng.lng.toFixed(6);
            }

            const geocoder = L.Control.geocoder({
                    defaultMarkGeocode: false
                })
                .on('markgeocode', function(e) {
                    const center = e.geocode.center;
                    map.setView(center, 15);
                    marker.setLatLng(center);
                    updateCoords(center);
                }).addTo(map);

            document.getElementById('map-search').addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    geocoder.options.geocoder.geocode(this.value, function(results) {
                        if (results.length > 0) {
                            geocoder.fire('markgeocode', {
                                geocode: results[0]
                            });
                        }
                    });
                }
            });

            document.getElementById('map-style').addEventListener('change', function() {
                chargerFond(this.value);
                marker.addTo(map);
            });
        });
    </script>
@endpush
 --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <h2 class="text-center flex-grow-1">
                <i class="fas fa-plus-circle me-2 text-success"></i> Ajouter un nouveau Daara
            </h2>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle text-danger me-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('daaras.store') }}" method="POST">
            @csrf

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light fw-semibold">
                    <i class="fas fa-school me-2"></i> Informations du Daara
                </div>
                <div class="card-body row g-3 px-3 py-4">

                    <div class="col-md-6">
                        <label for="nom" class="form-label fw-semibold">Nom du Daara :</label>
                        <input type="text" name="nom" id="nom" class="form-control border-primary-subtle"
                            value="{{ old('nom') }}" required>
                    </div>

                    @php $user = Auth::user(); @endphp

                    @if ($user->isAdmin())
                        <div class="col-md-6">
                            <label for="responsable_id" class="form-label fw-semibold">Responsable :</label>
                            <select name="responsable_id" class="form-select border-primary-subtle" required>
                                @if ($responsables->isEmpty())
                                    <option disabled selected>⚠️ Aucun responsable disponible</option>
                                @else
                                    <option value="">— Choisir un responsable —</option>
                                    @foreach ($responsables as $r)
                                        <option value="{{ $r->id }}">
                                            {{ $r->utilisateur->prenom }} {{ $r->utilisateur->nom }} —
                                            {{ $r->utilisateur->email }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @elseif($user->isResponsable())
                        <input type="hidden" name="responsable_id" value="{{ optional($user->responsableDaara)->id }}">
                    @endif

                    <div class="col-md-12">
                        <label for="adresse" class="form-label fw-semibold">Adresse :</label>
                        <input type="text" name="adresse" id="adresse" class="form-control border-primary-subtle"
                            value="{{ old('adresse') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="rayon" class="form-label fw-semibold">Rayon de sécurité :</label>
                        <div class="input-group">
                            <input type="number" name="rayon" class="form-control border-primary-subtle" required
                                min="10" value="{{ old('rayon', 150) }}">
                            <span class="input-group-text">m</span>
                        </div>
                        <small class="text-muted">Zone autour du Daara à surveiller</small>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" id="toggleMap" checked>
                            <label class="form-check-label fw-semibold" for="toggleMap">Afficher la carte</label>
                        </div>
                    </div>

                    <div class="col-md-12" id="mapContainer">
                        <label class="form-label fw-semibold mt-3">Localisation sur la carte :</label>
                        <input id="map-search" type="text" class="form-control mb-2" placeholder="Rechercher un lieu…">

                        <select id="map-style" class="form-select mb-2 w-auto">
                            <option value="roadmap">🛣️ Roadmap</option>
                            <option value="satellite">🛰️ Satellite</option>
                            <option value="terrain">⛰️ Terrain</option>
                            <option value="hybrid">🧪 Hybrid</option>
                        </select>

                        <div id="map" style="height: 350px; border-radius: 0.5rem;"></div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label fw-semibold">Latitude :</label>
                                <input type="text" name="latitude" id="latitude"
                                    class="form-control border-primary-subtle" value="{{ old('latitude') }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label fw-semibold">Longitude :</label>
                                <input type="text" name="longitude" id="longitude"
                                    class="form-control border-primary-subtle" value="{{ old('longitude') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-save me-1"></i> Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let map = L.map('map').setView([14.6928, -17.4467], 13);
            let marker;
            let fondActuel;

            const tileLayers = {
                roadmap: 'https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',
                satellite: 'https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',
                terrain: 'https://mt1.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',
                hybrid: 'https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}'
            };

            function chargerFond(type) {
                if (fondActuel) map.removeLayer(fondActuel);
                fondActuel = L.tileLayer(tileLayers[type], {
                    maxZoom: 20,
                    attribution: '© Google Maps (non officiel)'
                }).addTo(map);
            }

            chargerFond('roadmap');

            marker = L.marker([14.6928, -17.4467], {
                draggable: true
            }).addTo(map);
            updateCoords(marker.getLatLng());

            marker.on('dragend', () => updateCoords(marker.getLatLng()));
            map.on('click', e => {
                marker.setLatLng(e.latlng);
                updateCoords(e.latlng);
            });

            function updateCoords(latlng) {
                const latInput = document.getElementById('latitude');
                const lonInput = document.getElementById('longitude');

                latInput.value = latlng.lat.toFixed(6);
                lonInput.value = latlng.lng.toFixed(6);

                latInput.classList.add('border-success', 'bg-light');
                lonInput.classList.add('border-success', 'bg-light');

                const badge = document.createElement('span');
                badge.className = 'badge bg-success ms-2';
                badge.innerText = 'Coordonnées mises à jour';
                badge.style.fontSize = '0.85rem';

                document.querySelectorAll('.badge.bg-success').forEach(el => el.remove());
                latInput.parentElement.appendChild(badge);

                badge.style.opacity = '0';
                setTimeout(() => {
                    badge.style.opacity = '1';
                }, 100);
                setTimeout(() => {
                    badge.style.opacity = '0';
                    badge.remove();
                }, 2000);
            }

            const geocoder = L.Control.geocoder({
                    defaultMarkGeocode: false
                })
                .on('markgeocode', function(e) {
                    const center = e.geocode.center;
                    map.setView(center, 15);
                    marker.setLatLng(center);
                    updateCoords(center);
                }).addTo(map);

            document.getElementById('map-search').addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    geocoder.options.geocoder.geocode(this.value, function(results) {
                        if (results.length > 0) {
                            geocoder.fire('markgeocode', {
                                geocode: results[0]
                            });
                        }
                    });
                }
            });

            document.getElementById('map-style').addEventListener('change', function() {
                chargerFond(this.value);
                marker.addTo(map);
            });

            document.getElementById('toggleMap').addEventListener('change', function() {
                document.getElementById('mapContainer').style.display = this.checked ? 'block' : 'none';
            });

            // 🧭 Auto-positionnement GPS si autorisé
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(pos) {
                    const latlng = L.latLng(pos.coords.latitude, pos.coords.longitude);
                    marker.setLatLng(latlng);
                    map.setView(latlng, 15);
                    updateCoords(latlng);
                });
            }
        });
    </script>
@endpush
