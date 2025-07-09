<nav class="navbar navbar-expand-lg navbar-light bg-white topbar shadow-sm px-4 mb-4">
    <div class="container-fluid">

        <!-- 🔹 Logo & nom -->
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="/">
            <i class="fas fa-map-marked-alt me-2"></i> DaarasGeo
        </a>

        <!-- 🔸 Bouton collapse mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topbarContent"
            aria-controls="topbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- 🔹 Contenu central & droit -->
        <div class="collapse navbar-collapse" id="topbarContent">
            <!-- 🔍 Barre de recherche -->
            <form class="d-flex mx-auto my-2 my-lg-0 w-50" role="search">
                <input class="form-control me-2 bg-light border-0" type="search"
                    placeholder="Rechercher Daara, talibé..." aria-label="Search">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- 👤 Menu utilisateur -->
            @auth
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="me-2 text-gray-600 small">
                                {{ Auth::user()->prenom ?? 'Profil' }}
                                • {{ Auth::user()->role->libelle ?? 'Utilisateur' }}
                            </span>
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->prenom }}&background=0D6EFD&color=fff"
                                class="img-profile rounded-circle" width="32" alt="Avatar">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i
                                        class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Mon profil</a></li>
                            <li><a class="dropdown-item" href="#"><i
                                        class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i> Paramètres</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a href="#"
                                    onclick="event.preventDefault(); if (confirm('Se déconnecter ?')) document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i> Déconnexion
                                </a>


                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        </ul>
                    </li>
                </ul>
            @endauth

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
