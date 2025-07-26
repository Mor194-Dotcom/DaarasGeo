 {{-- @extends('layouts.app') --}}

 {{-- @section('content')
     <div class="container-fluid px-4">
         <h1 class="mt-4 text-center">🗺️ Carte interactive des Daaras</h1>

         <div class="card mb-4">
             <div class="card-header d-flex align-items-center">
                 <i class="fas fa-layer-group fa-lg me-2 text-primary"></i>
                 <span>Choix du style de carte</span>
             </div>
             <div class="card-body text-center">
                 <select id="carteType" class="form-select w-50 mx-auto">
                     <option value="m">🛣️ Roadmap</option>
                     <option value="s">🛰️ Satellite</option>
                     <option value="p">⛰️ Terrain</option>
                     <option value="h" selected>🧪 Hybrid</option>
                 </select>
             </div>
         </div>

         {{-- 🔍 Barre de recherche
         <div class="input-group w-75 mx-auto mb-3">
             <span class="input-group-text bg-primary text-white">
                 <i class="fas fa-search-location"></i>
             </span>
             <input type="text" id="searchInput" class="form-control"
                 placeholder="Rechercher un village ou une adresse..." autocomplete="off">
         </div>
         <ul id="suggestions" class="list-group w-75 mx-auto mb-4" style="position: absolute; z-index: 1000;"></ul>

         {{-- 🗺️ Carte
         <div class="card">
             <div class="card-body p-0">
                 <div id="map" style="height:600px;"></div>
             </div>
         </div>
     </div>
 @endsection --}}
 {{--
 @push('styles')
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
     <style>
         .marker-pin {
             width: 30px;
             height: 30px;
             border-radius: 50% 50% 50% 0;
             background: #0d6efd;
             position: absolute;
             transform: rotate(-45deg);
             left: 50%;
             top: 50%;
             margin: -15px 0 0 -15px;
         }

         .custom-div-icon i {
             position: absolute;
             font-size: 18px;
             color: white;
             left: 0;
             right: 0;
             margin: 10px auto;
             text-align: center;
         }

         #suggestions li {
             cursor: pointer;
         }
     </style>
 @endpush
 --}}
 {{-- @push('scripts')
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
     <script>
         const daaras = @json($daaras);
     </script>

     <script>
         let map, fondActuel, resultatMarker;

         document.addEventListener("DOMContentLoaded", function() {
             map = L.map('map').setView([14.6928, -17.4467], 13);
             changerFond();

             document.getElementById('carteType').addEventListener('change', changerFond);

             // 🔁 Affichage des Daaras
             daaras.forEach(daara => {
                 const icon = L.divIcon({
                     className: 'custom-div-icon',
                     html: "<div class='marker-pin'></div><i class='fas fa-mosque'></i>",
                     iconSize: [30, 42],
                     iconAnchor: [15, 42]
                 });

                 const marker = L.marker([daara.latitude, daara.longitude], {
                     icon
                 }).addTo(map);
                 marker.bindPopup(`
            <strong>🏫 ${daara.nom}</strong><br>
            📍 ${daara.adresse ?? 'Adresse inconnue'}
        `);

                 if (daara.zone_delimitee) {
                     L.circle([daara.zone_delimitee.latitude, daara.zone_delimitee.longitude], {
                         radius: daara.zone_delimitee.rayon,
                         color: 'green',
                         fillOpacity: 0.3
                     }).addTo(map);
                 }
             });

             // 🔍 Barre de recherche avec suggestions
             const searchInput = document.getElementById('searchInput');
             const suggestionsList = document.getElementById('suggestions');

             searchInput.addEventListener('input', function() {
                 const query = this.value;
                 suggestionsList.innerHTML = '';
                 if (query.length < 3) return;

                 fetch(
                         `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`
                     )
                     .then(res => res.json())
                     .then(results => {
                         results.slice(0, 5).forEach(result => {
                             const li = document.createElement('li');
                             li.classList.add('list-group-item');
                             li.textContent = result.display_name;
                             li.addEventListener('click', () => {
                                 map.setView([result.lat, result.lon], 15);
                                 if (resultatMarker) map.removeLayer(resultatMarker);
                                 resultatMarker = L.marker([result.lat, result.lon], {
                                         icon: L.divIcon({
                                             className: 'custom-div-icon',
                                             html: "<div class='marker-pin'></div><i class='fas fa-map-marker-alt'></i>",
                                             iconSize: [30, 42],
                                             iconAnchor: [15, 42]
                                         })
                                     }).addTo(map).bindPopup(`📍 ${result.display_name}`)
                                     .openPopup();

                                 suggestionsList.innerHTML = '';
                                 searchInput.value = result.display_name;
                             });
                             suggestionsList.appendChild(li);
                         });
                     });
             });
         });

         // 🗺️ Changement de fond Google avec fallback vers OSM
         function changerFond() {
             const type = document.getElementById('carteType').value;
             const lyrs = type === 'h' ? 's,h' : type;
             const url = `https://mt1.google.com/vt/lyrs=${lyrs}&x={x}&y={y}&z={z}`;

             if (fondActuel) map.removeLayer(fondActuel);

             fondActuel = L.tileLayer(url, {
                 maxZoom: 20
             });

             fondActuel.on('tileerror', function() {
                 console.warn("Tuile Google indisponible — remplacement par OSM");
                 map.removeLayer(fondActuel);
                 fondActuel = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                     attribution: '© OpenStreetMap contributors'
                 }).addTo(map);
             });

             fondActuel.addTo(map);
         }
     </script>
 @endpush
 --}}
 {{-- pour daara seulement --}}
 {{-- @extends('layouts.app')

 @section('content')
     <div class="container-fluid px-4">
         {{-- <h2 class="mt-4 text-center">
             🗺️ Carte des Daaras {{ $user->isResponsable() ? 'associés' : 'du système' }}
         </h2>
         <h2 class="mt-4 text-center d-flex justify-content-center align-items-center gap-2">
             <img src="{{ asset('icons/ct1.png') }}" alt="Carte" height="28">
             Carte des Daaras {{ $user->isResponsable() ? 'associés' : 'du système' }}
         </h2>


         <p class="text-muted text-center mb-4">
             {{ $user->isResponsable() ? "Responsable : $user->prenom $user->nom" : 'Administrateur' }}
         </p>

         <!-- Sélecteur de style -->
         <div class="card mb-4">
             <div class="card-header d-flex align-items-center">
                 <i class="fas fa-layer-group fa-lg me-2 text-primary"></i>
                 <span>Choix du style de carte</span>
             </div>
             <div class="card-body text-center">
                 <select id="carteType" class="form-select w-50 mx-auto">
                     <option value="m">🛣️ Roadmap</option>
                     <option value="s">🛰️ Satellite</option>
                     <option value="p">⛰️ Terrain</option>
                     <option value="h" selected>🧪 Hybrid</option>
                 </select>
             </div>
         </div>

         <!-- Barre de recherche -->
         <div class="input-group w-75 mx-auto mb-3">
             <span class="input-group-text bg-primary text-white">
                 <i class="fas fa-search-location"></i>
             </span>
             <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un lieu..."
                 autocomplete="off">
         </div>
         <ul id="suggestions" class="list-group w-75 mx-auto mb-4" style="position: absolute; z-index: 1000;"></ul>

         <!-- Carte -->
         <div class="card shadow-sm">
             <div class="card-body p-0">
                 <div id="map" style="height: 600px;"></div>
             </div>
         </div>
     </div>
 @endsection

 @push('styles')
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
     <style>
         /* .container-fluid {
                     background-image: url('/assets/img/bg2.png');
                     /* Ton image */
         background-size: cover;
         background-position: center;
         background-repeat: no-repeat;
         background-attachment: fixed;
         /* pour effet fixe en scroll
                 } */

         .custom-div-icon i {
             position: absolute;
             font-size: 18px;
             color: white;
             left: 0;
             right: 0;
             margin: 10px auto;
             text-align: center;
         }

         .marker-pin {
             width: 30px;
             height: 30px;
             border-radius: 50% 50% 50% 0;
             background: #0d6efd;
             position: absolute;
             transform: rotate(-45deg);
             left: 50%;
             top: 50%;
             margin: -15px 0 0 -15px;
         }

         .img-marker-icon {
             width: 32px;
             height: 32px;
             object-fit: contain;
         }

         #suggestions li {
             cursor: pointer;
         }
     </style>
 @endpush

 @push('scripts')
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
     <script>
         const daaras = @json($daaras);
         let map, fondActuel, resultatMarker;

         document.addEventListener("DOMContentLoaded", () => {
             map = L.map('map').setView([14.6928, -17.4467], 13);
             changerFond();

             document.getElementById('carteType').addEventListener('change', changerFond);

             // 📍 Affichage des Daaras
             daaras.forEach(daara => {
                 if (!daara.latitude || !daara.longitude) return;

                 // 🔁 Icône personnalisable avec image
                 const icon = L.icon({
                     iconUrl: '/icons/ic3.png', // ➜ change le fichier ici
                     iconSize: [32, 32],
                     iconAnchor: [16, 32],
                     popupAnchor: [0, -32],
                     className: 'img-marker-icon'
                 });

                 const marker = L.marker([daara.latitude, daara.longitude], {
                     icon
                 }).addTo(map);
                 marker.bindPopup(`
                <strong>🏫 ${daara.nom}</strong><br>
                📍 ${daara.adresse ?? 'Adresse inconnue'}<br>
                🛡️ Zone : ${daara.zone_delimitee?.nom ?? 'Non définie'}<br>
                Rayon : ${daara.zone_delimitee?.rayon ?? '-'} m
            `);

                 // 🛡️ Zone de sécurité
                 if (daara.zone_delimitee) {
                     L.circle([daara.zone_delimitee.latitude, daara.zone_delimitee.longitude], {
                         radius: daara.zone_delimitee.rayon,
                         color: 'green',
                         fillOpacity: 0.2
                     }).addTo(map);
                 }
             });

             // 🔍 Barre de recherche
             const searchInput = document.getElementById('searchInput');
             const suggestionsList = document.getElementById('suggestions');

             searchInput.addEventListener('input', function() {
                 const query = this.value;
                 suggestionsList.innerHTML = '';
                 if (query.length < 3) return;

                 fetch(
                         `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`
                     )
                     .then(res => res.json())
                     .then(results => {
                         results.slice(0, 5).forEach(result => {
                             const li = document.createElement('li');
                             li.classList.add('list-group-item');
                             li.textContent = result.display_name;
                             li.addEventListener('click', () => {
                                 const lat = parseFloat(result.lat);
                                 const lon = parseFloat(result.lon);
                                 map.setView([lat, lon], 15);
                                 if (resultatMarker) map.removeLayer(resultatMarker);

                                 resultatMarker = L.marker([lat, lon]).addTo(map)
                                     .bindPopup(`📍 ${result.display_name}`)
                                     .openPopup();

                                 suggestionsList.innerHTML = '';
                                 searchInput.value = result.display_name;
                             });
                             suggestionsList.appendChild(li);
                         });
                     });
             });
         });

         // 🗺️ Changement de fond cartographique avec fallback OSM
         function changerFond() {
             const type = document.getElementById('carteType').value;
             const lyrs = type === 'h' ? 's,h' : type;
             const url = `https://mt1.google.com/vt/lyrs=${lyrs}&x={x}&y={y}&z={z}`;

             if (fondActuel) map.removeLayer(fondActuel);

             fondActuel = L.tileLayer(url, {
                 maxZoom: 20
             });
             fondActuel.on('tileerror', () => {
                 console.warn("Tuile Google indisponible ➝ fallback OSM");
                 map.removeLayer(fondActuel);
                 fondActuel = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                     attribution: '© OpenStreetMap contributors'
                 }).addTo(map);
             });

             fondActuel.addTo(map);
         }
     </script>
 @endpush
 --}}
 {{-- ajout avec talibe --}}

 @extends('layouts.app')

 @section('content')
     <div class="container-fluid px-4">
         <h2 class="mt-4 text-center d-flex justify-content-center align-items-center gap-2">
             <img src="{{ asset('icons/ct1.png') }}" alt="Carte" height="28">
             Carte des Daaras {{ $user->isResponsable() ? 'associés' : 'du système' }}
         </h2>

         <p class="text-muted text-center mb-4">
             {{ $user->isResponsable() ? "Responsable : $user->prenom $user->nom" : 'Administrateur' }}
         </p>
         <div class="text-center mb-4">
             <button id="startBtn" class="btn btn-success btn-lg me-2">
                 <i class="fas fa-play-circle"></i> 🟢 Démarrer Simulation
             </button>
             <button id="stopBtn" class="btn btn-danger btn-lg">
                 <i class="fas fa-stop-circle"></i> ⏹️ Arrêter Simulation
             </button>
         </div>

         <!-- Choix style carte -->
         <div class="card mb-4">
             <div class="card-header d-flex align-items-center">
                 <i class="fas fa-layer-group fa-lg me-2 text-primary"></i>
                 <span>Choix du style de carte</span>
             </div>
             <div class="card-body text-center">
                 <select id="carteType" class="form-select w-50 mx-auto">
                     <option value="m">🛣️ Roadmap</option>
                     <option value="s">🛰️ Satellite</option>
                     <option value="p">⛰️ Terrain</option>
                     <option value="h" selected>🧪 Hybrid</option>
                 </select>
             </div>
         </div>

         <!-- Barre de recherche -->
         <div class="input-group w-75 mx-auto mb-3">
             <span class="input-group-text bg-primary text-white">
                 <i class="fas fa-search-location"></i>
             </span>
             <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un lieu..."
                 autocomplete="off">
         </div>
         <ul id="suggestions" class="list-group w-75 mx-auto mb-4" style="position: absolute; z-index: 1000;"></ul>

         <!-- Carte -->
         <div class="card shadow-sm">
             <div class="card-body p-0">
                 <div id="map" style="height: 600px;"></div>
             </div>
         </div>
     </div>
 @endsection

 @push('styles')
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
     <style>
         .img-marker-icon {
             width: 32px;
             height: 32px;
             object-fit: contain;
         }

         #suggestions li {
             cursor: pointer;
         }

         @keyframes blink {
             0% {
                 opacity: 1;
             }

             50% {
                 opacity: 0.4;
             }

             100% {
                 opacity: 1;
             }
         }

         .blinking {
             animation: blink 1s ease-in-out 3;
         }

         @keyframes pulse {
             0% {
                 transform: scale(1);
                 opacity: 0.6;
             }

             50% {
                 transform: scale(1.5);
                 opacity: 0.2;
             }

             100% {
                 transform: scale(1);
                 opacity: 0.6;
             }
         }

         .pulsing-circle {
             animation: pulse 2s infinite;
         }
     </style>
 @endpush


 @push('scripts')
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
     <script>
         const daaras = @json($daaras);
         const talibes = @json($talibes);
         const focusDaara = @json($focusDaara);
         let map, fondActuel, resultatMarker;
         const talibeMarkersLive = {};

         document.addEventListener("DOMContentLoaded", () => {
             let simulationInterval = null;

             // 🎮 Boutons de simulation
             document.getElementById('startBtn').addEventListener('click', () => {
                 if (simulationInterval) return;
                 simulationInterval = setInterval(() => {
                     fetch('/api/simulation/run')
                         .then(res => res.json())
                         .then(msg => console.log("🚀 Talibés déplacés"));
                 }, 3000);
             });

             document.getElementById('stopBtn').addEventListener('click', () => {
                 clearInterval(simulationInterval);
                 simulationInterval = null;
                 console.log("⏹️ Simulation stoppée");
             });

             // 🗺️ Initialisation de la carte
             map = L.map('map').setView([14.6928, -17.4467], 13);
             changerFond();
             document.getElementById('carteType').addEventListener('change', changerFond);

             // 📍 Markers des Daaras
             daaras.forEach(daara => {
                 if (!daara.latitude || !daara.longitude) return;

                 const icon = L.icon({
                     iconUrl: '/icons/ic3.png',
                     iconSize: [70, 70],
                     iconAnchor: [16, 32],
                     popupAnchor: [0, -32],
                     className: 'img-marker-icon'
                 });

                 const marker = L.marker([daara.latitude, daara.longitude], {
                     icon
                 }).addTo(map);

                 marker.bindPopup(`
                    <strong>🏫 ${daara.nom}</strong><br>
                    📍 ${daara.adresse ?? 'Adresse inconnue'}<br>
                    🛡️ Position : ${daara.latitude ?? 'long'} ${daara.longitude ??'lat'}<br>
                    Rayon : ${daara.zone_delimitee?.rayon / 1000 ?? '-'} Km
                `);

                 if (daara.zone_delimitee) {
                     L.circle([daara.zone_delimitee.latitude, daara.zone_delimitee.longitude], {
                         radius: daara.zone_delimitee.rayon,
                         color: 'green',
                         fillOpacity: 0.2
                     }).addTo(map);
                 }

                 // 🎯 Centrage sur le Daara ciblé
                 if (focusDaara && daara.id === focusDaara.id) {
                     map.setView([daara.latitude, daara.longitude], 16);
                     marker.openPopup();
                 }
             });

             // 👶 Markers des Talibés
             talibes.forEach(t => {
                 if (!t.latitude || !t.longitude) return;

                 const iconUrl = t.est_hors_zone ?
                     '/icons/talibe-red.png' :
                     '/icons/talibe-green.png';

                 const icon = L.icon({
                     iconUrl,
                     iconSize: [40, 40],
                     iconAnchor: [13, 26],
                     popupAnchor: [0, -26],
                     className: 'img-marker-icon'
                 });

                 const marker = L.marker([t.latitude, t.longitude], {
                     icon
                 }).addTo(map);
                 talibeMarkersLive[`talibe-${t.id}`] = marker;

                 const zoneNom = t.zone?.nom ?? t.daara?.zone_delimitee?.nom ?? 'Zone inconnue';
                 const rayon = t.zone?.rayon ?? t.daara?.zone_delimitee?.rayon / 1000 ?? '–';

                 marker.bindPopup(`
                    <strong>${t.utilisateur?.prenom ?? 'Talibé'} ${t.utilisateur?.nom ?? ''}</strong><br>
                     Daara : ${t.daara?.nom ?? 'Aucun'}<br>
                     Zone : ${zoneNom}<br>
                     Rayon autorisé : ${rayon} Km<br>
                     Position : ${t.latitude.toFixed(4)}, ${t.longitude.toFixed(4)}<br>
                <button onclick="toggleTalibe(${t.id})" class="btn btn-sm btn-warning mt-2">
                   🔁 Simuler mouvement
                </button>
                   `);
                 if (t.est_hors_zone) {
                     L.circle([t.latitude, t.longitude], {
                         radius: 30, // tu peux ajuster
                         color: 'red',
                         fillOpacity: 0.4,
                         className: 'pulsing-circle'
                     }).addTo(map);
                 }
             });

             /*   talibes.forEach(t => {
                                                                                                           if (!t.latitude || !t.longitude) return;

                                                                                                           const icon = L.icon({
                                                                                                               iconUrl: '/icons/tal6.png',
                                                                                                               iconSize: [40, 40],
                                                                                                               iconAnchor: [13, 26],
                                                                                                               popupAnchor: [0, -26],
                                                                                                               className: 'img-marker-icon'
                                                                                                           });

                                                                                                           const marker = L.marker([t.latitude, t.longitude], {
                                                                                                               icon
                                                                                                           }).addTo(map);
                                                                                                           talibeMarkersLive[`talibe-${t.id}`] = marker;

                                                                                                           const zoneNom = t.zone?.nom ?? t.daara?.zone_delimitee?.nom ?? 'Zone inconnue';
                                                                                                           const rayon = t.zone?.rayon ?? t.daara?.zone_delimitee?.rayon / 1000 ?? '–';



                                                                                                           marker.bindPopup(`
                <strong>${t.utilisateur?.prenom ?? 'Talibé'} ${t.utilisateur?.nom ?? ''}</strong><br>
                Daara : ${t.daara?.nom ?? 'Aucun'}<br>
                Zone : ${zoneNom}<br>
                Rayon autorisé : ${rayon} Km<br>
                Position : ${t.latitude.toFixed(4)}, ${t.longitude.toFixed(4)}
            `);
                                                                                           */

             /*  if (t.zone) {
                  L.circle([t.zone.latitude, t.zone.longitude], {
                      radius: t.zone.rayon,
                      color: 'green',
                      fillOpacity: 0.15
                  }).addTo(map);
              } */


         });

         // 🔍 Recherche géographique
         const searchInput = document.getElementById('searchInput');
         const suggestionsList = document.getElementById('suggestions');

         searchInput.addEventListener('input', function() {
             const query = this.value;
             suggestionsList.innerHTML = '';
             if (query.length < 3) return;

             fetch(
                     `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`
                 )
                 .then(res => res.json())
                 .then(results => {
                     results.slice(0, 5).forEach(result => {
                         const li = document.createElement('li');
                         li.classList.add('list-group-item');
                         li.textContent = result.display_name;
                         li.addEventListener('click', () => {
                             const lat = parseFloat(result.lat);
                             const lon = parseFloat(result.lon);
                             map.setView([lat, lon], 15);
                             if (resultatMarker) map.removeLayer(resultatMarker);

                             resultatMarker = L.marker([lat, lon]).addTo(map)
                                 .bindPopup(`📍 ${result.display_name}`)
                                 .openPopup();

                             suggestionsList.innerHTML = '';
                             searchInput.value = result.display_name;
                         });
                         suggestionsList.appendChild(li);
                     });
                 });
             //});

             actualiserTalibesSimules(); // ⚡ Exécution initiale
         });

         // 🗺️ Changement de fond de carte
         function changerFond() {
             const type = document.getElementById('carteType').value;
             const lyrs = type === 'h' ? 's,h' : type;
             const url = `https://mt1.google.com/vt/lyrs=${lyrs}&x={x}&y={y}&z={z}`;

             if (fondActuel) map.removeLayer(fondActuel);

             fondActuel = L.tileLayer(url, {
                 maxZoom: 20
             });

             fondActuel.on('tileerror', () => {
                 console.warn("Tuile Google indisponible ➝ fallback OSM");
                 map.removeLayer(fondActuel);
                 fondActuel = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                     attribution: '© OpenStreetMap contributors'
                 }).addTo(map);
             });

             fondActuel.addTo(map);
         }

         // 🔄 Mise à jour des Talibés simulés
         function actualiserTalibesSimules() {
             fetch('/api/talibes/live')
                 .then(res => res.json())
                 .then(talibes => {
                     talibes.forEach(t => {
                         const key = `talibe-${t.id}`;
                         const newPosition = [t.latitude, t.longitude];

                         const marker = talibeMarkersLive[key];
                         if (marker) {
                             const currentPos = marker.getLatLng();
                             const hasMoved =
                                 currentPos.lat.toFixed(5) !== t.latitude.toFixed(5) ||
                                 currentPos.lng.toFixed(5) !== t.longitude.toFixed(5);

                             if (hasMoved) {
                                 marker.setLatLng(newPosition);

                                 // 🌟 Clignotement temporaire
                                 const iconElement = marker._icon;
                                 if (iconElement) {
                                     iconElement.classList.add('blinking');
                                     setTimeout(() => {
                                         iconElement.classList.remove('blinking');
                                     }, 3000);
                                 }
                             }
                         }
                     });
                 });
         }
         //fonction toggle talibe
         function toggleTalibe(id) {
             fetch(`/talibes/${id}/toggle-position`, {
                 method: 'POST',
                 headers: {
                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
                     'Content-Type': 'application/json'
                 }
             }).then(() => {
                 actualiserTalibesSimules(); // mise à jour immédiate
             });
         }


         setInterval(actualiserTalibesSimules, 1000); // 🔄 toutes les secondes
     </script>
 @endpush
 {{-- @push('scripts')
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
     <script>
         const daaras = @json($daaras);
         const talibes = @json($talibes);
         const focusDaara = @json($focusDaara);
         let map, fondActuel, resultatMarker;
         const talibeMarkersLive = {};


         document.addEventListener("DOMContentLoaded", () => {
                 let simulationInterval = null;

                 document.getElementById('startBtn').addEventListener('click', () => {
                     if (simulationInterval) return;
                     simulationInterval = setInterval(() => {
                         fetch('/api/simulation/run')
                             .then(res => res.json())
                             .then(msg => console.log("🚀 Talibés déplacés"));
                     }, 3000);
                 });

                 document.getElementById('stopBtn').addEventListener('click', () => {
                     clearInterval(simulationInterval);
                     simulationInterval = null;
                     console.log("⏹️ Simulation stoppée");
                 });

                 map = L.map('map').setView([14.6928, -17.4467], 13);
                 changerFond();

                 document.getElementById('carteType').addEventListener('change', changerFond);

                 // 📍 Markers des Daaras
                 daaras.forEach(daara => {
                     if (!daara.latitude || !daara.longitude) return;

                     const icon = L.icon({
                         iconUrl: '/icons/ic3.png',
                         iconSize: [70, 70],
                         iconAnchor: [16, 32],
                         popupAnchor: [0, -32],
                         className: 'img-marker-icon'
                     });

                     const marker = L.marker([daara.latitude, daara.longitude], {
                         icon
                     }).addTo(map);
                     marker.bindPopup(`
                <strong>🏫 ${daara.nom}</strong><br>
                📍 ${daara.adresse ?? 'Adresse inconnue'}<br>
                🛡️ Zone : ${daara.zone_delimitee?.nom ?? 'Non définie'}<br>
                Rayon : ${daara.zone_delimitee?.rayon/1000 ?? '-'} Km
            `);

                     if (daara.zone_delimitee) {
                         L.circle([daara.zone_delimitee.latitude, daara.zone_delimitee.longitude], {
                             radius: daara.zone_delimitee.rayon,
                             color: 'green',
                             fillOpacity: 0.2
                         }).addTo(map);
                     }
                 });
                 // 🎯 Centrage si Daara ciblé
                 if (focusDaara && daara.id === focusDaara.id) {
                     map.setView([daara.latitude, daara.longitude], 16);
                     marker.openPopup();
                 });

             // 👶 Markers des Talibés
             talibes.forEach(t => {
                     if (!t.latitude || !t.longitude) return;

                     const icon = L.icon({
                         iconUrl: '/icons/tal6.png',
                         iconSize: [40, 40],
                         iconAnchor: [13, 26],
                         popupAnchor: [0, -26],
                         className: 'img-marker-icon'
                     });

                     const marker = L.marker([t.latitude, t.longitude], {
                         icon
                     }).addTo(map);
                     talibeMarkersLive[`talibe-${t.id}`] = marker;

                     const zoneNom = t.zone?.nom ?? t.daara?.zone_delimitee?.nom ?? 'Zone inconnue';
                     const rayon = t.zone?.rayon ?? t.daara?.zone_delimitee?.rayon / 1000 ?? '–';

                     marker.bindPopup(`
                <strong>${t.utilisateur?.prenom ?? 'Talibé'} ${t.utilisateur?.nom ?? ''}</strong><br>
                Daara : ${t.daara?.nom ?? 'Aucun'}<br>
                 Zone : ${zoneNom}<br>
                Rayon autorise : ${rayon} Km<br>
                Position : ${t.latitude.toFixed(4)}, ${t.longitude.toFixed(4)}
            `);

                     if (t.zone) {
                         L.circle([t.zone.latitude, t.zone.longitude], {
                             radius: t.zone.rayon,
                             color: 'green', // 🔴 adapte si hors zone
                             fillOpacity: 0.15
                         }).addTo(map);
                     }
                 }

                 // 🔍 Recherche géographique
                 const searchInput = document.getElementById('searchInput');
                 const suggestionsList = document.getElementById('suggestions');

                 searchInput.addEventListener('input', function() {
                     const query = this.value;
                     suggestionsList.innerHTML = '';
                     if (query.length < 3) return;

                     fetch(
                             `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`
                         )
                         .then(res => res.json())
                         .then(results => {
                             results.slice(0, 5).forEach(result => {
                                 const li = document.createElement('li');
                                 li.classList.add('list-group-item');
                                 li.textContent = result.display_name;
                                 li.addEventListener('click', () => {
                                     const lat = parseFloat(result.lat);
                                     const lon = parseFloat(result.lon);
                                     map.setView([lat, lon], 15);
                                     if (resultatMarker) map.removeLayer(
                                         resultatMarker);

                                     resultatMarker = L.marker([lat, lon]).addTo(
                                             map)
                                         .bindPopup(`📍 ${result.display_name}`)
                                         .openPopup();

                                     suggestionsList.innerHTML = '';
                                     searchInput.value = result.display_name;
                                 });
                                 suggestionsList.appendChild(li);
                             });
                         });
                 }); actualiserTalibesSimules(); // ⚡ exécution initiale

             });

         // 🗺️ Changement de fond de carte
         function changerFond() {
             const type = document.getElementById('carteType').value;
             const lyrs = type === 'h' ? 's,h' : type;
             const url = `https://mt1.google.com/vt/lyrs=${lyrs}&x={x}&y={y}&z={z}`;

             if (fondActuel) map.removeLayer(fondActuel);

             fondActuel = L.tileLayer(url, {
                 maxZoom: 20
             });

             fondActuel.on('tileerror', () => {
                 console.warn("Tuile Google indisponible ➝ fallback OSM");
                 map.removeLayer(fondActuel);
                 fondActuel = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                     attribution: '© OpenStreetMap contributors'
                 }).addTo(map);
             });

             fondActuel.addTo(map);


         }

         function actualiserTalibesSimules() {
             fetch('/api/talibes/live')
                 .then(res => res.json())
                 .then(talibes => {
                     talibes.forEach(t => {
                         const key = `talibe-${t.id}`;
                         const newPosition = [t.latitude, t.longitude];

                         const marker = talibeMarkersLive[key];
                         if (marker) {
                             const currentPos = marker.getLatLng();
                             const hasMoved =
                                 currentPos.lat.toFixed(5) !== t.latitude.toFixed(5) ||
                                 currentPos.lng.toFixed(5) !== t.longitude.toFixed(5);

                             if (hasMoved) {
                                 marker.setLatLng(newPosition);

                                 // 🌟 Clignotement temporaire
                                 const iconElement = marker._icon;
                                 if (iconElement) {
                                     iconElement.classList.add('blinking');
                                     setTimeout(() => {
                                         iconElement.classList.remove('blinking');
                                     }, 3000); // dure 3s
                                 }
                             }
                         }
                     });
                 });
         }

         setInterval(actualiserTalibesSimules, 1000); // 🔄 toutes les  secondes
     </script>
 @endpush
 --}}
