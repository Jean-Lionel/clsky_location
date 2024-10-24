{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CL SKY APARTMENT - Administration')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        /* Copier tous les styles CSS du template original ici */
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --hover-color: #2980b9;
        }
        /* ... le reste des styles ... */
    </style>
    @stack('styles')
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
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
           href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            Tableau de bord
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('properties.*') ? 'active' : '' }}" 
           href="{{ route('properties.index') }}">
            <i class="bi bi-building"></i>
            Appartements
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" 
           href="{{ route('users.index') }}">
            <i class="bi bi-people-fill"></i>
            Utilisateurs
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}" 
           href="{{ route('reservations.index') }}">
            <i class="bi bi-calendar2-check"></i>
            Réservations
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" 
           href="{{ route('messages.index') }}">
            <i class="bi bi-chat-dots"></i>
            Messages
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}" 
           href="{{ route('payments.index') }}">
            <i class="bi bi-credit-card"></i>
            Paiements
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" 
           href="{{ route('reports.index') }}">
            <i class="bi bi-file-earmark-text"></i>
            Rapports
        </a>
    </li>
    <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('settings.index') ? 'active' : '' }}" 
       href="{{ route('settings.index') }}">
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
                                      
                                          5
                                    </span>
                               
                            </div>
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="rounded-circle me-2" width="32" height="32" alt="Profile">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span>{{ auth()->user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="bi bi-gear me-2"></i>Paramètres</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Messages Flash -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Contenu de la page -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>