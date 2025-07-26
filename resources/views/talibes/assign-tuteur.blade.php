@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4 text-gray-800">
            <i class="fas fa-user-plus text-primary mr-2"></i> Attribuer un tuteur au Talibé
        </h4>

        <form method="POST" action="{{ route('talibes.assignTuteur', $talibe) }}">
            @csrf

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">Informations du tuteur</div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <input type="text" name="prenom" class="form-control mb-2" placeholder="Prénom" required>
                        <input type="text" name="nom" class="form-control mb-2" placeholder="Nom" required>
                        <input type="text" name="adresse" class="form-control mb-2" placeholder="Adresse">
                        <input type="text" name="telephone" class="form-control mb-2" placeholder="Téléphone" required>
                    </div>
                    <div class="col-md-6">
                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                        <input type="password" name="mot_de_passe" class="form-control mb-2" placeholder="Mot de passe"
                            required>
                        <select name="type_tuteur" class="form-control" required>
                            <option value="">Sélectionner un type</option>
                            @foreach (\App\Models\Enums\TypeTuteurEnum::cases() as $type)
                                <option value="{{ $type->value }}"
                                    {{ old('type_tuteur') === $type->value ? 'selected' : '' }}>
                                    {{ $type->value }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fas fa-save"></i> Valider et attribuer
                    </button>
                    <a href="{{ route('talibes.show', $talibe) }}" class="btn btn-sm btn-secondary ml-2">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
