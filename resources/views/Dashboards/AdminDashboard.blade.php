@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
    <!-- Titre principal -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 text-gray-800">Bienvenue cher Administrateur dans DaarasGeo <sup>.loc</sup></h1>
        <span class="text-muted">Pilotage de <strong>DaarasGeo</strong><sup>.loc</sup> —
            {{ now()->format('d M Y – H:i') }}</span>
    </div>

    <!-- Statistiques principales -->
    <div class="row">
        <x-card-stats label="Daaras" value="{{ $totalDaaras }}" color="primary" icon="fa-school" />
        <x-card-stats label="Talibés" value="{{ $totalTalibes }}" color="warning" icon="fa-child" />
        <x-card-stats label="Responsables Daara" value="{{ $totalResponsables }}" color="custom-purple"
            icon="fa-user-tie" />
        <x-card-stats label="Alertes" value="{{ $totalAlertes }}" color="danger" icon="fa-exclamation-triangle" />
    </div>

    <!-- Section synthèse étendue (si nécessaire) -->
    <div class="row mt-4">
        <div class="col-xl-8 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-chart-line mr-2"></i> Évolution des alertes</h6>
                    <a href="#" class="btn btn-sm btn-light">Exporter</a>
                </div>
                <div class="card-body">
                    <canvas id="alertesChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-map-marked-alt mr-2"></i> Répartition géographique
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted">Carte en cours d'intégration…</p>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const ctx = document.getElementById('alertesChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($alertesJours) !!},
                    datasets: [{
                        label: 'Alertes détectées',
                        data: {!! json_encode($alertesCount) !!},
                        backgroundColor: 'rgba(255,99,132,0.2)',
                        borderColor: '#dc3545',
                        tension: 0.3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#dc3545',
                        pointRadius: 5,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            ticks: {
                                autoSkip: false
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
    <style>
        .border-left-custom-purple {
            border-left: 4px solid #a855f7;
            /* Violet Tailwind */
        }

        .text-custom-purple {
            color: #a855f7;
        }
    </style>

@endsection
