<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoluxMovil - Taller de Reparación</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="icon" href="/assets/images/SOLUXMOVIL.png" type="image/png">

    <style>
        /* Smooth scrolling global */
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            overflow-x: hidden;
        }

        /* Navbar con efecto Glassmorphism al hacer scroll */
        .navbar {
            transition: all 0.4s ease;
            background-color: transparent !important;
            padding: 20px 0;
        }

        .navbar.scrolled {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            padding: 10px 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
        }

        .navbar-dark-text .nav-link, 
        .navbar-dark-text .navbar-brand {
            color: #ffffff !important;
        }

        .navbar.scrolled .nav-link {
            color: #333333 !important;
        }
        
        .navbar.scrolled .navbar-brand {
            color: #0d6efd !important; /* Primary color */
        }

        .navbar.scrolled .navbar-brand span {
            color: #212529 !important;
        }

        /* Hero Section con animación sutil de fondo */
        .hero-section {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(37, 99, 235, 0.7) 100%), url('/assets/images/HOME.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Efecto Parallax */
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
        }

        /* Tarjetas de Servicio con alto contraste y fluidez */
        .service-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05) !important;
        }

        .service-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
            border-color: rgba(13, 110, 253, 0.3) !important;
        }

        .icon-box {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            border-radius: 20px;
            transition: transform 0.3s ease;
        }

        .service-card:hover .icon-box {
            transform: scale(1.1) rotate(5deg);
        }

        /* Botón flotante WhatsApp */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 0 4px 10px rgba(37, 211, 102, 0.4);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            color: white;
            box-shadow: 0 6px 15px rgba(37, 211, 102, 0.6);
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg fixed-top navbar-dark-text" id="mainNav">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4 text-white" href="#">
            Solux<span class="text-light">Movil</span>
        </a>
        <button class="navbar-toggler bg-primary border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center fw-medium">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#servicios">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contacto">Contacto</a>
                </li>
                <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                    <a href="/login" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm fw-bold">
                        <i class="bi bi-person-circle me-2"></i>Iniciar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="hero-section text-center text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="display-3 fw-bold mb-4 tracking-tight">Reparamos lo que te importa</h1>
                <p class="lead mb-5 text-light opacity-75 fw-light px-md-5">
                    Especialistas en hardware, software y recuperación de datos. Devolvemos la vida a tus dispositivos con un servicio rápido, garantizado y profesional.
                </p>
                <div data-aos="zoom-in" data-aos-delay="300">
                    <a href="#servicios" class="btn btn-light btn-lg px-5 py-3 rounded-pill text-primary fw-bold shadow-lg me-3 mb-3 mb-md-0">
                        Nuestros Servicios
                    </a>
                    <a href="#contacto" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold mb-3 mb-md-0">
                        Contáctanos
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<section id="servicios" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-down">
            <h2 class="fw-bold display-5 text-dark mb-3">Nuestros Servicios</h2>
            <div class="bg-primary mx-auto rounded" style="width: 60px; height: 4px;"></div>
            <p class="text-muted mt-4 fs-5">Soluciones integrales de alta tecnología para todos tus equipos.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm service-card bg-white">
                    <div class="card-body p-5 text-center">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary mx-auto mb-4">
                            <i class="bi bi-motherboard"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3 text-dark">Reparación de Hardware</h3>
                        <p class="text-muted">Cambio de pantallas, baterías, teclados y reparación a nivel microcomponente con refacciones 100% originales y garantizadas.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm service-card bg-white">
                    <div class="card-body p-5 text-center">
                        <div class="icon-box bg-success bg-opacity-10 text-success mx-auto mb-4">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3 text-dark">Software y Seguridad</h3>
                        <p class="text-muted">Eliminación profunda de malware, instalación de sistemas operativos, flasheos, desbloqueos y recuperación de información perdida.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                <div class="card h-100 border-0 shadow-sm service-card bg-white">
                    <div class="card-body p-5 text-center">
                        <div class="icon-box bg-info bg-opacity-10 text-info mx-auto mb-4">
                            <i class="bi bi-tools"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3 text-dark">Mantenimiento Preventivo</h3>
                        <p class="text-muted">Limpieza interna con ultrasonido, cambio de pasta térmica de alto rendimiento y ajustes para maximizar la vida útil de tu dispositivo.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<a href="https://wa.me/5212482660871" class="whatsapp-float" target="_blank" title="Contáctanos por WhatsApp" data-aos="zoom-in" data-aos-offset="0">
    <i class="bi bi-whatsapp"></i>
</a>

<footer id="contacto" class="bg-dark text-white pt-5 pb-3">
    <div class="container pt-4">
        <div class="row gy-4 mb-5">
            <div class="col-lg-4 col-md-6" data-aos="fade-right">
                <h4 class="fw-bold text-primary mb-4">Solux<span class="text-white">Movil</span></h4>
                <p class="text-white-50 pe-md-4">
                    Tu centro de soluciones tecnológicas. Nos dedicamos a devolverle la vida a tus equipos con honestidad, rapidez y máxima calidad.
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="text-white opacity-75 fs-4"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white opacity-75 fs-4"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white opacity-75 fs-4"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <h5 class="fw-bold mb-4 text-uppercase tracking-wider fs-6 text-white-50">Contacto Directo</h5>
                <ul class="list-unstyled text-white">
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-geo-alt-fill fs-5 text-primary me-3"></i> 
                        <span>Av. Benito Juárez #11, <br> San Baltazar Temaxcalac</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-telephone-fill fs-5 text-primary me-3"></i> 
                        <span>(248) 266-0871</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-envelope-fill fs-5 text-primary me-3"></i> 
                        <span>soluxmovil@gmail.com</span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12" data-aos="fade-left" data-aos-delay="400">
                <h5 class="fw-bold mb-4 text-uppercase tracking-wider fs-6 text-white-50">Horario de Atención</h5>
                <div class="bg-white bg-opacity-10 p-4 rounded-4">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between mb-3 border-bottom border-secondary pb-2">
                            <span class="fw-medium">Lunes - Viernes:</span>
                            <span class="text-info fw-bold">9:00 AM - 8:00 PM</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span class="fw-medium">Sábados - Domingos:</span>
                            <span class="text-info fw-bold">11:00 AM - 8:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border-top border-secondary pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center text-white-50 small">
            <p class="mb-2 mb-md-0">&copy; {{ date('Y') }} SoluxMovil. Todos los derechos reservados.</p>
            
            <button type="button" class="btn btn-link text-white-50 text-decoration-none small p-0" data-bs-toggle="modal" data-bs-target="#privacidadModal">
                Aviso de Privacidad
            </button>
        </div>
    </div>
</footer>

<div class="modal fade" id="privacidadModal" tabindex="-1" aria-labelledby="privacidadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark fs-4" id="privacidadModalLabel">
                    <i class="bi bi-shield-lock text-primary me-2"></i>Aviso de Privacidad
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-4 text-secondary">
                <p>En <strong>SoluxMovil</strong>, valoramos su privacidad y nos comprometemos a proteger sus datos personales en estricto apego a la legislación vigente.</p>
                
                <h6 class="fw-bold text-dark mt-4">1. Recopilación de Datos</h6>
                <p>Los datos solicitados (nombre, teléfono, correo y detalles del equipo) son recabados única y exclusivamente con la finalidad de gestionar la reparación, mantenimiento o servicio técnico de su dispositivo.</p>

                <h6 class="fw-bold text-dark mt-4">2. Privacidad de la Información del Dispositivo</h6>
                <p>Nuestros técnicos tienen estrictamente prohibido acceder a galerías de fotos, redes sociales, mensajes, correos electrónicos o cualquier información personal almacenada en el dispositivo del cliente, a menos que el servicio solicitado requiera recuperación de datos y el cliente brinde su consentimiento explícito.</p>

                <h6 class="fw-bold text-dark mt-4">3. Uso de la Información</h6>
                <p>La información de contacto se utilizará para:</p>
                <ul>
                    <li>Notificar cambios en el estado de la reparación.</li>
                    <li>Enviar notas de remisión o entrega.</li>
                    <li>Contactar en caso de requerir autorización para refacciones adicionales.</li>
                </ul>

                <h6 class="fw-bold text-dark mt-4">4. Protección y Resguardo</h6>
                <p>Implementamos medidas de seguridad físicas y digitales en nuestros sistemas administrativos para prevenir el acceso no autorizado, alteración o destrucción de su información.</p>

                <p class="mt-4 mb-0 fst-italic small text-muted text-center">
                    Última actualización: Abril 2026. <br>
                    Para cualquier duda respecto a este aviso, contáctenos en soluxmovil@gmail.com
                </p>
            </div>
            <div class="modal-footer bg-light border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold w-100" data-bs-dismiss="modal">Comprendido y Aceptado</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Inicializar Animaciones AOS
    AOS.init({
        once: true, // La animación solo ocurre una vez al hacer scroll
        offset: 50,  // Offset (en px) desde el elemento original para disparar la animación
    });

    // Script para el efecto de la Navbar al hacer scroll
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNav');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
            navbar.classList.remove('navbar-dark-text');
        } else {
            navbar.classList.remove('scrolled');
            navbar.classList.add('navbar-dark-text');
        }
    });
</script>

</body>
</html>