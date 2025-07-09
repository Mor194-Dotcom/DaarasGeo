@extends('layouts.app')

@section('title', 'Tableau de bord - Responsable')

@section('content')
    <!-- En-tête -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 text-gray-800">Bienvenue Segn {{ $user->prenom }} {{ $user->nom }} dans votre espace DaarasGeo
            <sup>.loc</sup>
        </h1>
        <span class="text-muted">{{ now()->format('d M Y – H:i') }}</span>
    </div>

    <!-- Statistiques -->
    <div class="row">
        @include('components.card-stats', [
            'label' => 'Total Daaras',
            'value' => $totalDaaras,
            'color' => 'primary',
            'icon' => 'fa-school',
        ])

        @include('components.card-stats', [
            'label' => 'Alertes reçues',
            'value' => $totalAlertes,
            'color' => 'danger',
            'icon' => 'fa-exclamation-triangle',
        ])

        @include('components.card-stats', [
            'label' => 'Zones Sécurisées',
            'value' => $totalZones,
            'color' => 'success',
            'icon' => 'fa-map-marked-alt',
        ])
    </div>

    <!-- Mes Daaras -->
    <!-- Mes Daaras -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-school mr-2"></i> Mes Daaras</h6>
            <a href="#" class="btn btn-sm btn-light">+ Ajouter</a>
        </div>
        <div class="card-body">
            @forelse ($daaras as $daara)
                <p class="mb-2">
                    <i class="fas fa-map-pin text-primary mr-1"></i>
                    <strong>{{ $daara->nom }}</strong>
                    <small class="text-muted">— Zone : {{ $daara->zone->nom ?? 'Non définie' }}</small>
                </p>
            @empty
                <p class="text-muted"><i class="fas fa-info-circle mr-1"></i> Aucun Daara enregistré.</p>
            @endforelse
        </div>
    </div>


    <!-- Alertes récentes -->
    <!-- Alertes récentes -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-bell mr-2"></i> Alertes Récentes</h6>
        </div>
        <div class="card-body">
            @forelse ($alertes as $alerte)
                <div class="mb-3 border-bottom pb-2">
                    <i class="fas fa-exclamation-circle text-danger mr-2"></i>
                    <strong>{{ $alerte->titre }}</strong><br>
                    <small class="text-muted">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ $alerte->zoneDelimitee->nom ?? 'Non spécifiée' }} •
                        <i class="far fa-clock ml-2 mr-1"></i>
                        {{ $alerte->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            @empty
                <p class="text-muted"><i class="fas fa-info-circle mr-1"></i> Aucune alerte disponible.</p>
            @endforelse
        </div>
    </div>

    <style>
        .transition {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .transition:hover {
            transform: scale(1.01);
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
        }
    </style>
@endsection
