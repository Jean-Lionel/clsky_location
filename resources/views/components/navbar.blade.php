<!-- Navbar Start -->
<div class="container-fluid nav-bar bg-transparent">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
        <a href="/" class="navbar-brand d-flex align-items-center text-center">
            <div class="icon p-2 me-2">
                <img class="img-fluid" src="img/icon-deal.png" alt="Icon" style="width: 30px; height: 30px;">
            </div>
            <h1 class="m-0 text-primary">CL SKY COMPANY</h1>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto">
                <a href="/" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">
                    {{-- <i class="bi bi-house"></i>  --}}
                    Home
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
                    <a href="#" class="nav-link dropdown-toggle {{ Request::is('property.*') ? 'active' : '' }}" data-bs-toggle="dropdown">Property</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="{{ route('property.list') }}" class="dropdown-item">Property List</a>
                        <a href="{{ route('property.type') }}" class="dropdown-item">Property Type</a>
                        <a href="{{ route('property.agent') }}" class="dropdown-item">Property Agent</a>
                    </div>
                </div> --}}
                {{-- <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="{{ route('testimonial') }}" class="dropdown-item {{ Request::is('testimonial') ? 'active' : '' }}">Testimonial</a>
                        <a href="{{ route('404') }}" class="dropdown-item {{ Request::is('404') ? 'active' : '' }}">404 Error</a>
                    </div>
                </div> --}}
                <a href="{{ route('about') }}" class="nav-item nav-link {{ Request::is('about') ? 'active' : '' }}">
                    About
                </a>
                <a href=" {{route('contact')}}" class="nav-item nav-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a>
            </div>
           @if (Auth::check())
               <a href="{{ route('logout') }}" class="btn btn-primary px-3 d-none d-lg-flex">Logout</a>

           @else
            <a href="{{ route('login') }}" class="btn btn-primary px-3 d-none d-lg-flex">Login</a>
           @endif

        </div>
    </nav>
</div>
<!-- Navbar End -->
