@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>
            Résultats pour : <strong>{{ $q }}</strong>
            @if (request('type') !== 'all')
                <span class="badge bg-info text-dark">{{ ucfirst(request('type')) }}</span>
            @endif
        </h4>

        <hr>

        {{-- Résultats Daaras --}}
        @if (isset($resultats['daaras']) && count($resultats['daaras']) > 0)
            <h5 class="mt-4"><i class="fas fa-university text-primary"></i> Daaras</h5>
            <div class="list-group mb-3">
                @foreach ($resultats['daaras'] as $daara)
                    <a href="{{ route('daaras.show', $daara->id) }}" class="list-group-item list-group-item-action">
                        🔵 <strong>{{ $daara->nom }}</strong> – {{ $daara->localisation }}
                    </a>
                @endforeach
            </div>
        @elseif(request('type') === 'daara')
            <p class="text-muted">Aucun Daara ne correspond à la recherche.</p>
        @endif

        {{-- Résultats Talibés --}}
        @if (isset($resultats['talibes']) && count($resultats['talibes']) > 0)
            <h5 class="mt-4"><i class="fas fa-child text-warning"></i> Talibés</h5>
            <div class="list-group mb-3">
                @foreach ($resultats['talibes'] as $talibe)
                    <a href="{{ route('talibes.show', $talibe->id) }}" class="list-group-item list-group-item-action">
                        🟠 <strong>{{ $talibe->utilisateur->prenom }} {{ $talibe->utilisateur->nom }}</strong> –
                        {{ $talibe->utilisateur->telephone }}
                    </a>
                @endforeach
            </div>
        @elseif(request('type') === 'talibe')
            <p class="text-muted">Aucun Talibé ne correspond à la recherche.</p>
        @endif

        {{-- Aucun résultat pour all --}}
        @if (empty($resultats['daaras']) && empty($resultats['talibes']) && request('type') === 'all')
            <p class="text-muted">Aucun résultat trouvé pour cette recherche.</p>
        @endif
    </div>
@endsection
