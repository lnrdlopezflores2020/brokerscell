<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title") | SoluxMovil Técnico</title>
    
    {{-- SCRIPT ANTI-PARPADEO: Se ejecuta antes de renderizar el body para aplicar el tema oscuro de inmediato si estaba guardado --}}
    <script>
        const temaGuardado = localStorage.getItem('solux_theme');
        if (temaGuardado === 'dark') {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        }
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
        /* Ajustes UI para panel de Técnico */
        
        .tech-navbar {
            background-color: #1e293b; /* Azul pizarra oscuro */
            border-bottom: 1px solid #334155;
        }

        .tech-sidebar {
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

        /* Ajuste para el botón de modo oscuro en el menú */
        .dropdown-item-theme {
            cursor: pointer;
            user-select: none;
        }
    </style>
</head>
<body class="bg-body-tertiary"> <header>
    {{-- Navbar Superior --}}
    <nav class="navbar fixed-top navbar-dark tech-navbar shadow-sm">
        <div class="container-fluid px-3">

            <div class="d-flex align-items-center">
                <button class="navbar-toggler me-3 border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon" style="width: 1.2em; height: 1.2em;"></span>
                </button>

                <a class="navbar-brand fw-bold tracking-wide" href="{{route('tecnico.index')}}">
                    <i class="bi bi-tools text-primary me-2"></i>SOLUX<span class="text-primary">MOVIL</span>
                </a>
            </div>

            {{-- Dropdown de Usuario --}}
            <div class="dropdown">
                <a class="d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-none d-md-block text-end me-3 text-white">
                        <span class="d-block small fw-bold">{{ auth()->user()->name ?? 'Técnico' }}</span>
                        <span class="d-block" style="font-size: 0.75rem; color: #94a3b8;">Área Técnica</span>
                    </div>
                    <img src="/assets/images/usuario (1).png" alt="Perfil" width="38" height="38" class="rounded-circle border border-secondary bg-white">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="min-width: 220px;">
                    <li>
                        <a class="dropdown-item py-2" href="{{url('/tecnico/perfilUsuario')}}">
                            <i class="bi bi-person me-2 text-secondary"></i>Mi Perfil
                        </a>
                    </li>
                    
                    {{-- NUEVO: Opción de Modo Oscuro con Switch --}}
                    <li>
                        <div class="dropdown-item py-2 d-flex justify-content-between align-items-center dropdown-item-theme" id="btnTemaGlobal">
                            <span><i class="bi bi-moon-stars me-2 text-secondary" id="iconoTemaGlobal"></i> Modo Oscuro</span>
                            <div class="form-check form-switch m-0 p-0">
                                <input class="form-check-input ms-2" type="checkbox" role="switch" id="switchTemaGlobal" style="cursor: pointer; pointer-events: none;">
                            </div>
                        </div>
                    </li>

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
            <div class="offcanvas offcanvas-start tech-sidebar text-white" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="width: 280px;">
                <div class="offcanvas-header border-bottom" style="border-color: #334155 !important;">
                    <h6 class="offcanvas-title fw-bold text-uppercase" id="offcanvasNavbarLabel" style="letter-spacing: 1px; color: #94a3b8;">
                        Taller
                    </h6>
                    <button type="button" class="btn-close btn-close-white opacity-50 shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body p-0 py-2">
                    <ul class="navbar-nav flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link sidebar-link px-4 py-3 {{ request()->routeIs('tecnico.index') ? 'active' : '' }}" href="{{route('tecnico.index')}}">
                                <i class="bi bi-house-door-fill me-3 opacity-75"></i> Inicio
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link sidebar-link px-4 py-3 {{ request()->routeIs('reparaciones.*') ? 'active' : '' }}" href="/tecnico/reparaciones">
                                <i class="bi bi-tools me-3 opacity-75"></i> Mis Reparaciones
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link sidebar-link px-4 py-3 {{ request()->routeIs('dispositivos.*') ? 'active' : '' }}" href="/tecnico/dispositivos">
                                <i class="bi bi-phone-fill me-3 opacity-75"></i> Dispositivos
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link sidebar-link px-4 py-3 {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="/tecnico/clientes/">
                                <i class="bi bi-person-vcard-fill me-3 opacity-75"></i> Clientes
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="offcanvas-footer p-3 border-top text-center" style="border-color: #334155 !important; color: #64748b; font-size: 0.8rem;">
                    SoluxMovil Técnico v1.0
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

        // 1. Sincronizar el interruptor (switch) con el estado actual
        const temaActual = html.getAttribute('data-bs-theme');
        if (temaActual === 'dark') {
            switchTema.checked = true;
            actualizarIcono('dark');
        }

        // 2. Evento al hacer clic en todo el bloque del menú
        btnTema.addEventListener('click', function (e) {
            // Evitar que el dropdown se cierre automáticamente al cambiar el tema (opcional)
            e.stopPropagation();

            const nuevoTema = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            
            // Cambiar atributo a Bootstrap
            html.setAttribute('data-bs-theme', nuevoTema);
            // Mover el switch
            switchTema.checked = (nuevoTema === 'dark');
            // Guardar preferencia
            localStorage.setItem('solux_theme', nuevoTema);
            // Actualizar diseño del icono
            actualizarIcono(nuevoTema);
        });

        // 3. Función visual para el icono
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