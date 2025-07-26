@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- En-tête -->
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <h4 class="text-gray-800">
                    <i class="fas fa-user text-primary mr-2"></i> Détails du Talibé
                </h4>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('talibes.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>

        <!-- Informations -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">Informations principales</div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <strong>Nom :</strong> {{ $talibe->utilisateur->prenom }} {{ $talibe->utilisateur->nom }}
                    </div>
                    <div class="col-md-6">
                        <strong>Date de naissance :</strong> {{ $talibe->date_naissance ?? '-' }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <strong>Daara :</strong> {{ $talibe->daara->nom ?? '-' }}
                    </div>
                    {{--  <div class="col-md-6">
                        <strong>distance vs Daara :</strong>
                        {{ $talibe->zone->nom ?? ($talibe->daara->zoneDelimitee->distance ?? '-') }}
                    </div> --}}
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <strong>Tuteur :</strong> {{ $talibe->tuteur->utilisateur->prenom ?? 'assigner un tuteur... ' }}
                        {{ $talibe->tuteur->utilisateur->nom ?? '.' }} <br>
                        @if ($talibe->tuteur)
                            <strong>Telephone Du Tuteur:</strong> {{ $talibe->tuteur->telephone ?? '-' }}
                        @endif
                    </div>
                    <div class="col-md-6">
                        <strong>Position actuelle :</strong> {{ $talibe->latitude }}, {{ $talibe->longitude }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Photo -->
        @if ($talibe->photo)
            <div class="card mb-4 border-left-primary shadow-sm">
                <div class="card-header bg-primary text-white">Photo du Talibé</div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $talibe->photo) }}" alt="Photo du Talibé"
                        class="img-fluid rounded border" style="max-height: 280px; object-fit: cover;">
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light">Actions disponibles</div>
            <div class="card-body d-flex justify-content-start flex-wrap gap-2">
                <a href="{{ route('talibes.edit', $talibe->id) }}" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <form action="{{ route('talibes.destroy', $talibe->id) }}" method="POST" style="display:inline-block;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Confirmer la suppression ?')">
                        <i class="fas fa-trash-alt"></i> Supprimer
                    </button>
                </form>
                @if (!$talibe->tuteur)
                    <a href="{{ route('talibes.assignTuteurForm', $talibe) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-user-plus"></i> Attribuer un tuteur
                    </a>
                @endif


            </div>
        </div>


    </div>
@endsection
