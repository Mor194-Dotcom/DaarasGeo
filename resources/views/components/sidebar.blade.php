<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #2a4d69;">

    {{-- Logo / Identité --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-start px-3 py-4" href="/">
        <img src="{{ asset('assets/img/logo-daara.png') }}" width="32" class="me-2">
        <span class="sidebar-brand-text fs-6 fw-semibold">DaarasGeo</span>
    </a>

    <hr class="sidebar-divider">
    <div class="sidebar-heading text-light px-3">Navigation</div>

    {{-- Dashboard accessible à tous --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i> <span>Dashboard</span>
        </a>
    </li>

    {{-- Daaras : Responsable + Admin --}}
    @if (auth()->user()->isAdmin() || auth()->user()->isResponsable())
        <li class="nav-item">
            <a class="nav-link" href="/daaras">
                <i class="fas fa-school"></i> <span>Daaras</span>
            </a>
        </li>
    @endif

    {{-- Talibés : visible sauf pour Tuteur --}}
    @unless (auth()->user()->isTuteur())
        <li class="nav-item">
            <a class="nav-link" href="/talibes">
                <i class="fas fa-child"></i> <span>Talibés</span>
            </a>
        </li>
    @endunless

    {{-- Carte visible à tous --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('Show.carte') }}">
            <i class="fas fa-map-marked-alt"></i> <span>Carte</span>
        </a>
    </li>

    {{-- Alertes : tous rôles sauf Talibé, si tu préfères --}}
    @unless (auth()->user()->isTuteur())
        <li class="nav-item">
            <a class="nav-link" href="/alertes">
                <i class="fas fa-bell text-warning"></i> <span>Alertes</span>
            </a>
        </li>
    @endunless

    <hr class="sidebar-divider">

    {{-- SECTION Administration - uniquement Admin --}}
    @if (auth()->user()->isAdmin())
        <div class="sidebar-heading text-light px-3">Administration</div>

        <li class="nav-item">
            <a class="nav-link" href="/utilisateurs">
                <i class="fas fa-users-cog"></i> <span>Utilisateurs</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/parametres">
                <i class="fas fa-cogs"></i> <span>Paramètres</span>
            </a>
        </li>
    @endif

    <hr class="sidebar-divider my-3">
    <div class="text-center px-3 small text-white-50">Version 1.0 – {{ now()->year }}</div>

    {{-- Collapse bouton SB Admin --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
