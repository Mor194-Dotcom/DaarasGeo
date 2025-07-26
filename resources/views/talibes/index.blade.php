@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- En-tête -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-users text-primary mr-2"></i> Liste des Talibés
            </h1>
        </div>

        <!-- Message de confirmation -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <!-- Tableau -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-info text-white">
                <h6 class="m-0 font-weight-bold">Talibés enregistrés</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Nom</th>
                                <th>Daara</th>
                                <th>Tuteur</th>
                                <th>Position</th>
                                <th style="width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($talibes as $t)
                                <tr>
                                    <td>{{ $t->utilisateur->prenom }} {{ $t->utilisateur->nom }}</td>
                                    <td>{{ $t->daara->nom ?? '-' }}</td>
                                    <td>{{ $t->tuteur->utilisateur->nom ?? '-' }}</td>
                                    <td>{{ $t->latitude }}, {{ $t->longitude }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="{{ route('talibes.parcours', $t->id) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </a>
                                            <a href="{{ route('talibes.show', $t->id) }}"
                                                class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <a href="{{ route('talibes.edit', $t->id) }}"
                                                class="btn btn-outline-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('talibes.destroy', $t->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Confirmer la suppression ?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $talibes->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
