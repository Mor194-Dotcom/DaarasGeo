@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- En-tête -->
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h4 class="text-gray-800">
                <i class="fas fa-route text-primary mr-2"></i> Parcours du Talibé
            </h4>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('talibes.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <!-- Informations + Options -->
    <div class="row">
        <!-- Infos Talibé -->
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4 border-left-info">
                <div class="card-header bg-info text-white">Informations du Talibé</div>
                <div class="card-body">
                    <ul class="list-unstyled small">
                        <li><strong>Nom :</strong> {{ $talibe->utilisateur->prenom }} {{ $talibe->utilisateur->nom }}</li>
                        <li><strong>Daara :</strong> {{ $talibe->daara->nom ?? '-' }}</li>
                        <li><strong>Zone :</strong> {{ $talibe->zone->nom ?? ($talibe->daara->zoneDelimitee->rayon / 1000 ?? '-') }} km</li>
                        <li><strong>Position actuelle :</strong> {{ $talibe->latitude }}, {{ $talibe->longitude }}</li>
                        <li><strong>Date de naissance :</strong> {{ $talibe->date_naissance ?? '-' }}</li>
                    </ul>
                    @if ($talibe->photo)
                        <img src="{{ asset('storage/' . $talibe->photo) }}" class="img-fluid rounded border mt-3" style="max-height:180px; object-fit:cover;">
                    @endif
                </div>
            </div>
        </div>

        <!-- Options -->
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4 border-left-secondary">
                <div class="card-header bg-secondary text-white">Options d'affichage</div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="carteType">Fond de carte</label>
                        <select id="carteType" class="form-control form-control-sm w-75">
                            <option value="m">Route</option>
                            <option value="s">Satellite</option>
                            <option value="h">Hybride</option>
                            <option value="t">Relief</option>
                            <option value="osm">OpenStreetMap</option>
                        </select>
                    </div>
                    <button id="exportCsv" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-file-download"></i> Exporter le parcours (.csv)
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Carte -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            Carte de suivi
        </div>
        <div class="card-body p-0">
            <div id="map" style="height: 400px;"></div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const map = L.map('map').setView([{{ $talibe->latitude ?? 14.6928 }}, {{ $talibe->longitude ?? -17.4467 }}], 15);
    let fondActuel;

    function changerFond() {
        const type = document.getElementById('carteType').value;
        if (fondActuel) map.removeLayer(fondActuel);

        if (type === 'osm') {
            fondActuel = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            });
        } else {
            const lyrs = type === 'h' ? 's,h' : type;
            const url = `https://mt1.google.com/vt/lyrs=${lyrs}&x={x}&y={y}&z={z}`;
            fondActuel = L.tileLayer(url, { maxZoom: 20 });
            fondActuel.on('tileerror', () => {
                console.warn("Tuiles Google indisponibles ➝ bascule OSM");
                map.removeLayer(fondActuel);
                fondActuel = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            });
        }

        fondActuel.addTo(map);
    }

    changerFond();
    document.getElementById('carteType').addEventListener('change', changerFond);

    // Tracé GPS
    const positions = {!! json_encode(
        $talibe->historiques->map(fn($h) => [
            'lat' => $h->latitude,
            'lng' => $h->longitude,
            'date' => \Carbon\Carbon::parse($h->date)->format('d/m/Y H:i'),
        ])
    ) !!};

    const latlngs = positions.map(p => [p.lat, p.lng]);
    if (latlngs.length > 1) {
        L.polyline(latlngs, { color: 'blue', weight: 3 }).addTo(map);
    }

    positions.forEach(p => {
        L.marker([p.lat, p.lng]).addTo(map).bindPopup(p.date);
    });

    // Export CSV
    document.getElementById('exportCsv').addEventListener('click', () => {
        let csv = "latitude,longitude,date\n";
        positions.forEach(p => csv += `${p.lat},${p.lng},${p.date}\n`);
        const blob = new Blob([csv], { type: 'text/csv' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = "parcours_talibe.csv";
        a.click();
    });
</script>
@endpush
