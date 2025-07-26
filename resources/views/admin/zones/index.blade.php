@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Daaras sans zone de sécurité</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($daarasSansZone->isEmpty())
        <div class="alert alert-success">✅ Tous les Daaras ont une zone.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Coordonnées</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daarasSansZone as $daara)
                    <tr>
                        <td>{{ $daara->nom }}</td>
                        <td>
                            Lat: {{ $daara->latitude }}<br>
                            Long: {{ $daara->longitude }}
                        </td>
                        <td>
                            <a href="{{ route('zones.create', ['daara' => $daara->id]) }}"
                                class="btn btn-outline-danger btn-sm">
                                ➕ Ajouter manuellement
                            </a>

                            <form action="{{ route('zones.storeAuto') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="daara_id" value="{{ $daara->id }}">
                                <button type="submit" class="btn btn-success btn-sm">Auto (150m)</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
