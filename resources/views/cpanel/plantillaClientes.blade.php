<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title") | SoluxMovil Cliente</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    
    {{-- Hojas de estilo personalizadas --}}
    <link rel="stylesheet" href="/assets/css/style_form.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/style_consulta.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/style.css">
    
    {{-- Iconos de Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/SOLUXMOVIL.png" type="image/png">
    
    <style>
        /* Ajustes UI para panel de Cliente */
        body {
            background-color: #f8f9fa; /* Fondo gris muy claro para el área de trabajo */
        }
        
        .client-navbar {
            background-color: #1e293b; /* Azul pizarra oscuro */
            border-bottom: 1px solid #334155;
        }

        .client-sidebar {
            background-color: #1e293b;
        }

        /* Enlaces del menú lateral */
        .sidebar-link {
            color: #cbd5e1;
            transition: none; /* Sin animaciones extra */
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            background-color: #334155;
            color: #ffffff;
        }

        .sidebar-link.active {
            background-color: #0f172a;
            color: #ffffff;
            border-left-color: #3b82f6; /* Indicador de página activa */
            font-weight: 600;
        }
    </style>
</head>
<body>

<header>
    {{-- Navbar Superior --}}
    <nav class="navbar fixed-top navbar-dark client-navbar shadow-sm">
        <div class="container-fluid px-3">

            <div class="d-flex align-items-center">
                <button class="navbar-toggler me-3 border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon" style="width: 1.2em; height: 1.2em;"></span>
                </button>

                <a class="navbar-brand fw-bold tracking-wide" href="{{route('index')}}">
                    <i class="bi bi-phone text-primary me-2"></i>SOLUX<span class="text-primary">MOVIL</span>
                </a>
            </div>

            {{-- Dropdown de Usuario --}}
            <div class="dropdown">
                <a class="d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-none d-md-block text-end me-3 text-white">
                        <span class="d-block small fw-bold">{{ auth()->user()->name ?? 'Cliente' }}</span>
                        <span class="d-block" style="font-size: 0.75rem; color: #94a3b8;">Área Personal</span>
                    </div>
                    <img src="/assets/images/usuario (1).png" alt="Perfil" width="38" height="38" class="rounded-circle border border-secondary bg-white">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                    <li><a class="dropdown-item py-2" href="{{route('perfilCliente')}}"><i class="bi bi-person me-2 text-secondary"></i>Mi Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST"> 
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger fw-medium">
                                <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            {{-- Menú Lateral (Offcanvas) --}}
            <div class="offcanvas offcanvas-start client-sidebar text-white" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="width: 280px;">
                <div class="offcanvas-header border-bottom" style="border-color: #334155 !important;">
                    <h6 class="offcanvas-title fw-bold text-uppercase" id="offcanvasNavbarLabel" style="letter-spacing: 1px; color: #94a3b8;">
                        Menú Cliente
                    </h6>
                    <button type="button" class="btn-close btn-close-white opacity-50 shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body p-0 py-2">
                    <ul class="navbar-nav flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link sidebar-link px-4 py-3 {{ request()->routeIs('index') ? 'active' : '' }}" href="{{route('index')}}">
                                <i class="bi bi-house-door-fill me-3 opacity-75"></i> Inicio
                            </a>
                        </li>

                        <li class="nav-item border-top border-white-50 my-2 mx-3" style="opacity: 0.1;"></li>

                        <li class="nav-item">
                            <a class="nav-link sidebar-link px-4 py-3 {{ request()->routeIs('Mis-reparaciones.index') ? 'active' : '' }}" href="/cliente/Mis-reparaciones">
                                <i class="bi bi-search me-3 opacity-75"></i> Consultar Reparación
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link sidebar-link px-4 py-3 {{ request()->routeIs('chatbot.index') ? 'active' : '' }}" href="/cliente/asistente">
                                <i class="bi bi-chat-dots-fill me-3 opacity-75"></i> Ayuda y Soporte
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="offcanvas-footer p-3 border-top text-center" style="border-color: #334155 !important; color: #64748b; font-size: 0.8rem;">
                    SoluxMovil Cliente v1.0
                </div>
            </div>

        </div>
    </nav>
</header>

{{-- CONTENEDOR PRINCIPAL --}}
<div class="main-panel" style="margin-top: 85px; min-height: calc(100vh - 85px);">
    <div class="content-wrapper container-fluid px-3 px-md-4 pb-4">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="/assets/js/sript.js" defer></script>
</body>
</html>