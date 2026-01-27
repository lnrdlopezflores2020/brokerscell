<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/style_form.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/style_consulta.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/style.css">
    {{-- Iconos de Bootstrap (necesarios para los tags <i>) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/SOLUXMOVIL.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="/assets/js/sript.js" defer></script>
    <title>@yield("title")</title>
</head>
<body>
<header>
    {{-- Navbar --}}
    <nav class="navbar fixed-top navbar-dark shadow-sm" style="background-color: #00a8e8;">
        <div class="container-fluid">

            <div class="d-flex align-items-center">
                <button class="navbar-toggler me-3 border-0 focus-ring" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a class="navbar-brand fw-bold" href="{{route('tecnico.index')}}">SoluxMovil</a>
            </div>

            <div class="dropdown">
                <a class="navbar-brand m-0 p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- Añadí una transición al hover de la imagen --}}
                    <img src="/assets/images/usuario (1).png" alt="Perfil" width="40" height="40" class="rounded-circle border border-2 border-white">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="{{route('perfilusuario')}}"><i class="bi bi-person me-2"></i>Mi Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST"> @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</button>
                        </form>
                    </li>
                </ul>
            </div>

            <div class="offcanvas offcanvas-start text-white" style="background-color: #007bb5;" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header border-bottom border-white-50">
                    <h5 class="offcanvas-title fw-bold" id="offcanvasNavbarLabel">
                        <i class="bi bi-phone-vibrate me-2"></i>Menú Principal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body p-0">
                    <ul class="navbar-nav justify-content-end flex-grow-1">
                        <li class="nav-item p-2">
                            <a class="nav-link px-3 py-2 rounded {{ request()->routeIs('tecnico.index') ? 'active bg-white bg-opacity-10 fw-bold' : '' }}"
                               href="{{route('tecnico.index')}}">
                                <i class="bi bi-house-door-fill me-3 fs-5"></i> Inicio
                            </a>
                        </li>

                        <li class="nav-item p-2">
                            <a class="nav-link px-3 py-2 rounded {{ request()->routeIs('clientes.*') ? 'active bg-white bg-opacity-10 fw-bold' : '' }}"
                               href="/tecnico/clientes/">
                                <i class="bi bi-person-vcard-fill me-3 fs-5"></i> Clientes
                            </a>
                        </li>

                        <li class="nav-item p-2">
                            <a class="nav-link px-3 py-2 rounded {{ request()->routeIs('dispositivos.*') ? 'active bg-white bg-opacity-10 fw-bold' : '' }}"
                               href="/tecnico/dispositivos">
                                <i class="bi bi-phone-fill me-3 fs-5"></i> Dispositivos
                            </a>
                        </li>

                        <li class="nav-item p-2">
                            <a class="nav-link px-3 py-2 rounded {{ request()->routeIs('reparaciones.*') ? 'active bg-white bg-opacity-10 fw-bold' : '' }}"
                               href="/tecnico/reparaciones">
                                <i class="bi bi-tools me-3 fs-5"></i> Reparaciones
                            </a>
                        </li>

                        <li class="nav-item border-top border-white-50 my-2 mx-3"></li>

                        <li class="nav-item p-2">
                            <a class="nav-link px-3 py-2 rounded {{ request()->routeIs('Actualizar.*') ? 'active bg-white bg-opacity-10 fw-bold' : '' }}"
                               href="/tecnico/Actualizar">
                                <i class="bi bi-arrow-repeat me-3 fs-5"></i> Actualizar Estado
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="offcanvas-footer p-3 border-top border-white-50 text-center text-white-50 small">
                    SoluxMovil System v1.0
                </div>
            </div>
        </div>
    </nav>
</header>

{{-- APLICACIÓN DE LA CLASE DE ANIMACIÓN AL CONTENEDOR PRINCIPAL --}}
<div class="main-panel animate-fade-in" style="margin-top: 80px;">
    <div class="content-wrapper container-fluid px-4">
        @yield('content')
    </div>
</div>

</body>
</html>
