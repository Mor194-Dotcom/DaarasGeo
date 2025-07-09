@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">🗺️ Carte interactive des Daaras</h1>

        {{-- Sélecteur de style --}}
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <i class="fas fa-layer-group fa-lg me-2 text-primary"></i>
                <span>Choix du style de carte</span>
            </div>
            <div class="card-body text-center">
                <select id="carteType" onchange="changerFond()" class="form-select w-50 mx-auto">
                    <option value="m">🛣️ Roadmap</option>
                    <option value="s">🛰️ Satellite</option>
                    <option value="p">⛰️ Terrain</option>
                    <option value="h">🧪 Hybrid</option>
                </select>
            </div>
        </div>

        {{-- Barre de recherche personnalisée avec suggestions --}}
        <div class="input-group w-75 mx-auto mb-3">
            <span class="input-group-text bg-primary text-white">
                <i class="fas fa-search-location"></i>
            </span>
            <input type="text" id="searchInput" class="form-control"
                placeholder="Rechercher un village ou une adresse..." autocomplete="off">
        </div>
        <ul id="suggestions" class="list-group w-75 mx-auto mb-4" style="position: absolute; z-index: 1000;"></ul>

        {{-- Carte --}}
        <div class="card">
            <div class="card-body p-0">
                <div id="map" style="height:600px;"></div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        .marker-pin {
            width: 30px;
            height: 30px;
            border-radius: 50% 50% 50% 0;
            background: #0d6efd;
            position: absolute;
            transform: rotate(-45deg);
            left: 50%;
            top: 50%;
            margin: -15px 0 0 -15px;
        }

        .custom-div-icon i {
            position: absolute;
            font-size: 18px;
            color: white;
            left: 0;
            right: 0;
            margin: 10px auto;
            text-align: center;
        }

        #suggestions li {
            cursor: pointer;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let map, fondActuel, resultatMarker;

        document.addEventListener("DOMContentLoaded", function() {
            map = L.map('map').setView([14.6928, -17.4467], 13);
            changerFond();

            const icon = L.divIcon({
                className: 'custom-div-icon',
                html: "<div class='marker-pin'></div><i class='fas fa-school'></i>",
                iconSize: [30, 42],
                iconAnchor: [15, 42]
            });

            L.marker([14.6928, -17.4467], {
                    icon
                }).addTo(map)
                .bindPopup("🏫 Daara El Hadj");
        });

        // 🗺️ Changement de fond dynamique
        function changerFond() {
            const type = document.getElementById('carteType').value;
            const lyrs = type === 'h' ? 's,h' : type;
            const url = `https://mt1.google.com/vt/lyrs=${lyrs}&x={x}&y={y}&z={z}`;
            if (fondActuel) map.removeLayer(fondActuel);
            fondActuel = L.tileLayer(url, {
                maxZoom: 20
            }).addTo(map);
        }

        // 🔍 Recherche avec suggestions
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value;
            const list = document.getElementById('suggestions');
            list.innerHTML = '';

            if (query.length < 3) return;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(results => {
                    results.slice(0, 5).forEach(result => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item');
                        li.textContent = result.display_name;
                        li.addEventListener('click', () => {
                            map.setView([result.lat, result.lon], 15);

                            if (resultatMarker) map.removeLayer(resultatMarker);
                            resultatMarker = L.marker([result.lat, result.lon]).addTo(map)
                                .bindPopup(`📍 ${result.display_name}`).openPopup();

                            list.innerHTML = '';
                            document.getElementById('searchInput').value = result.display_name;
                        });
                        list.appendChild(li);
                    });
                });
        });
    </script>
@endpush
