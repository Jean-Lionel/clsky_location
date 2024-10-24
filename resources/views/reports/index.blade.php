@extends('layouts.admin')

@section('title', 'Rapports - CL SKY APARTMENT')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Rapports & Statistiques</h1>
        <div>
            <button class="btn btn-outline-primary me-2">
                <i class="bi bi-download"></i> Exporter PDF
            </button>
            <button class="btn btn-outline-success">
                <i class="bi bi-file-excel"></i> Exporter Excel
            </button>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Réservations du mois</h6>
                            <h3 class="mb-0">{{ $monthlyStats['reservations'] }}</h3>
                        </div>
                        <div class="text-primary">
                            <i class="bi bi-calendar-check fs-1"></i>
                        </div>
                    </div>
                    <div class="text-success mt-2 small">
                        <i class="bi bi-arrow-up"></i> +8% vs mois dernier
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Revenus du mois</h6>
                            <h3 class="mb-0">{{ number_format($monthlyStats['revenue']) }}€</h3>
                        </div>
                        <div class="text-success">
                            <i class="bi bi-currency-euro fs-1"></i>
                        </div>
                    </div>
                    <div class="text-success mt-2 small">
                        <i class="bi bi-arrow-up"></i> +15% vs mois dernier
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Taux d'occupation</h6>
                            <h3 class="mb-0">{{ $monthlyStats['occupancy_rate'] }}%</h3>
                        </div>
                        <div class="text-info">
                            <i class="bi bi-pie-chart fs-1"></i>
                        </div>
                    </div>
                    <div class="text-success mt-2 small">
                        <i class="bi bi-arrow-up"></i> +5% vs mois dernier
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Nouveaux clients</h6>
                            <h3 class="mb-0">{{ $monthlyStats['new_clients'] }}</h3>
                        </div>
                        <div class="text-warning">
                            <i class="bi bi-people fs-1"></i>
                        </div>
                    </div>
                    <div class="text-success mt-2 small">
                        <i class="bi bi-arrow-up"></i> +12% vs mois dernier
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Période</label>
                    <select class="form-select">
                        <option>Ce mois</option>
                        <option>Mois dernier</option>
                        <option>Ce trimestre</option>
                        <option>Cette année</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Type de propriété</label>
                    <select class="form-select">
                        <option>Tous</option>
                        <option>Appartements</option>
                        <option>Studios</option>
                        <option>Duplex</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">État</label>
                    <select class="form-select">
                        <option>Tous</option>
                        <option>Disponible</option>
                        <option>Occupé</option>
                        <option>En maintenance</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des rapports -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Période</th>
                            <th>Réservations</th>
                            <th>Revenus</th>
                            <th>Taux d'occupation</th>
                            <th>Nouveaux clients</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Octobre 2024</td>
                            <td>156</td>
                            <td>24,500€</td>
                            <td>85%</td>
                            <td>45</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-download"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Ajoutez plus de lignes selon vos besoins -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection