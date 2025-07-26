@extends('layouts.app')

@section('content')
    <h3>Créer une zone pour {{ $daara->nom }}</h3>

    <form method="POST" action="{{ route('zones.store') }}">
        @csrf
        <input type="hidden" name="latitude" value="{{ $daara->latitude }}">
        <input type="hidden" name="longitude" value="{{ $daara->longitude }}">
        <input type="hidden" name="daara_id" value="{{ $daara->id }}">

        <div class="mb-3">
            <label for="rayon" class="form-label">Rayon en mètres</label>
            <input type="number" name="rayon" id="rayon" class="form-control" min="10" required>
        </div>

        <button type="submit" class="btn btn-primary">Créer zone</button>
    </form>
@endsection
