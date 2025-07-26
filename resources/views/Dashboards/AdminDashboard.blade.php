{{-- @extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
    <div class="container-fluid px-4">
        <!-- 🎉 Titre -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 text-gray-800">
                Bienvenue cher Administrateur dans <strong>DaarasGeo</strong><sup>.loc</sup>
            </h1>
            <span class="text-muted">
                Pilotage — {{ now()->format('d M Y – H:i') }}
            </span>
        </div>

        <!-- 📊 Statistiques -->
        <div class="row">
            <x-card-stats label="Daaras" value="{{ $totalDaaras }}" color="primary" icon="fa-school" />
            <x-card-stats label="Talibés" value="{{ $totalTalibes }}" color="warning" icon="fa-child" />
            <x-card-stats label="Responsables Daara" value="{{ $totalResponsables }}" color="custom-purple"
                icon="fa-user-tie" />
            <x-card-stats label="Alertes" value="{{ $totalAlertes }}" color="danger" icon="fa-exclamation-triangle" />
        </div>

        <!-- 📈 Graphique + Carte -->
        <!-- 📊 Graphe d’évolution & camembert -->
        <div class="row mt-4">
            <!-- 🔵 Graphe en ligne -->
            <div class="col-xl-8 col-md-12 mb-4">
                <div class="card shadow">
                    <div
                        class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-chart-line mr-2"></i> Évolution des alertes
                        </h6>
                        <a href="#" class="btn btn-sm btn-light">Exporter</a>
                    </div>
                    <div class="card-body">
                        <canvas id="alertesChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- 🥧 Graphe circulaire : Top 3 Daaras en alertes -->
            <div class="col-xl-4 col-md-12 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-danger text-white">
                        <h6 class="m-0"><i class="fas fa-chart-pie me-2"></i> Top 3 Daaras en alertes</h6>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">

                        <canvas id="daarasPieChart" width="250" height="250" style="max-width:100%"></canvas>
                    </div>
                </div>
            </div>



        </div>
    @endsection

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
        <style>
            #mapDashboard {
                border-radius: 0 0 .5rem .5rem;
                position: relative;
                z-index: 0;
                /* Carte en arrière-plan */
            }

            #searchInput {
                position: absolute;
                top: 10px;
                left: 10px;
                z-index: 9999;
                /* Très haut pour passer au-dessus */
                background: white;
                width: calc(100% - 20px);
                padding: 6px 10px;
                border-radius: 4px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }


            .leaflet-tooltip-dashboard {
                background-color: #0d6efd;
                color: white;
                font-weight: bold;
                border-radius: 4px;
                padding: 4px 6px;
            }

            #daarasPieChart {
                max-width: 100%;
                margin: auto;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet.gridlayer.googlemutant@latest/Leaflet.GoogleMutant.js"></script>

        <script>
            const daaras = @json($daaras ?? []);
            const alertesJours = {!! json_encode($alertesJours ?? []) !!};
            const alertesCount = {!! json_encode($alertesCount ?? []) !!};

            let map, tileLayer, searchMarker;

            // 📈 Graphique des alertes
            const ctx = document.getElementById('alertesChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: alertesJours,
                    datasets: [{
                        label: 'Alertes détectées',
                        data: alertesCount,
                        backgroundColor: 'rgba(255,99,132,0.2)',
                        borderColor: '#dc3545',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4
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

            // graphique chart.js
            const ctxPie = document.getElementById('daarasPieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        data: {!! json_encode($data) !!},
                        backgroundColor: ['#dc3545', '#ffc107', '#0d6efd'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    const label = ctx.label || '';
                                    const value = ctx.raw;
                                    const total = ctx.chart._metasets[ctx.datasetIndex].total;
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} alertes (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
 --}}
@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
    <div class="container-fluid px-4">
        {{--  <!-- 🎉 Titre -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 text-gray-800">
                Bienvenue cher Administrateur dans <strong>DaarasGeo</strong><sup>.loc</sup>
            </h1>
            <span class="text-muted">
                Pilotage — {{ now()->format('d M Y – H:i') }}
            </span>
        </div> --}}
        {{-- <!-- 🔷 Titre principal -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <h2 class="text-dark fw-bold d-flex align-items-center gap-2">
                <i class="fas fa-tachometer-alt text-primary"></i> Dashboard Super Admin
            </h2>
            <span class="text-muted">
                Pilotage — {{ now()->format('d M Y – H:i') }}
            </span>
        </div> --}}
        <!-- 🔷 En-tête du Dashboard -->
        <div
            class="bg-light rounded shadow-sm p-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center"
                    style="width: 50px; height: 50px;">
                    <i class="fas fa-tachometer-alt fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-0 fw-bold text-dark">Dashboard Super Admin</h2>
                    <small class="text-muted">Pilotage centralisé de la plateforme DaarasGeo</small>
                </div>
            </div>

            <div class="mt-3 mt-md-0 text-end">
                <span class="text-muted d-block">
                    <i class="fas fa-calendar-alt me-1"></i> {{ now()->format('d M Y') }}
                </span>
                <span class="text-muted">
                    <i class="fas fa-clock me-1"></i> {{ now()->format('H:i') }}
                </span>
            </div>
        </div>
        <style>
            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.1);
                }

                100% {
                    transform: scale(1);
                }
            }

            .bg-primary i {
                animation: pulse 2s infinite;
            }
        </style>

        <!-- 📊 Statistiques -->
        <div class="row">
            <x-card-stats label="Daaras" value="{{ $totalDaaras }}" color="primary" icon="fa-school" />
            <x-card-stats label="Talibés" value="{{ $totalTalibes }}" color="warning" icon="fa-child" />
            <x-card-stats label="Responsables" value="{{ $totalResponsables }}" color="secondary" icon="fa-user-tie" />
            <x-card-stats label="Alertes" value="{{ $totalAlertes }}" color="danger" icon="fa-exclamation-triangle" />
        </div>

        <!-- 📈 Graphiques -->
        <div class="row mt-4">
            <!-- 🔵 Ligne des alertes -->
            <div class="col-xl-8 col-md-12 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold">
                            <i class="fas fa-chart-line me-2"></i> Évolution des alertes
                        </h6>
                        <a href="#" class="btn btn-sm btn-light">
                            <i class="fas fa-download me-1"></i> Exporter
                        </a>
                    </div>
                    <div class="card-body">
                        <canvas id="alertesChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- 🥧 Camembert des Daaras -->
            <div class="col-xl-4 col-md-12 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-danger text-white">
                        <h6 class="m-0"><i class="fas fa-chart-pie me-2"></i> Top 3 Daaras en alertes</h6>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="daarasPieChart" width="250" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🗺️ Carte des Daaras -->
        {{--  <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <i class="fas fa-map-marked-alt me-2"></i> Répartition géographique des Daaras
            </div>
            <div class="card-body p-0">
                <div id="mapDashboard" style="height: 500px;"></div>
            </div>
        </div> --}}
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        #mapDashboard {
            border-radius: 0 0 .5rem .5rem;
            position: relative;
            z-index: 0;
        }

        .leaflet-tooltip-dashboard {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
            border-radius: 4px;
            padding: 4px 6px;
        }

        #daarasPieChart {
            max-width: 100%;
            margin: auto;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const daaras = @json($daaras ?? []);
        const alertesJours = {!! json_encode($alertesJours ?? []) !!};
        const alertesCount = {!! json_encode($alertesCount ?? []) !!};

        // 📈 Ligne des alertes
        new Chart(document.getElementById('alertesChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: alertesJours,
                datasets: [{
                    label: 'Alertes détectées',
                    data: alertesCount,
                    backgroundColor: 'rgba(255,99,132,0.2)',
                    borderColor: '#dc3545',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4
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

        // 🥧 Camembert des Daaras
        new Chart(document.getElementById('daarasPieChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    data: {!! json_encode($data) !!},
                    backgroundColor: ['#dc3545', '#ffc107', '#0d6efd'],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                const label = ctx.label || '';
                                const value = ctx.raw;
                                const total = ctx.chart._metasets[ctx.datasetIndex].total;
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} alertes (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // 🗺️ Carte Leaflet
        const map = L.map('mapDashboard').setView([14.6928, -17.4467], 7);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        daaras.forEach(d => {
            if (!d.latitude || !d.longitude) return;

            const marker = L.marker([d.latitude, d.longitude]).addTo(map);
            marker.bindTooltip(d.nom, {
                permanent: false,
                direction: 'top',
                className: 'leaflet-tooltip-dashboard'
            });
        });
    </script>
@endpush
