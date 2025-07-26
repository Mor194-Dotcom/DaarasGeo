@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <!-- 🔝 En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-primary"><i class="fas fa-id-badge me-2"></i> Mon Profil</h2>
                <span class="badge bg-info text-white">{{ $utilisateur->role->libelle ?? 'Non défini' }}</span>
            </div>
            <!-- 🔙 Bouton retour -->
            @switch($utilisateur->role->libelle ?? '')
                @case('Administrateur')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Retour Admin
                    </a>
                @break

                @case('ResponsableDaara')
                    <a href="{{ route('responsableDash') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Retour Daara
                    </a>
                @break

                @case('Tuteur')
                    <a href="{{ route('tuteur.dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Retour Talibés
                    </a>
                @break

                @default
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Accueil
                    </a>
            @endswitch
        </div>

        <!-- 👤 Carte profil -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row g-4 align-items-center">
                    <div class="col-md-3 text-center">
                        <img src="https://ui-avatars.com/api/?name={{ $utilisateur->prenom }}&background=0D6EFD&color=fff"
                            class="rounded-circle border border-primary" width="100" alt="Avatar">
                    </div>
                    <div class="col-md-9">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th>Nom</th>
                                <td>{{ $utilisateur->nom }}</td>
                            </tr>
                            <tr>
                                <th>Prénom</th>
                                <td>{{ $utilisateur->prenom }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $utilisateur->email }}</td>
                            </tr>
                            <tr>
                                <th>Adresse</th>
                                <td>{{ $utilisateur->adresse ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Téléphone</th>
                                <td>{{ $utilisateur->getNumeroValide() ?? '—' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
