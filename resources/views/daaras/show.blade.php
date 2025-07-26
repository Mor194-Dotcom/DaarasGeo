{{--
@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h2 class="mt-4 text-center d-flex justify-content-center align-items-center gap-2">
            <i class="fas fa-school fa-lg text-primary"></i>
            Détails du Daara
        </h2>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-info-circle me-2"></i> Informations générales
            </div>
            <div class="card-body">
                <p><strong>🏫 Nom :</strong> {{ $daara->nom }}</p>
                <p><strong>📍 Adresse :</strong> {{ $daara->adresse }}</p>
                <p><strong>🧭 Coordonnées :</strong> {{ $daara->latitude }}, {{ $daara->longitude }}</p>
                <p><strong>👤 Responsable :</strong>
                    {{ $daara->responsable->utilisateur->prenom ?? '—' }}
                    {{ $daara->responsable->utilisateur->nom ?? '++' }}
                </p>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <i class="fas fa-shield-alt me-2"></i> Zone de sécurité
            </div>
            <div class="card-body">
                @if ($daara->zoneDelimitee)
                    <p><strong>🛡️ Rayon autorisé :</strong> {{ $daara->zoneDelimitee->rayon / 1000 }} Km</p>
                    <div id="map" style="height: 300px;"></div>
                @else
                    <p class="text-muted fst-italic">Aucune zone définie</p>
                @endif
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users me-2"></i> Talibés associés</span>
                <a href="{{ route('daaras.talibes.create', ['daara' => $daara->id]) }}" class="btn btn-sm btn-outline-dark">
                    <i class="fas fa-user-plus"></i> Ajouter un talibé
                </a>
            </div>
            <div class="card-body">
                @forelse($daara->talibes as $talibe)
                    <div class="badge bg-secondary text-wrap me-2 mb-2">
                        👶 {{ $talibe->utilisateur->prenom }} {{ $talibe->utilisateur->nom }}
                    </div>
                @empty
                    <p class="text-muted fst-italic">Aucun talibé enregistré</p>
                @endforelse
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('daaras.index') }}" class="btn btn-outline-secondary">
                ← Retour à la liste
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    @if ($daara->zoneDelimitee)
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const map = L.map('map').setView([{{ $daara->latitude }}, {{ $daara->longitude }}], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                L.marker([{{ $daara->latitude }}, {{ $daara->longitude }}])
                    .addTo(map)
                    .bindPopup("{{ $daara->nom }}")
                    .openPopup();

                L.circle([{{ $daara->zoneDelimitee->latitude }}, {{ $daara->zoneDelimitee->longitude }}], {
                    radius: {{ $daara->zoneDelimitee->rayon }},
                    color: 'green',
                    fillOpacity: 0.2
                }).addTo(map);
            });
        </script>
    @endif
@endpush
 --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h2 class="mt-4 text-center d-flex align-items-center justify-content-center gap-2">
            <i class="fas fa-school text-primary"></i>
            Détails du Daara
        </h2>

        {{-- Informations générales --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-info-circle me-2"></i> Informations
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Nom :</strong> {{ $daara->nom }}</div>
                    <div class="col-md-6"><strong>Adresse :</strong> {{ $daara->adresse }}</div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Coordonnées :</strong> {{ $daara->latitude }}, {{ $daara->longitude }}
                        </div>

                        <br>
                        <div class="col-md-6">
                            <strong>Responsable :</strong>
                            {{ $daara->responsable->utilisateur->prenom ?? '—' }}
                            {{ $daara->responsable->utilisateur->nom ?? '—' }}
                        </div>
                        <div class="col-md-6"><strong>Email Responsable:</strong>
                            {{ $daara->responsable->utilisateur->email ?? 'non trouve' }}

                        </div><br>
                        <div class="col-md-6"><strong>telephone Responsable:</strong>
                            {{ $daara->responsable->telephone ?? 'non trouve' }}

                        </div><br>
                    </div>
                </div>
            </div>

            {{-- Zone de sécurité + carte --}}
            @if ($daara->zoneDelimitee)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-shield-alt me-2"></i> Zone de sécurité</span>
                        <button id="toggleMapBtn" class="btn btn-sm btn-light">
                            <i class="fas fa-map"></i> Afficher/Masquer la carte
                        </button>
                    </div>
                    <div class="card-body">
                        <p><strong>Rayon autorisé :</strong> {{ $daara->zoneDelimitee->rayon / 1000 }} Km</p>
                        <div id="mapContainer" style="display: none;">
                            <div id="map" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Talibés --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-users me-2"></i> Talibés associés</span>
                    <a href="{{ route('daaras.talibes.create', ['daara' => $daara->id]) }}"
                        class="btn btn-sm btn-outline-dark">
                        <i class="fas fa-user-plus"></i> Ajouter un talibé
                    </a>
                </div>
                <div class="card-body">
                    @forelse($daara->talibes as $talibe)
                        <div class="card mb-2 border-0 border-start border-primary">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-user me-2 text-secondary"></i>
                                    <strong>{{ $talibe->utilisateur->prenom }} {{ $talibe->utilisateur->nom }}</strong>
                                </div>
                                <a href="{{ route('talibes.show', $talibe->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted fst-italic">Aucun talibé enregistré pour ce Daara.</p>
                    @endforelse
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('daaras.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>
    @endsection
    @push('scripts')
        @if ($daara->zoneDelimitee)
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const toggleBtn = document.getElementById('toggleMapBtn');
                    const mapContainer = document.getElementById('mapContainer');

                    let mapInitialized = false;

                    toggleBtn.addEventListener('click', () => {
                        mapContainer.style.display = mapContainer.style.display === 'none' ? 'block' : 'none';

                        if (!mapInitialized && mapContainer.style.display === 'block') {
                            const map = L.map('map').setView([{{ $daara->latitude }}, {{ $daara->longitude }}],
                                15);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(map);

                            L.marker([{{ $daara->latitude }}, {{ $daara->longitude }}])
                                .addTo(map)
                                .bindPopup("{{ $daara->nom }}")
                                .openPopup();

                            L.circle([{{ $daara->zoneDelimitee->latitude }},
                                {{ $daara->zoneDelimitee->longitude }}
                            ], {
                                radius: {{ $daara->zoneDelimitee->rayon }},
                                color: 'green',
                                fillOpacity: 0.2
                            }).addTo(map);

                            mapInitialized = true;
                        }
                    });
                });
            </script>
        @endif
    @endpush
