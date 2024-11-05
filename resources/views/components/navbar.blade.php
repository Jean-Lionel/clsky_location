<!-- Début de la barre de navigation -->
<div class="container-fluid nav-bar bg-transparent">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
        <a href="/" class="navbar-brand d-flex align-items-center text-center">
            <div class="icon p-2 me-2">
                <img class="img-fluid" src="{{ asset('img/icon-deal.png') }}" alt="Icône" style="width: 30px; height: 30px;">
            </div>
            <h3 class="m-0 text-primary">CL SKY COMPANY</h3>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto">
                <a href="/" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">
                    {{-- <i class="bi bi-house"></i>  --}}
                    Accueil
                </a>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.properties.*') ? 'active' : '' }}"
                        href="{{ route('client.properties.index') }}">
                        {{-- <i class="bi bi-building"></i>  --}}
                        Nos Propriétés
                    </a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.reservations.*') ? 'active' : '' }}"
                        href="{{ route('client.reservations.index') }}">
                        {{-- <i class="bi bi-calendar-check"></i>  --}}
                        Mes Réservations
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.payments.*') ? 'active' : '' }}"
                        href="{{ route('client.payments.index') }}">
                        {{-- <i class="bi bi-credit-card"> --}}
                        </i> Mes Paiements
                    </a>
                </li>
                @endauth
                {{-- <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ Request::is('property.*') ? 'active' : '' }}" data-bs-toggle="dropdown">Propriété</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="{{ route('property.list') }}" class="dropdown-item">Liste des Propriétés</a>
                        <a href="{{ route('property.type') }}" class="dropdown-item">Type de Propriété</a>
                        <a href="{{ route('property.agent') }}" class="dropdown-item">Agent Immobilier</a>
                    </div>
                </div> --}}
                {{-- <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="{{ route('testimonial') }}" class="dropdown-item {{ Request::is('testimonial') ? 'active' : '' }}">Témoignage</a>
                        <a href="{{ route('404') }}" class="dropdown-item {{ Request::is('404') ? 'active' : '' }}">Erreur 404</a>
                    </div>
                </div> --}}
                <a href="{{ route('about') }}" class="nav-item nav-link {{ Request::is('about') ? 'active' : '' }}">
                    À Propos
                </a>
                <a href="{{ route('contact') }}" class="nav-item nav-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a>
            </div>
            @if (Auth::check())
            <form method="POST" action="{{ route('client.logout') }}">
                @csrf
                <button type="submit" class="btn btn-primary px-3 d-none d-lg-flex">
                    <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                </button>
            </form>

            @else
            <a href="{{ route('client.login') }}" class="btn btn-primary px-3 d-none d-lg-flex">Connexion</a>
            @endif

        </div>
    </nav>
</div>
<!-- Fin de la barre de navigation -->
