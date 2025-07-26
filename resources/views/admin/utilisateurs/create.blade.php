@extends('layouts.app')

@section('title', 'Créer un utilisateur')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0 font-weight-bold">Création d’un nouvel utilisateur</h6>
        </div>

        <div class="card-body">
            {{-- Formulaire principal --}}
            <form method="POST" action="{{ route('admin.utilisateurs.store') }}">
                @csrf

                {{-- Sélection du rôle --}}
                <div class="form-group">
                    <label for="role_selector">Rôle</label>
                    <select name="role_enum_id" id="role_selector" class="form-control" required>
                        <option value="">-- Sélectionner un rôle --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->libelle }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Champs communs, affichés après sélection --}}
                <div id="common_fields" style="display:none;">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nom</label>
                            <input name="nom" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Prénom</label>
                            <input name="prenom" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Adresse</label>
                        <input name="adresse" class="form-control" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input name="email" type="email" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Mot de passe</label>
                            <input name="password" type="password" class="form-control" required>
                            <input name="password_confirmation" type="password" class="form-control mt-1"
                                placeholder="Confirmer mot de passe" required>
                        </div>
                    </div>

                    {{-- Blocs métier selon rôle --}}
                    <div id="tuteur_fields" style="display:none;">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Type de tuteur</label>
                                <select name="type_tuteur" class="form-control">
                                    @foreach (\App\Models\Enums\TypeTuteurEnum::cases() as $type)
                                        <option value="{{ $type->value }}">{{ $type->value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Téléphone tuteur</label>
                                <input name="telephone_tuteur" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div id="responsable_fields" style="display:none;">
                        <label>Téléphone responsable</label>
                        <input name="telephone_responsable" class="form-control">
                    </div>

                    <div id="admin_fields" style="display:none;">
                        <label>Téléphone administrateur</label>
                        <input name="telephone_admin" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Créer</button>
            </form>
        </div>
    </div>

    {{-- Script JS pour afficher dynamiquement les blocs métier --}}
    <script>
        document.getElementById('role_selector').addEventListener('change', function() {
            let roleId = parseInt(this.value);

            // Champs communs affichés si rôle sélectionné
            document.getElementById('common_fields').style.display = roleId ? 'block' : 'none';

            // Bloc tuteur
            document.getElementById('tuteur_fields').style.display = roleId === 1 ? 'block' : 'none';

            // Bloc responsable
            document.getElementById('responsable_fields').style.display = roleId === 2 ? 'block' : 'none';

            // Bloc administrateur
            document.getElementById('admin_fields').style.display = roleId === 4 ? 'block' : 'none';
        });
    </script>
@endsection
