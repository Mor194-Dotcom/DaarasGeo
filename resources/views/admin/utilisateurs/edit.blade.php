@extends('layouts.app')

@section('title', 'Détails — ' . $utilisateur->nom)

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h5 text-gray-800">
            <i class="fas fa-user-circle text-primary"></i> Détails de l’utilisateur
        </h1>
        <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-sm btn-outline-dark">
            ← Retour à la liste
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <strong>{{ $utilisateur->nom }} {{ $utilisateur->prenom }}</strong>
        </div>

        <div class="card-body">
            {{-- 📄 Infos générales --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="text-muted">Email</label>
                    <div>{{ $utilisateur->email }}</div>
                </div>
                <div class="col-md-6">
                    <label class="text-muted">Rôle</label>
                    <span
                        class="badge badge-{{ $utilisateur->isAdmin() ? 'danger' : ($utilisateur->isResponsable() ? 'warning' : ($utilisateur->isTuteur() ? 'info' : 'secondary')) }}">
                        {{ $utilisateur->role->libelle }}
                    </span>
                </div>
            </div>

            {{-- 👤 Bloc RESPONSABLE --}}
            @if ($utilisateur->isResponsable() && $utilisateur->responsableDaara)
                <hr>
                <h6 class="text-uppercase text-warning small">
                    <i class="fas fa-user-shield"></i> Responsable Daara
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-muted">Téléphone</label>
                        <div>{{ $utilisateur->responsableDaara->telephone ?? '—' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted">Daaras supervisés</label>
                        <div>{{ $utilisateur->responsableDaara->daaras->count() }}</div>
                    </div>
                </div>
            @endif

            {{-- 🧑‍🏫 Bloc TUTEUR --}}
            @if ($utilisateur->isTuteur() && $utilisateur->tuteur)
                <hr>
                <h6 class="text-uppercase text-info small">
                    <i class="fas fa-hands-helping"></i> Tuteur
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-muted">Téléphone</label>
                        <div>{{ $utilisateur->tuteur->telephone ?? '—' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted">Type</label>
                        <div>{{ $utilisateur->tuteur->getTypeTuteurEnum()?->value ?? '—' }}</div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="text-muted">Talibés suivis</label>
                        <div>{{ $utilisateur->tuteur->talibes->count() }}</div>
                    </div>
                </div>
            @endif

            {{-- 🛡️ Bloc ADMIN --}}
            @if ($utilisateur->isAdmin() && $utilisateur->administrateur)
                <hr>
                <h6 class="text-uppercase text-danger small">
                    <i class="fas fa-user-cog"></i> Administrateur
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-muted">Téléphone</label>
                        <div>{{ $utilisateur->administrateur->telephone ?? '—' }}</div>
                    </div>
                </div>
            @endif

            {{-- 📨 Message libre (Email) --}}
            <hr>
            <div class="card border-left-primary shadow mb-4">
                <div class="card-body">
                    <h6 class="text-primary mb-2">Message libre à {{ $utilisateur->nom }}</h6>
                    <form method="POST" action="{{ route('admin.utilisateurs.emailLibre', $utilisateur->id) }}">
                        @csrf
                        <textarea name="contenu" class="form-control mb-2" rows="4" placeholder="Rédigez le message à envoyer…">{{ old('contenu') }}</textarea>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-paper-plane"></i> Envoyer
                        </button>
                        <a href="{{ route('admin.utilisateurs.emailLibrePreview', $utilisateur->id) }}?contenu={{ urlencode('Bonjour depuis DAARASGEO') }}"
                            target="_blank" class="btn btn-sm btn-outline-primary ml-2">
                            <i class="fas fa-eye"></i> Prévisualiser
                        </a>
                    </form>
                </div>
            </div>

            {{-- 📱 Message libre (SMS) --}}
            <div class="card border-left-info shadow mb-4">
                <div class="card-body">
                    <h6 class="text-info mb-2">Message SMS à {{ $utilisateur->nom }}</h6>
                    <form method="POST" action="{{ route('admin.utilisateurs.smsLibre', $utilisateur->id) }}">
                        @csrf
                        <textarea name="contenu" rows="3" class="form-control mb-2" maxlength="160"
                            placeholder="Message court (160 caractères max)…"></textarea>
                        <button type="submit" class="btn btn-sm btn-info">
                            <i class="fas fa-sms"></i> Envoyer SMS
                        </button>
                        <a href="{{ route('admin.utilisateurs.smsLibrePreview', $utilisateur->id) }}?contenu={{ urlencode('Bonjour depuis DAARASGEO') }}"
                            target="_blank" class="btn btn-sm btn-outline-info ml-2">
                            <i class="fas fa-eye"></i> Prévisualiser
                        </a>
                    </form>
                </div>
            </div>

            {{-- 🗑️ Actions destructives --}}
            <hr>
            <form method="POST" action="{{ route('admin.utilisateurs.destroy', $utilisateur->id) }}"
                onsubmit="return confirm('Confirmer la suppression ?')" class="mt-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
@endsection
