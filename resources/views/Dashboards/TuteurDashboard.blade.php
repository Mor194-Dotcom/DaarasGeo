@extends('layouts.app')

@section('title', 'Tableau de bord Tuteur')

@section('content')
    <div class="container-fluid">

        <!-- En-tête -->
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <h4 class="text-gray-800">
                    <i class="fas fa-user-shield text-primary mr-2"></i>
                    Bonjour {{ $tuteur->utilisateur->prenom }} {{ $tuteur->utilisateur->nom }}

                </h4>
                <h5>Bienvenue dans la plateforme <strong>DAARAGEO</strong><sup>.loc</sup> pret a suivre tes petits
                </h5>
                <span class="badge badge-pill badge-secondary mt-1">
                    Type de tuteur : {{ $tuteur->type_tuteur }}
                </span>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="row mb-4">
            @include('components.card-stats', [
                'label' => 'Talibés supervisés',
                'value' => $totalTalibes,
                'color' => 'primary',
                'icon' => 'fa-users',
            ])
            @include('components.card-stats', [
                'label' => 'Alertes actives',
                'value' => $alertes->count(),
                'color' => 'danger',
                'icon' => 'fa-bell',
            ])
        </div>

        <!-- Section Alertes -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Alertes des Talibés
                </h6>
            </div>
            <div class="card-body">
                @forelse ($alertes as $alerte)
                    @php
                        $talibe = $talibes->firstWhere('utilisateur_id', $alerte->utilisateur_id);
                    @endphp

                    <div class="border-left-danger pl-3 mb-3 pb-2">
                        <h6 class="font-weight-bold text-dark">{{ ucfirst($alerte->statut) }}</h6>
                        <div class="text-muted small">
                            Talibé : <strong>{{ $talibe?->utilisateur->prenom ?? 'Indéfini' }}</strong><br>
                            Émise le : {{ \Carbon\Carbon::parse($alerte->date)->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Aucune alerte en cours pour vos Talibés.</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection
