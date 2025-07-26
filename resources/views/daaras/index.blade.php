@extends('layouts.app')

@section('content')
    @php $user = Auth::user(); @endphp

    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">
            <i class="fas fa-school me-2"></i>
            @if ($user->isAdmin())
                Liste complète des Daaras
            @elseif ($user->isResponsable())
                Mes Daaras enregistrés
            @else
                Daaras géolocalisés
            @endif
        </h1>

        @if (session('success'))
            <div class="alert alert-success text-center mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list-alt me-2"></i>
                    @if ($user->isAdmin())
                        Daaras enregistrés
                    @else
                        Mes Daaras
                    @endif
                </h5>

                @if ($user->isAdmin() || $user->isResponsable())
                    <a href="{{ route('daaras.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Ajouter un Daara
                    </a>
                @endif

            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            @if ($user->isAdmin())
                                <th>Responsable</th>
                            @endif
                            <th>Adresse</th>
                            <th>Coordonnées</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daaras as $daara)
                            <tr>
                                <td>{{ $daara->id }}</td>
                                <td class="fw-bold">{{ $daara->nom }}</td>

                                @if ($user->isAdmin())
                                    <td>{{ $daara->responsable->utilisateur->prenom ?? '++' }}
                                        {{ $daara->responsable->utilisateur->nom ?? '++' }}</td>
                                @endif

                                <td>{{ $daara->adresse }}</td>
                                <td class="text-muted">{{ $daara->latitude }}, {{ $daara->longitude }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('daaras.show', ['daara' => $daara]) }}"
                                        class="btn btn-sm btn-outline-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if ($user->isAdmin() || $daara->responsable_id === optional($user->responsableDaara)->id)
                                        <a href="{{ route('daaras.edit', $daara) }}" class="btn btn-sm btn-outline-warning"
                                            title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('daaras.destroy', $daara) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Confirmer la suppression du Daara ?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('cartes.index', ['daara' => $daara->id]) }}"
                                        class="btn btn-sm btn-outline-secondary" title="Voir sur la carte">
                                        <i class="fas fa-map-pin"></i>
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $user->isAdmin() ? 6 : 5 }}" class="text-muted fst-italic">Aucun Daara
                                    disponible.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($user->isAdmin())
            <div><a href="{{ route('zones.admin.missing') }}">ajouter les zones de securites</a> </div>
        @endif
    </div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mapButtons = document.querySelectorAll('.map-button');

            mapButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const daaraId = this.dataset.daaraId;
                    const lat = parseFloat(this.dataset.lat);
                    const lng = parseFloat(this.dataset.lng);
                    const nom = this.dataset.nom;

                    document.querySelectorAll('.popover').forEach(pop => pop.remove());

                    const container = document.createElement('div');
                    container.id = `map-${daaraId}`;
                    container.style.height = '150px';
                    container.style.width = '250px';

                    const popover = new bootstrap.Popover(this, {
                        html: true,
                        content: container,
                        placement: 'left',
                        trigger: 'manual',
                        title: `Daara : ${nom}`
                    });

                    popover.show();

                    setTimeout(() => {
                        const map = L.map(`map-${daaraId}`).setView([lat, lng], 15);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap'
                        }).addTo(map);

                        L.marker([lat, lng]).addTo(map).bindPopup(nom).openPopup();
                    }, 150);
                });
            });

            document.addEventListener('click', function(e) {
                mapButtons.forEach(btn => {
                    if (!btn.contains(e.target)) {
                        bootstrap.Popover.getInstance(btn)?.hide();
                    }
                });
            });
        });
    </script>
@endpush
