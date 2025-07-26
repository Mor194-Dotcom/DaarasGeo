@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Prévisualisation du SMS</h3>
        <div class="card shadow-sm">
            <div class="card-body" style="font-family: Nunito, sans-serif; font-size: 1.1em;">
                <p><strong>Destinataire :</strong> {{ $utilisateur->prenom }} {{ $utilisateur->nom }}
                    ({{ $utilisateur->telephone }})</p>
                <p><strong>Message :</strong></p>
                <div class="border rounded p-3 bg-light">
                    {{ $contenu }}
                </div>
            </div>
        </div>
        <a href="{{ route('admin.utilisateurs.edit', $utilisateur->id) }}" class="btn btn-sm btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Retour à l’utilisateur
        </a>

    </div>
@endsection
