<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('/') }}">
                <i class="bi bi-grid"></i>
                <span>Tableau de bord</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#country" data-bs-toggle="collapse" href="#">
                <i class="bi bi-tools"></i><span>Services</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="country" class="nav-content collapse {{ request()->routeIs('services.*') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('services.index') }}"
                        class="{{ request()->routeIs('services.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Liste des services</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('services.create') }}"
                        class="{{ request()->routeIs('services.create') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Ajouter un service</span>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person"></i><span>Clients</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse @if (request()->is('clients*')) show @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('clients.index') }}"
                        class="{{ request()->routeIs('clients.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Liste des Clients</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--Partners-->
        <li class="nav-item">
            <a class="nav-link collapsed @if (request()->is('partners*')) active @endif" data-bs-target="#partners"
                data-bs-toggle="collapse" href="#">
                <i class="bi bi-people"></i><span>Prestataires</span><i
                    class="bi bi-chevron-down ms-auto @if (request()->is('partners*')) rotate180 @endif"></i>
            </a>
            <ul id="partners" class="nav-content collapse @if (request()->is('partners*')) show @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('partners.index') }}"
                        class="{{ request()->routeIs('partners.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Liste des prestataires</span>
                    </a>
                </li>
                
            </ul>
        </li>
        <!--End Partners-->


    </ul>

</aside><!-- End Sidebar-->
