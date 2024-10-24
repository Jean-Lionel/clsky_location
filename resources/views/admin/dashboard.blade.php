@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Cartes Statistiques -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card stats-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Appartements</h6>
                            <h3 class="mb-0">45</h3>
                        </div>
                        <div class="text-primary">
                            <i class="bi bi-building fs-1"></i>
                        </div>
                    </div>
                    <div class="text-success mt-2 small">
                        <i class="bi bi-arrow-up"></i> +5% ce mois
                    </div>
                </div>
            </div>
        </div>
        <!-- Répétez pour les autres cartes -->
    </div>

    <!-- Tableau des Dernières Activités -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Dernières Activités</h5>
            <button class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Nouvelle entrée
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Appartement</th>
                            <th>Client</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1234</td>
                            <td>Sky View Suite</td>
                            <td>Jean Dupont</td>
                            <td>
                                <span class="badge bg-success">Confirmé</span>
                            </td>
                            <td>23/10/2024</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection