<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CL SKY APARTMENT - Administration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* Styles personnalisés */
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --hover-color: #2980b9;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        
        .logo-section {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .logo-section h3 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #fff, #ecf0f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin: 4px 8px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: var(--accent-color);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link i {
            margin-right: 12px;
            font-size: 1.2rem;
        }
        
        .main-content {
            margin-left: 250px;
        }
        
        .stats-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            border-left: 4px solid var(--accent-color);
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .navbar {
            background-color: #fff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .user-profile img {
            border: 2px solid var(--accent-color);
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
        
        /* Animation pour les cartes statistiques */
        .stats-card {
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse" id="sidebarMenu">
                <div class="logo-section">
                    <h3>CL SKY APARTMENT</h3>
                </div>
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">
                                <i class="bi bi-speedometer2"></i>
                                Tableau de bord
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/properties">
                                <i class="bi bi-building"></i>
                                Appartements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/users">
                                <i class="bi bi-people-fill"></i>
                                Utilisateurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/reservations">
                                <i class="bi bi-calendar2-check"></i>
                                Réservations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/messages">
                                <i class="bi bi-chat-dots"></i>
                                Messages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/payments">
                                <i class="bi bi-credit-card"></i>
                                Paiements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/reports">
                                <i class="bi bi-file-earmark-text"></i>
                                Rapports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/settings">
                                <i class="bi bi-gear"></i>
                                Paramètres
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Contenu Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Header -->
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                            <i class="bi bi-list"></i>
                        </button>
                        
                        <div class="d-flex align-items-center">
                            <div class="position-relative me-3">
                                <i class="bi bi-bell fs-5"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    3
                                </span>
                            </div>
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                    <img src="/api/placeholder/32/32" class="rounded-circle me-2" width="32" height="32">
                                    <span>Admin User</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Paramètres</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Contenu de la page -->
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
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card stats-card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-2">Clients Actifs</h6>
                                            <h3 class="mb-0">287</h3>
                                        </div>
                                        <div class="text-success">
                                            <i class="bi bi-people fs-1"></i>
                                        </div>
                                    </div>
                                    <div class="text-success mt-2 small">
                                        <i class="bi bi-arrow-up"></i> +12% ce mois
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card stats-card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-2">Réservations</h6>
                                            <h3 class="mb-0">156</h3>
                                        </div>
                                        <div class="text-info">
                                            <i class="bi bi-calendar-check fs-1"></i>
                                        </div>
                                    </div>
                                    <div class="text-success mt-2 small">
                                        <i class="bi bi-arrow-up"></i> +8% ce mois
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card stats-card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-2">Revenus</h6>
                                            <h3 class="mb-0">24,500€</h3>
                                        </div>
                                        <div class="text-warning">
                                            <i class="bi bi-currency-euro fs-1"></i>
                                        </div>
                                    </div>
                                    <div class="text-success mt-2 small">
                                        <i class="bi bi-arrow-up"></i> +15% ce mois
                                    </div>
                                </div>
                            </div>
                        </div>
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
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>