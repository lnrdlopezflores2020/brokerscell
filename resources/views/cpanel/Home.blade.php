<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoluxMovil - Taller de Reparación</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="icon" href="/assets/images/SOLUXMOVIL.png" type="image/png">

    <style>
        /* Estilos personalizados mínimos para complementar Bootstrap */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/assets/images/HOME.png');

            /* CAMBIO CLAVE: Usar 'contain' en lugar de 'cover' */
            background-size: contain;

            /* Evita que la imagen se repita como mosaico si sobra espacio */
            background-repeat: no-repeat;

            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;

            /* Opcional: Color de fondo para rellenar los huecos que deje la imagen */
            background-color: #000;
        }
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            border-radius: 50%;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4 text-primary" href="#">
            Solux<span class="text-dark">Movil</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#servicios">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contacto">Contacto</a>
                </li>
                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <a href="/login" class="btn btn-primary px-4 rounded-pill shadow-sm">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="hero-section text-center text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-3 fw-bold mb-4">Reparamos lo que te importa</h1>
                <p class="lead mb-5 text-light opacity-75">
                    Especialistas en hardware, software y recuperación de datos. Servicio rápido, garantizado y profesional.
                </p>
            </div>
        </div>
    </div>
</header>

<section id="servicios" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-6">Nuestros Servicios</h2>
            <p class="text-muted">Soluciones integrales para todos tus dispositivos.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm service-card bg-light">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                            <i class="bi bi-motherboard"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Reparación de Hardware</h3>
                        <p class="text-muted">Cambio de pantallas, baterías, teclados y componentes internos de laptops y PCs con refacciones originales.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm service-card bg-light">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-success bg-opacity-10 text-success mx-auto mb-3">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Software y Virus</h3>
                        <p class="text-muted">Limpieza profunda de virus, optimización del sistema operativo e instalación de programas esenciales.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm service-card bg-light">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-info bg-opacity-10 text-info mx-auto mb-3">
                            <i class="bi bi-tools"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Mantenimiento Preventivo</h3>
                        <p class="text-muted">Limpieza interna profunda y cambio de pasta térmica de alta calidad para evitar sobrecalentamiento.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer id="contacto" class="bg-dark text-white py-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold text-primary mb-3">SoluxMovil</h5>
                <p class="text-white-50 small">Tu taller de confianza desde 2015. Nos dedicamos a devolverle la vida a tus equipos con honestidad y calidad.</p>
            </div>

            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3">Contacto</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2"><i class="bi bi-geo-alt-fill me-2 text-primary"></i> Av. Benito Juarez #11, San Baltazar Temaxcalac</li>
                    <li class="mb-2"><i class="bi bi-telephone-fill me-2 text-primary"></i> (248) 266-0871</li>
                    <li class="mb-2"><i class="bi bi-telephone-fill me-2 text-primary"></i> (56) 1023-9500</li>
                    <li><i class="bi bi-envelope-fill me-2 text-primary"></i> soluxmovil@gmail.com</li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h5 class="fw-bold mb-3">Horario</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="d-flex justify-content-between mb-2">
                        <span>Lunes - Viernes:</span>
                        <span>9:00 AM - 8:00 PM</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>Sáb - Dom:</span>
                        <span>11:00 AM - 8:00 PM</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-top border-secondary mt-5 pt-4 text-center text-white-50 small">
            &copy; 2025 SoluxMovil. Todos los derechos reservados.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
