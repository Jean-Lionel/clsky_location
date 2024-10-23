<nav class="col-md-3 col-lg-2 d-md-block sidebar collapse" id="sidebarMenu">
    <div class="logo-section">
        <h3>CL SKY APARTMENT</h3>
    </div>
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    Tableau de bord
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('properties*') ? 'active' : '' }}" href="{{ route('properties.index') }}">
                    <i class="bi bi-building"></i>
                    Appartements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <i class="bi bi-people-fill"></i>
                    Utilisateurs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('reservations*') ? 'active' : '' }}" href="{{ route('reservations.index') }}">
                    <i class="bi bi-calendar2-check"></i>
                    Réservations
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('messages*') ? 'active' : '' }}" href="{{ route('messages.index') }}">
                    <i class="bi bi-chat-dots"></i>
                    Messages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('payments*') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                    <i class="bi bi-credit-card"></i>
                    Paiements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('reports*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                    <i class="bi bi-file-earmark-text"></i>
                    Rapports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('settings*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                    <i class="bi bi-gear"></i>
                    Paramètres
                </a>
            </li>
        </ul>
    </div>
</nav>