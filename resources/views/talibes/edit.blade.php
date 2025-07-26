@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- En-tête -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h4 class="text-gray-800">
                <i class="fas fa-user-edit text-warning mr-2"></i> Modifier Talibé : {{ $talibe->utilisateur->prenom }}
                {{ $talibe->utilisateur->nom }}
            </h4>
            <a href="{{ route('talibes.show', $talibe) }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <!-- Formulaire -->
        <form method="POST" action="{{ route('talibes.update', $talibe) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    Informations du Talibé
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Colonne gauche -->
                        <div class="col-md-6">
                            <input type="text" name="prenom" class="form-control form-control-sm mb-2"
                                value="{{ old('prenom', $talibe->utilisateur->prenom) }}" placeholder="Prénom" required>

                            <input type="text" name="nom" class="form-control form-control-sm mb-2"
                                value="{{ old('nom', $talibe->utilisateur->nom) }}" placeholder="Nom" required>

                            <input type="text" name="adresse" class="form-control form-control-sm mb-2"
                                value="{{ old('adresse', $talibe->utilisateur->adresse) }}" placeholder="Adresse">

                            <input type="date" name="date_naissance" class="form-control form-control-sm mb-2"
                                value="{{ old('date_naissance', $talibe->date_naissance) }}">

                            <select name="tuteur_id" class="form-control form-control-sm mb-2">
                                <option value="">Tuteur (optionnel)</option>
                                @foreach ($tuteurs as $t)
                                    <option value="{{ $t->id }}"
                                        {{ $talibe->tuteur_id == $t->id ? 'selected' : '' }}>
                                        {{ $t->utilisateur->prenom }} {{ $t->utilisateur->nom }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="zone_id" class="form-control form-control-sm mb-2">
                                <option value="">Zone héritée du Daara</option>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone->id }}"
                                        {{ $talibe->zone_id == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->nom }} ({{ $zone->rayon }} m)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Colonne droite -->
                        <div class="col-md-6">
                            @if ($talibe->photo)
                                <img src="{{ asset('storage/' . $talibe->photo) }}" class="img-fluid rounded mb-2 border"
                                    style="max-height:200px; object-fit: cover;" alt="Photo du Talibé">
                            @endif

                            <input type="file" name="photo" class="form-control form-control-sm mb-3">

                            <div class="small text-muted">
                                Position actuelle :<br>
                                Latitude : <strong>{{ $talibe->latitude }}</strong><br>
                                Longitude : <strong>{{ $talibe->longitude }}</strong><br>
                                Mise à jour automatique
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <a href="{{ route('talibes.show', $talibe) }}" class="btn btn-sm btn-secondary ml-2">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
