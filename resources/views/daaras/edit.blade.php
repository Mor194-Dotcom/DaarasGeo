{{-- @extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center text-primary fw-bold">🛠️ Modifier le Daara</h1>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('daaras.index') }}">
                    <i class="fas fa-arrow-left me-1"></i> Daaras
                </a>
            </li>
            <li class="breadcrumb-item active">Édition</li>
        </ol>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-school me-2"></i> Informations générales</div>
            <div class="card-body">
                <form action="{{ route('daaras.update', $daara->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{ old('nom', $daara->nom) }}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control"
                                value="{{ old('adresse', $daara->adresse) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="form-control"
                                value="{{ old('latitude', $daara->latitude) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="longitude" class="form-control"
                                value="{{ old('longitude', $daara->longitude) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rayon de sécurité (m)</label>
                        <input type="number" name="rayon" id="rayon" class="form-control" min="10"
                            value="{{ old('rayon', $daara->zoneDelimitee?->rayon ?? 150) }}" required>
                    </div>

                    @can('admin')
                        <div class="mb-3">
                            <label class="form-label">Responsable</label>
                            <select name="responsable_id" class="form-select">
                                @foreach ($responsables as $resp)
                                    <option value="{{ $resp->id }}"
                                        {{ $resp->id == $daara->responsable_id ? 'selected' : '' }}>
                                        {{ $resp->prenom }} {{ $resp->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endcan

                    <button type="submit" class="btn btn-success mt-2">
                        <i class="fas fa-check-circle me-1"></i> Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>

        {{-- Sélecteur de tuiles         <div class="card mb-3">
            <div class="card-header"><i class="fas fa-layer-group me-2"></i> Type de carte</div>
            <div class="card-body text-center">
                <select id="carteType" class="form-select w-50 mx-auto">
                    <option value="m">🛣️ Roadmap</option>
                    <option value="s">🛰️ Satellite</option>
                    <option value="p">⛰️ Terrain</option>
                    <option value="h" selected>🧪 Hybrid</option>
                </select>
            </div>
        </div>

        {{-- Carte interactive
        <div class="card">
            <div class="card-header"><i class="fas fa-map-marked-alt me-2"></i> Localisation</div>
            <div class="card-body p-0">
                <div id="map" style="height: 450px;"></div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map, fondActuel, cercle, marker;

        document.addEventListener("DOMContentLoaded", function() {
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const rayonInput = document.getElementById('rayon');
            const fondSelect = document.getElementById('carteType');

            const lat = parseFloat(latInput.value) || 14.6928;
            const lng = parseFloat(lngInput.value) || -17.4467;
            const rayon = parseInt(rayonInput.value) || 150;

            map = L.map('map').setView([lat, lng], 15);
            chargerFondGoogle(fondSelect.value);

            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);
            cercle = L.circle([lat, lng], {
                radius: rayon,
                color: 'blue',
                fillOpacity: 0.3
            }).addTo(map);

            marker.on('drag', function(e) {
                const pos = marker.getLatLng();
                latInput.value = pos.lat.toFixed(6);
                lngInput.value = pos.lng.toFixed(6);
                cercle.setLatLng(pos);
            });

            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                marker.setLatLng([lat, lng]);
                cercle.setLatLng([lat, lng]);
                latInput.value = lat.toFixed(6);
                lngInput.value = lng.toFixed(6);
            });

            rayonInput.addEventListener('input', function() {
                cercle.setRadius(parseInt(this.value) || 0);
            });

            fondSelect.addEventListener('change', function() {
                chargerFondGoogle(this.value);
            });
        });

        function chargerFondGoogle(type) {
            const lyrs = type === 'h' ? 's,h' : type;
            const url = `https://mt1.google.com/vt/lyrs=${lyrs}&x={x}&y={y}&z={z}`;

            if (fondActuel) map.removeLayer(fondActuel);

            fondActuel = L.tileLayer(url, {
                maxZoom: 20,
                attribution: "Google Maps tiles (unofficial)"
            }).addTo(map);
        }
    </script>
@endpush
 --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h2 class="mt-4 text-center text-primary d-flex align-items-center justify-content-center gap-2">
            <i class="fas fa-edit"></i> Modifier le Daara
        </h2>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('daaras.index') }}">
                    <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                </a>
            </li>
            <li class="breadcrumb-item active">Édition</li>
        </ol>

        @if (session('success'))
            <div class="alert alert-success text-center">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('daaras.update', $daara->id) }}" method="POST" class="card shadow-sm mb-4 p-4">
            @csrf @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nom du Daara</label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom', $daara->nom) }}"
                        required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $daara->adresse) }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Latitude</label>
                    <input type="text" name="latitude" id="latitude" class="form-control"
                        value="{{ old('latitude', $daara->latitude) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Longitude</label>
                    <input type="text" name="longitude" id="longitude" class="form-control"
                        value="{{ old('longitude', $daara->longitude) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Rayon de sécurité (mètres)</label>
                <input type="number" name="rayon" id="rayon" class="form-control" min="10"
                    value="{{ old('rayon', $daara->zoneDelimitee?->rayon ?? 150) }}" required>
            </div>

            @can('admin')
                <div class="mb-3">
                    <label class="form-label">Responsable</label>
                    <select name="responsable_id" class="form-select">
                        @foreach ($responsables as $resp)
                            <option value="{{ $resp->id }}" {{ $resp->id == $daara->responsable_id ? 'selected' : '' }}>
                                {{ $resp->prenom }} {{ $resp->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endcan

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-save me-2"></i> Enregistrer
                </button>
            </div>
        </form>

        {{-- Sélecteur de fond de carte --}}
        <div class="card mb-3">
            <div class="card-header bg-light">
                <i class="fas fa-layer-group me-2"></i> Style de carte
            </div>
            <div class="card-body text-center">
                <select id="carteType" class="form-select w-50 mx-auto">
                    <option value="m">Roadmap</option>
                    <option value="s">Satellite</option>
                    <option value="p">Terrain</option>
                    <option value="h" selected>Hybrid</option>
                </select>
            </div>
        </div>

        {{-- Carte interactive --}}
        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <span><i class="fas fa-map-marked-alt me-2"></i> Localisation sur la carte</span>
                <button id="toggleMapBtn" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-eye-slash me-1"></i> Afficher/Masquer
                </button>
            </div>
            <div class="card-body p-0" id="mapContainer">
                <div id="map" style="height: 450px;"></div>
            </div>
        </div>

    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map, fondActuel, cercle, marker;

        document.addEventListener("DOMContentLoaded", function() {
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const rayonInput = document.getElementById('rayon');
            const fondSelect = document.getElementById('carteType');
            const toggleBtn = document.getElementById('toggleMapBtn');
            const mapContainer = document.getElementById('mapContainer');

            // 🧭 Masquer la carte par défaut (optionnel)
            // mapContainer.style.display = 'none';

            // 🎯 Bouton toggle carte
            toggleBtn.addEventListener('click', () => {
                const isVisible = mapContainer.style.display !== 'none';
                mapContainer.style.display = isVisible ? 'none' : 'block';
                toggleBtn.innerHTML = isVisible ?
                    '<i class="fas fa-eye me-1"></i> Afficher' :
                    '<i class="fas fa-eye-slash me-1"></i> Masquer';
            });

            // 📍 Initialisation de la carte
            const lat = parseFloat(latInput.value) || 14.6928;
            const lng = parseFloat(lngInput.value) || -17.4467;
            const rayon = parseInt(rayonInput.value) || 150;

            map = L.map('map').setView([lat, lng], 15);
            chargerFondGoogle(fondSelect.value);

            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);
            cercle = L.circle([lat, lng], {
                radius: rayon,
                color: 'blue',
                fillOpacity: 0.3
            }).addTo(map);

            // 📦 Drag du marker
            marker.on('drag', function(e) {
                const pos = marker.getLatLng();
                latInput.value = pos.lat.toFixed(6);
                lngInput.value = pos.lng.toFixed(6);
                cercle.setLatLng(pos);
            });

            // 🖱️ Clic sur la carte
            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                marker.setLatLng([lat, lng]);
                cercle.setLatLng([lat, lng]);
                latInput.value = lat.toFixed(6);
                lngInput.value = lng.toFixed(6);
            });

            // 🔄 Changement du rayon
            rayonInput.addEventListener('input', function() {
                cercle.setRadius(parseInt(this.value) || 0);
            });

            // 🎨 Changement du fond
            fondSelect.addEventListener('change', function() {
                chargerFondGoogle(this.value);
            });
        });

        // 🗺️ Chargement du fond Google
        function chargerFondGoogle(type) {
            const lyrs = type === 'h' ? 's,h' : type;
            const url = `https://mt1.google.com/vt/lyrs=${lyrs}&x={x}&y={y}&z={z}`;

            if (fondActuel) map.removeLayer(fondActuel);

            fondActuel = L.tileLayer(url, {
                maxZoom: 20,
                attribution: "Google Maps tiles (unofficial)"
            }).addTo(map);
        }
    </script>
@endpush
