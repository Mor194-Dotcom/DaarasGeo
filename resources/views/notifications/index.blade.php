{{-- @extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- En-tête -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 text-gray-800">
                <i class="bi bi-bell-fill text-primary me-2 fs-4"></i> Centre de Notifications
            </h1>
        </div>

        @forelse ($notifications as $notif)
            @php
                $isCritical = $notif->est_critique;
                $isRead = $notif->vue;
                $hasAlerte = isset($notif->alerte);
                $cardStyle = $isCritical
                    ? 'border-start border-danger shadow-lg'
                    : 'border-start border-info shadow-sm';
                $icon = $isCritical ? 'bi-shield-exclamation text-danger' : 'bi-info-circle text-info';
                $time = \Carbon\Carbon::parse($notif->date_envoi);
            @endphp

            <div class="card mb-4 {{ $cardStyle }} animate__animated animate__fadeIn">
                <div class="card-body">
                    <!-- En-tête notification -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="text-dark mb-0">
                            <i class="bi {{ $icon }} fs-5 me-2"></i>{{ $notif->contenu }}
                        </h5>
                        <span
                            class="badge rounded-pill {{ $isCritical ? 'bg-danger-subtle text-danger' : 'bg-info-subtle text-info' }}">
                            <i class="bi bi-clock me-1"></i> {{ $time->diffForHumans() }}
                        </span>
                    </div>

                    <!-- Corps -->
                    <ul class="list-unstyled mb-3 small">
                        <li>
                            <i class="bi bi-calendar-event me-1 text-muted"></i>
                            Reçue le {{ $time->format('d/m/Y à H:i') }}
                        </li>
                        @if ($hasAlerte)
                            <li>
                                <i class="bi bi-geo-alt-fill me-1 text-muted"></i>
                                Distance : <strong>{{ number_format($notif->alerte->distance, 2) }} m</strong>
                            </li>
                        @endif
                        <li>
                            <i class="bi bi-check2-square me-1 text-muted"></i>
                            Statut :
                            @if ($isRead)
                                <span class="text-secondary fw-semibold">Déjà lue</span>
                            @else
                                <span class="text-success fw-semibold">Non lue</span>
                            @endif
                        </li>
                    </ul>

                    <!-- Action -->
                    <div class="text-end mt-2">
                        @if (!$isRead)
                            <form method="POST" action="{{ route('notifications.valider', $notif->id) }}"
                                class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-check-circle me-1"></i> Marquer comme lue
                                </button>
                            </form>
                        @else
                            <span class="badge bg-secondary px-3 py-2 rounded-pill">
                                <i class="bi bi-eye-fill me-1"></i> Déjà lue
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-light border-start border-warning shadow-sm d-flex align-items-center">
                <i class="bi bi-inbox-fill text-warning me-2 fs-5"></i> Aucune notification disponible.
            </div>
        @endforelse
    </div>
@endsection
 --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-gray-800">
                <i class="bi bi-bell-fill text-primary me-2 fs-4"></i> Centre de Notifications
            </h1>
        </div>

        @forelse ($notifications as $notif)
            @php
                $isCritical = $notif->est_critique;
                $isRead = $notif->vue;
                $hasAlerte = isset($notif->alerte);
                $borderColor = $isCritical ? 'border-danger' : 'border-info';
                $icon = $isCritical ? 'bi-shield-exclamation text-danger' : 'bi-info-circle text-info';
                $timestamp = \Carbon\Carbon::parse($notif->date_envoi);
            @endphp

            <div class="card mb-4 {{ $borderColor }} shadow-sm animate__animated animate__fadeIn"
                style="background-color: rgba(255, 255, 255, 0.85); border-left: 4px solid; border-radius: 0.6rem;">
                <div class="card-body px-4 py-3">
                    <!-- Titre et icône -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi {{ $icon }} fs-4 me-3"></i>
                            <h5 class="mb-0 fw-semibold text-dark">{{ $notif->contenu }}</h5>
                        </div>
                        <span
                            class="badge rounded-pill {{ $isCritical ? 'bg-danger-subtle' : 'bg-info-subtle' }} text-dark fw-semibold px-3">
                            <i class="bi bi-clock me-1"></i> {{ $timestamp->diffForHumans() }}
                        </span>
                    </div>

                    <!-- Métadonnées -->
                    <ul class="list-unstyled small mb-3">
                        <li><i class="bi bi-calendar-event me-2 text-muted"></i> {{ $timestamp->format('d/m/Y à H:i') }}
                        </li>
                        @if ($hasAlerte)
                            <li><i class="bi bi-geo-alt-fill me-2 text-muted"></i> Distance :
                                <strong>{{ number_format($notif->alerte->distance, 2) }} m</strong>
                            </li>
                        @endif
                        <li><i class="bi bi-check2-square me-2 text-muted"></i> Statut :
                            <span class="fw-semibold">{{ $isRead ? 'Déjà lue' : 'Non lue' }}</span>
                        </li>
                    </ul>

                    <!-- Action -->
                    <div class="text-end mt-2">
                        @if (!$isRead)
                            <form method="POST" action="{{ route('notifications.valider', $notif->id) }}"
                                class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-outline-success btn-sm rounded-pill px-3">
                                    <i class="bi bi-check-circle me-1"></i> Marquer comme lue
                                </button>
                            </form>
                        @else
                            <span class="badge bg-secondary text-light rounded-pill px-3 py-2">
                                <i class="bi bi-eye-fill me-1"></i> Déjà lue
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-light border-start border-warning shadow-sm d-flex align-items-center">
                <i class="bi bi-inbox-fill text-warning me-2 fs-5"></i> Aucune notification disponible.
            </div>
        @endforelse
        <div class="d-flex justify-content-center">
            {{ $notifications->onEachSide(1)->links('pagination::bootstrap-5') }}

        </div>

    </div>
@endsection
