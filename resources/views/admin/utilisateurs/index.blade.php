@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h5 text-gray-800">Gestion des utilisateurs</h1>
        <a href="{{ route('admin.utilisateurs.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-user-plus"></i> Ajouter
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <form method="GET" class="form-inline d-flex flex-wrap justify-content-start">
                <input type="text" name="search" class="form-control form-control-sm mr-2 mb-2"
                    placeholder="Nom, prénom ou email" value="{{ request('search') }}">
                <select name="role" class="form-control form-control-sm mr-2 mb-2">
                    <option value="">Tous les rôles</option>
                    @foreach ($roles as $r)
                        @if ($r->libelle !== 'Talibe')
                            {{-- exclusion explicite --}}
                            <option value="{{ $r->id }}" {{ request('role') == $r->id ? 'selected' : '' }}>
                                {{ $r->libelle }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <button type="submit" class="btn btn-sm btn-outline-primary mb-2">
                    <i class="fas fa-filter"></i> Filtrer
                </button>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="thead-light">
                        <tr class="text-muted small text-uppercase">
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Rôle</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($utilisateurs as $u)
                            @if ($u->role->libelle !== 'Talibe')
                                {{-- filtre runtime --}}
                                <tr>
                                    <td>{{ $u->nom }} {{ $u->prenom }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->administrateur->telephone ?? ($u->responsableDaara->telephone ?? ($u->tuteur->telephone ?? '—')) }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $u->isAdmin() ? 'danger' : ($u->isResponsable() ? 'warning' : ($u->isTuteur() ? 'info' : 'secondary')) }}">
                                            {{ $u->role->libelle }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{-- <a href="{{ route('admin.utilisateurs.edit', $u->id) }}"
                                            class="btn btn-sm btn-outline-warning mr-1" title="Modifier">
                                            <i class="fas fa-user-edit"></i>
                                        </a> --}}
                                        <a href="{{ route('admin.utilisateurs.edit', $u->id) }}"
                                            class="btn btn-sm btn-outline-secondary mr-1" title="Voir la fiche">
                                            <i class="fas fa-user"></i>
                                        </a>

                                        {{-- <a href="{{ route('admin.utilisateurs.emailLibrePreview', $u->id) }}"
                                            class="btn btn-sm btn-outline-secondary mr-1" title="EmailP">
                                            <i class="fas fa-envelope"></i>
                                        </a> --}}
                                        <a href="{{ route('admin.utilisateurs.emailLibrePreview', $u->id) }}?contenu={{ urlencode('Bonjour depuis DAARASGEO') }}"
                                            class="btn btn-sm btn-outline-secondary mr-1" title="EmailP">
                                            <i class="fas fa-envelope"></i>
                                        </a>

                                        <form method="POST" action="{{ route('admin.utilisateurs.destroy', $u->id) }}"
                                            class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Aucun utilisateur trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-3 py-2 bg-light border-top">
                {{ $utilisateurs->links() }}
            </div>
        </div>
    </div>
@endsection
