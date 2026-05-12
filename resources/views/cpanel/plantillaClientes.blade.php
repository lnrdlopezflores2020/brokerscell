<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title") | SoluxMovil Cliente</title>
    
    {{-- SCRIPT ANTI-PARPADEO: Aplica el tema guardado antes de que la página se dibuje --}}
    <script>
        (function() {
            const temaGuardado = localStorage.getItem('solux_theme');
            if (temaGuardado === 'dark') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            }
        })();
    </script>
    
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

        .dropdown-item-theme, .dropdown-item {
            cursor: pointer;
            user-select: none;
            transition: background-color 0.2s ease;
        }

        /* ==================================================================== */
        /* FORZAR MODO OSCURO SOBRE ELEMENTOS REBELDES */
        /* ==================================================================== */
        [data-bs-theme="dark"] body {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
        }

        /* Tarjetas y Contenedores */
        [data-bs-theme="dark"] .bg-white, 
        [data-bs-theme="dark"] .bg-light,
        [data-bs-theme="dark"] .card,
        [data-bs-theme="dark"] .card-header,
        [data-bs-theme="dark"] .card-footer {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8f9fa !important;
        }

        /* Textos */
        [data-bs-theme="dark"] .text-dark,
        [data-bs-theme="dark"] .text-body {
            color: #f8f9fa !important;
        }

        [data-bs-theme="dark"] .text-muted,
        [data-bs-theme="dark"] .text-secondary {
            color: #94a3b8 !important;
        }

        /* FIX DEFINITIVO PARA TABLAS Y HOVER */
        [data-bs-theme="dark"] .table,
        [data-bs-theme="dark"] .table > :not(caption) > * > * {
            background-color: transparent !important;
            color: #e2e8f0 !important;
            border-color: #334155 !important;
            transition: background-color 0.2s ease;
        }

        [data-bs-theme="dark"] .table-hover > tbody > tr:hover > td,
        [data-bs-theme="dark"] .table-hover > tbody > tr:hover > th {
            background-color: #334155 !important; 
            color: #ffffff !important;
        }

        [data-bs-theme="dark"] .table-light th,
        [data-bs-theme="dark"] .table-light td {
            background-color: #0f172a !important;
            color: #94a3b8 !important;
            border-bottom-color: #334155 !important;
        }

        /* Inputs y Selects */
        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select,
        [data-bs-theme="dark"] .input-group-text {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f8f9fa !important;
        }
    </style>
</head>
<body class="bg-body-tertiary">

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
                        {{-- LÓGICA PARA MOSTRAR EL NOMBRE REAL (Solo Cliente) --}}
                        @php
                            $nombreMostrar = auth()->user()->name ?? 'Cliente';
                            if(auth()->user()->rol_usuario === 'cliente' && auth()->user()->datosCliente) {
                                $nombreMostrar = auth()->user()->datosCliente->nombre . ' ' . auth()->user()->datosCliente->apellido;
                            }
                        @endphp
                        
                        <span class="d-block small fw-bold">{{ $nombreMostrar }}</span>
                        <span class="d-block text-uppercase" style="font-size: 0.70rem; color: #94a3b8;">Área Personal</span>
                    </div>
                    <img src="/assets/images/usuario (1).png" alt="Perfil" width="38" height="38" class="rounded-circle border border-secondary bg-white">
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 p-2" style="min-width: 240px; border-radius: 12px;">
                    
                    {{-- SECCIÓN: CUENTA --}}
                    <li><h6 class="dropdown-header text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Cuenta</h6></li>
                    <li>
                        <a class="dropdown-item py-2 rounded" href="{{route('perfilCliente')}}">
                            <i class="bi bi-person me-2 text-primary"></i>Mi Perfil
                        </a>
                    </li>
                

                    <li><hr class="dropdown-divider my-2"></li>
                    
                    {{-- SECCIÓN: AJUSTES VISUALES --}}
                    <li><h6 class="dropdown-header text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Ajustes Visuales</h6></li>
                    <li>
                        <div class="dropdown-item py-2 d-flex justify-content-between align-items-center dropdown-item-theme rounded" id="btnTemaGlobal">
                            <span><i class="bi bi-moon-stars me-2 text-secondary" id="iconoTemaGlobal"></i> Modo Oscuro</span>
                            <div class="form-check form-switch m-0 p-0">
                                <input class="form-check-input ms-2" type="checkbox" role="switch" id="switchTemaGlobal" style="cursor: pointer; pointer-events: none;">
                            </div>
                        </div>
                    </li>

                    <li><hr class="dropdown-divider my-2"></li>

                    {{-- SECCIÓN: SALIDA --}}
                    <li>
                        <form action="{{ route('logout') }}" method="POST"> 
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger fw-medium rounded hover-danger">
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

{{-- SCRIPT PARA CONTROL DE MODO OSCURO --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btnTema = document.getElementById('btnTemaGlobal');
        const switchTema = document.getElementById('switchTemaGlobal');
        const iconoTema = document.getElementById('iconoTemaGlobal');
        const html = document.documentElement;

        const temaActual = html.getAttribute('data-bs-theme');
        if (temaActual === 'dark') {
            switchTema.checked = true;
            actualizarIcono('dark');
        }

        btnTema.addEventListener('click', function (e) {
            e.stopPropagation();
            const nuevoTema = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', nuevoTema);
            switchTema.checked = (nuevoTema === 'dark');
            localStorage.setItem('solux_theme', nuevoTema);
            actualizarIcono(nuevoTema);
        });

        function actualizarIcono(tema) {
            if (tema === 'dark') {
                iconoTema.classList.replace('bi-moon-stars', 'bi-sun-fill');
                iconoTema.classList.remove('text-secondary');
                iconoTema.classList.add('text-warning');
            } else {
                iconoTema.classList.replace('bi-sun-fill', 'bi-moon-stars');
                iconoTema.classList.remove('text-warning');
                iconoTema.classList.add('text-secondary');
            }
        }
    });
</script>
</body>
</html>