{{-- <nav class="navbar navbar-expand-lg navbar-light bg-white topbar shadow-sm px-4 mb-4">
    <div class="container-fluid">

        <!-- 🔹 Logo -->
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="/">
            <i class="fas fa-map-marked-alt me-2"></i> DaarasGeo
        </a>

        <!-- 🔸 Toggle mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topbarContent"
            aria-controls="topbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- 🔍 Contenu -->
        <div class="collapse navbar-collapse" id="topbarContent">

            <!-- 🔍 Barre de recherche -->

            <form method="GET" action="{{ route('recherche') }}" class="d-flex w-100 gap-2 flex-wrap">
                <input type="search" name="q" class="form-control shadow-sm" placeholder="Rechercher..."
                    required>

                <select name="type" class="form-select w-auto text-sm">
                    <option value="all">Tout</option>
                    <option value="daara">Daaras</option>
                    <option value="talibe">Talibés</option>
                </select>

                <button type="submit" class="btn btn-primary shadow-sm">
                    <i class="fas fa-search"></i>
                </button>
            </form>



            <!-- 👤 Utilisateur connecté -->
            @auth
                @php $role = Auth::user()->role->libelle ?? 'Invité'; @endphp
                <ul class="navbar-nav ms-auto align-items-center gap-2">

                    <!-- Avatar & Rôle -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="me-2 text-gray-600 small fw-semibold">
                                {{ Auth::user()->prenom }}
                                <span class="badge bg-info text-white ms-2">{{ $role }}</span>
                            </span>
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->prenom }}&background=0D6EFD&color=fff"
                                class="rounded-circle border border-2 border-primary" width="36" alt="Avatar">
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                            <!-- 🎯 Dashboard par rôle -->
                            @switch($role)
                                @case('Tuteur')
                                    <li><a class="dropdown-item" href="{{ route('tuteur.dashboard') }}">
                                            <i class="fas fa-user-check me-2"></i> Talibés</a></li>
                                @break

                                @case('Responsable')
                                    <li><a class="dropdown-item" href="{{ route('responsableDash') }}">
                                            <i class="fas fa-school me-2"></i> Gestion Daara</a></li>
                                @break

                                @case('Admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tools me-2"></i> Admin</a></li>
                                @break
                            @endswitch

                            <!-- 👤 Mon profil -->
                            <li><a class="dropdown-item" href="{{ route('profil.show') }}">
                                    <i class="fas fa-id-badge me-2"></i> Voir mon profil</a></li>

                            <!-- 🚪 Déconnexion -->
                            <li><a href="#" onclick="handleLogout(event)"
                                    class="dropdown-item d-flex align-items-center text-danger fw-semibold">
                                    <i class="fas fa-sign-out-alt me-2"></i><span>Déconnexion</span></a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endauth

            <!-- 👤 Utilisateur invité -->
            @guest
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Connexion</a>
                    </li>
                </ul>
            @endguest

        </div>
    </div>
</nav>

<!-- 🔔 Script SweetAlert déconnexion -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleLogout(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Déconnexion',
            text: 'Merci pour votre visite. À bientôt sur DaarasGeo !',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false,
            willClose: () => document.getElementById('logout-form').submit()
        });
    }
</script>
 --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white topbar shadow-sm px-4 mb-4">
    <div class="container-fluid">

        <!-- 🔹 Logo -->
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="/">
            <i class="fas fa-map-marked-alt me-2"></i> DaarasGeo
        </a>

        <!-- 🔸 Toggle mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topbarContent"
            aria-controls="topbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- 🔍 Contenu -->
        <div class="collapse navbar-collapse" id="topbarContent">

            <!-- 🔍 Barre de recherche -->
            <!-- 🔍 Barre de recherche dans le topbar -->
            <form method="GET" action="{{ route('recherche') }}"
                class="d-flex flex-wrap align-items-center gap-2 w-100 my-2">

                <!-- 🔎 Champ texte de recherche -->
                <div class="flex-grow-1">
                    <input type="search" name="q" class="form-control shadow-sm border-0 fw-semibold text-sm"
                        placeholder="Rechercher un Daara ou un Talibé..." required>
                </div>

                <!-- 🗂️ Selecteur de type avec icône filtre -->
                <div class="flex-shrink-1 d-flex align-items-center">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0" data-bs-toggle="tooltip"
                            title="Filtrer par type">
                            <i class="fas fa-filter text-primary"></i>
                        </span>

                        <select name="type" id="type"
                            class="form-select shadow-sm border-0 fw-semibold text-sm">
                            <option value="all">Tous</option>
                            <option value="daara">Daaras</option>
                            <option value="talibe">Talibés</option>
                        </select>
                    </div>
                </div>

                <!-- 🔘 Bouton de recherche -->
                <div class="flex-shrink-1">
                    <button type="submit" class="btn btn-primary shadow-sm text-sm">
                        <i class="fas fa-search me-1"></i> Rechercher
                    </button>
                </div>

            </form>



            <!-- 👤 Utilisateur connecté -->
            @auth
                @php $role = Auth::user()->role->libelle ?? 'Invité'; @endphp
                <ul class="navbar-nav ms-auto align-items-center gap-2">

                    <!-- Avatar & Rôle -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="me-2 text-dark small fw-semibold">
                                {{ Auth::user()->prenom }}
                                <span class="badge bg-info text-white ms-2">{{ $role }}</span>
                            </span>
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->prenom }}&background=0D6EFD&color=fff"
                                class="rounded-circle border border-2 border-primary d-none d-md-inline" width="36"
                                alt="Avatar">
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in text-sm"
                            aria-labelledby="userDropdown">
                            <!-- 🎯 Dashboard par rôle -->
                            @switch($role)
                                @case('Tuteur')
                                    <li><a class="dropdown-item" href="{{ route('tuteur.dashboard') }}">
                                            <i class="fas fa-user-check me-2"></i> Talibés</a></li>
                                @break

                                @case('Responsable')
                                    <li><a class="dropdown-item" href="{{ route('responsableDash') }}">
                                            <i class="fas fa-school me-2"></i> Gestion Daara</a></li>
                                @break

                                @case('Admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tools me-2"></i> Admin</a></li>
                                @break
                            @endswitch

                            <!-- 👤 Mon profil -->
                            <li><a class="dropdown-item" href="{{ route('profil.show') }}">
                                    <i class="fas fa-id-badge me-2"></i> Voir mon profil</a></li>

                            <!-- 🚪 Déconnexion -->
                            <li><a href="#" onclick="handleLogout(event)"
                                    class="dropdown-item d-flex align-items-center text-danger fw-semibold">
                                    <i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endauth

            <!-- 👤 Utilisateur invité -->
            @guest
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Connexion</a>
                    </li>
                </ul>
            @endguest

        </div>
    </div>
</nav>

<!-- 🔔 SweetAlert pour déconnexion -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleLogout(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Déconnexion',
            text: 'Merci pour votre visite. À bientôt sur DaarasGeo !',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false,
            willClose: () => document.getElementById('logout-form').submit()
        });
    }
</script>
