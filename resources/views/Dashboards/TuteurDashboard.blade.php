@extends('layouts.app')

@section('title', 'Tableau de bord Tuteur')

@section('content')
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1 class="h4 text-gray-800">👋 Bonjour {{ $tuteur->utilisateur->prenom }}</h1>
        <span class="text-muted">Type : <strong>{{ $tuteur->type_tuteur }}</strong></span>
    </div>

    <!-- Cartes stats -->
    <div class="row mb-4">
        @include('components.card-stats', [
            'label' => 'Talibés supervisés',
            'value' => $totalTalibes,
            'color' => 'primary',
            'icon' => 'fa-user-graduate',
        ])
        @include('components.card-stats', [
            'label' => 'Alertes récentes',
            'value' => $alertes->count(),
            'color' => 'danger',
            'icon' => 'fa-bell',
        ])
    </div>

    <!-- Alertes -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i> Alertes des Talibés</h6>
        </div>
        <div class="card-body">
            @forelse ($alertes as $alerte)
                <div class="mb-3 border-bottom pb-2">
                    <strong>{{ $alerte->titre }}</strong><br>
                    <small class="text-muted">
                        Talibé : {{ $alerte->talibe->nom ?? 'Indéfini' }} •
                        {{ $alerte->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            @empty
                <p class="text-muted">Aucune alerte enregistrée.</p>
            @endforelse
        </div>
    </div>
@endsection
