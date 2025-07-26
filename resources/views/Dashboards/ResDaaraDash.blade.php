{{-- @extends('layouts.app')

@section('title', 'Dashboard Responsable')

@section('content')
    <div class="container-fluid px-4">
        <!-- 🧭 En-tête -->
        <div class="d-flex justify-content-between flex-wrap align-items-center mb-4">
            <div>
                <h2 class="h4 text-dark">Bienvenue {{ $user->prenom }} {{ $user->nom }}</h2>
                <p class="text-muted">Responsable DaarasGeo <sup>.loc</sup></p>
            </div>
            <span class="badge bg-light text-dark">{{ now()->format('d M Y – H:i') }}</span>
        </div>

        <!-- 📊 Statistiques -->
        <div class="row g-3 mb-4">
            @include('components.card-stats', [
                'label' => 'Mes Daaras',
                'value' => $totalDaaras,
                'color' => 'primary',
                'icon' => 'fa-school',
            ])
            @include('components.card-stats', [
                'label' => 'Alertes reçues',
                'value' => $totalAlertes,
                'color' => 'danger',
                'icon' => 'fa-bell',
            ])
            @include('components.card-stats', [
                'label' => 'Zones Sécurisées',
                'value' => $totalZones,
                'color' => 'success',
                'icon' => 'fa-shield-alt',
            ])
        </div>

        <!-- 🏫 Liste des Daaras -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="m-0"><i class="fas fa-school me-2"></i> Mes Daaras</h6>
                <a href="{{ route('daaras.create') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-plus-circle me-1"></i> Ajouter
                </a>
            </div>
            <div class="card-body">
                @forelse ($daaras as $daara)
                    <div class="d-flex align-items-center mb-3 p-2 rounded shadow-sm transition">
                        <i class="fas fa-map-pin fa-lg text-primary me-3"></i>
                        <div>
                            <div class="fw-bold text-dark">{{ $daara->nom }}</div>
                            <small class="text-muted">
                                🛡️ Zone : {{ $daara->zoneDelimitee->nom ?? 'Non définie' }}
                            </small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted"><i class="fas fa-info-circle me-1"></i> Aucun Daara enregistré.</p>
                @endforelse
            </div>
        </div>

        <!-- 🚨 Alertes Récentes -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-danger text-white">
                <h6 class="m-0"><i class="fas fa-exclamation-triangle me-2"></i> Alertes Récentes</h6>
            </div>
            <div class="card-body">
                @forelse ($alertes as $alerte)
                    <div class="mb-3 border-bottom pb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="text-danger">
                                <i class="fas fa-bell me-1"></i> {{ $alerte->titre }}
                            </strong>
                            <span class="badge bg-light text-muted">{{ $alerte->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $alerte->zoneDelimitee->nom ?? 'Zone non spécifiée' }}
                        </small>
                    </div>
                @empty
                    <p class="text-muted"><i class="fas fa-info-circle me-1"></i> Aucune alerte enregistrée.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .transition {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .transition:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush
 --}}
@extends('layouts.app')

@section('title', 'Dashboard Responsable')

@section('content')
    <div class="container-fluid px-4">
        <!-- 🧭 En-tête -->
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <div>
                <h2 class="h4 text-dark">Bienvenue {{ $user->prenom }} {{ $user->nom }}</h2>
                <p class="text-muted">Responsable DaarasGeo <sup>.loc</sup></p>
            </div>
            <span class="badge bg-light text-dark">{{ now()->format('d M Y – H:i') }}</span>
        </div>

        <!-- 📊 Statistiques -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-4">
                <div class="card h-100 border-0 shadow-sm transition">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box bg-primary text-white me-3">
                            <i class="fas fa-school fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Daaras enregistrés</h6>
                            <h4 class="mb-0 text-dark fw-bold">{{ $totalDaaras }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card h-100 border-0 shadow-sm transition">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box bg-warning text-white me-3">
                            <i class="fas fa-user-graduate fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Talibés suivis</h6>
                            <h4 class="mb-0 text-dark fw-bold">{{ $totalTalibes }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card h-100 border-0 shadow-sm transition">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box bg-danger text-white me-3">
                            <i class="fas fa-bell fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted">Alertes reçues</h6>
                            <h4 class="mb-0 text-dark fw-bold">{{ $totalAlertes }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🏫 Mes Daaras -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="m-0"><i class="fas fa-school me-2"></i> Mes Daaras</h6>
                <a href="{{ route('daaras.create') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-plus-circle me-1"></i> Ajouter
                </a>
            </div>
            <div class="card-body">
                @forelse ($daaras as $daara)
                    <div class="d-flex align-items-center mb-3 p-2 rounded shadow-sm transition">
                        <i class="fas fa-map-pin fa-lg text-primary me-3"></i>
                        <div>
                            <div class="fw-bold text-dark">{{ $daara->nom }}</div>
                            <small class="text-muted">
                                🛡️ Rayon de Securite : {{ $daara->zoneDelimitee->rayon / 1000 ?? 'Non définie' }} km
                            </small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted"><i class="fas fa-info-circle me-1"></i> Aucun Daara enregistré.</p>
                @endforelse
            </div>
        </div>

        <!-- 🚨 Alertes Récentes -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-danger text-white">
                <h6 class="m-0"><i class="fas fa-exclamation-triangle me-2"></i> Alertes Récentes</h6>
            </div>
            <div class="card-body">
                @forelse ($alertes as $alerte)
                    <div class="mb-3 border-bottom pb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="text-danger">
                                <i class="fas fa-bell me-1"></i> {{ $alerte->titre }}
                            </strong>
                            <span class="badge bg-light text-muted">{{ $alerte->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            <strong>
                                Id talibe: {{ $alerte->utilisateur_id }},
                                Nom: {{ $alerte->utilisateur->prenom }} {{ $alerte->utilisateur->nom }},
                                Distance: {{ $alerte->distance / 1000 }} km;
                            </strong>
                        </small>
                    </div>
                @empty
                    <p class="text-muted"><i class="fas fa-info-circle me-1"></i> Aucune alerte enregistrée.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .transition {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .transition:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
    </style>
@endpush
