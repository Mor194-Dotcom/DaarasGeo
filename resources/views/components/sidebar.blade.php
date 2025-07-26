@php $user = auth()->user(); @endphp

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #2a4d69;">

    {{-- Logo / Identité --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-start px-3 py-4" href="/">
        <img src="{{ asset('assets/img/logo6.png') }}" width="32" class="me-2">
        <span class="sidebar-brand-text fs-6 fw-semibold">DaarasGeo</span>
    </a>

    <hr class="sidebar-divider">
    <div class="sidebar-heading text-light px-3">Navigation</div>

    {{-- Dashboard accessible par role  --}}
    @php
        $user = auth()->user();
    @endphp

    @if ($user)
        @if ($user->isAdmin())
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        @elseif ($user->isResponsable())
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('responsableDash') ? 'active' : '' }}"
                    href="{{ route('responsableDash') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        @elseif ($user->isTuteur())
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tuteur.dashboard') ? 'active' : '' }}"
                    href="{{ route('tuteur.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        @endif
    @endif


    {{-- Daaras : Responsable + Admin --}}
    @if ($user && ($user->isAdmin() || $user->isResponsable()))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('daaras.*') ? 'active' : '' }}" href="{{ route('daaras.index') }}">
                <i class="fas fa-school"></i>
                <span>Daaras</span>
            </a>
        </li>
    @endif

    {{-- Talibés : tous sauf Tuteur --}}
    @if ($user && !$user->isTuteur())
        <li class="nav-item">
            <a class="nav-link {{ request()->is('talibes*') ? 'active' : '' }}" href="{{ route('talibes.index') }}">
                <i class="fas fa-child"></i>
                <span>Talibés</span>
            </a>
        </li>
    @endif

    {{-- Carte visible à tous --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('Show.carte') ? 'active' : '' }}" href="{{ route('Show.carte') }}">
            <i class="fas fa-map-marked-alt"></i>
            <span>Carte</span>
        </a>
    </li>

    {{-- Alertes : tous sauf Tuteur --}}
    {{--  @if ($user && !$user->isTuteur())
        <li class="nav-item">
            <a class="nav-link {{ request()->is('alertes*') ? 'active' : '' }}" href="{{ url('/alertes') }}">
                <i class="fas fa-bell text-warning"></i>
                <span>Alertes</span>
            </a>
        </li>
    @endif
 --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('notifications.index') }}">
            🔔 Notifications
            @php
                $nonLues = \App\Models\Notification::where('utilisateur_id', auth()->id())
                    ->where('vue', false)
                    ->count();
            @endphp
            @if ($nonLues > 0)
                <span class="badge bg-danger">{{ $nonLues }}</span>
            @endif
        </a>
    </li>

    <hr class="sidebar-divider">

    {{-- Administration : uniquement Admin --}}
    @if ($user && $user->isAdmin())
        <div class="sidebar-heading text-light px-3">Administration</div>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('utilisateurs*') ? 'active' : '' }}"
                href="{{ route('admin.utilisateurs.index') }}">
                <i class="fas fa-users-cog"></i>
                <span>Utilisateurs</span>
            </a>
        </li>

        {{--  <li class="nav-item">
            <a class="nav-link {{ request()->is('parametres*') ? 'active' : '' }}" href="{{ url('/parametres') }}">
                <i class="fas fa-cogs"></i>
                <span>Paramètres</span>
            </a>
        </li> --}}
    @endif

    <hr class="sidebar-divider my-3">
    <div class="text-center px-3 small text-white-50">
        Version 1.0 – {{ now()->year }}
    </div>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
