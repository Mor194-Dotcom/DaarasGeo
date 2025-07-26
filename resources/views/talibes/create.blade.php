{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Ajouter un Talibé à {{ $daara->nom }}</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Une erreur est survenue :</strong>
                <ul>
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form method="POST" action="{{ route('daaras.talibes.store', $daara->id) }}" enctype="multipart/form-data">
            @csrf

            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="text" name="adresse" placeholder="Adresse">
            <input type="date" name="date_naissance">
            <input type="file" name="photo">

            <!-- Tuteur -->
            <select name="tuteur_id">
                <option value="">Aucun tuteur</option>
                @foreach ($tuteurs as $t)
                    <option value="{{ $t->id }}">{{ $t->utilisateur->nom }}</option>
                @endforeach
            </select>

            {{--   <input type="hidden" name="latitude" id="latitude" required>
            <input type="hidden" name="longitude" id="longitude" required>
            <div id="map" style="height:300px; margin-bottom:20px;"></div>
     <button type="submit">Enregistrer</button>
        </form>
    </div>
    <div><a href="{{ route('daaras.show', ['daara' => $daara]) }}"><-retour a la demeure</a></div>
@endsection

@section('scripts')
    <script>
        const map = L.map('map').setView([14.6920, -17.4460], 15);
        L.tileLayer('http://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            errorTileUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
        }).addTo(map);

        let marker;
        map.on('click', e => {
            if (marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
    </script>
@endsection
 --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h2 class="mt-4 text-center d-flex align-items-center justify-content-center gap-2">
            <i class="fas fa-user-plus text-success"></i>
            Ajouter un Talibé à <span class="text-primary">{{ $daara->nom }}</span>
        </h2>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <h5><i class="fas fa-exclamation-triangle me-2"></i> Erreurs détectées</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('daaras.talibes.store', $daara->id) }}" enctype="multipart/form-data"
            class="card shadow-sm mt-4 p-4">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" id="nom" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" name="adresse" id="adresse" class="form-control">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date_naissance" class="form-label">Date de naissance</label>
                    <input type="date" name="date_naissance" id="date_naissance" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                    <div class="mt-2" id="previewContainer" style="display: none;">
                        <img id="photoPreview" src="#" alt="Prévisualisation" class="img-thumbnail"
                            style="max-height: 150px;">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="tuteur_id" class="form-label">Tuteur</label>
                <select name="tuteur_id" id="tuteur_id" class="form-select">
                    <option value="">Aucun tuteur</option>
                    @foreach ($tuteurs as $t)
                        <option value="{{ $t->id }}">{{ $t->utilisateur->prenom }} {{ $t->utilisateur->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="alert alert-info mt-3">
                <i class="fas fa-map-marker-alt me-2"></i>
                La position du Talibé sera automatiquement définie autour du Daara.
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-save me-2"></i> Enregistrer
                </button>
                <a href="{{ route('daaras.show', ['daara' => $daara]) }}" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const preview = document.getElementById('photoPreview');
                preview.src = URL.createObjectURL(file);
                document.getElementById('previewContainer').style.display = 'block';
            }
        });
    </script>
@endpush
