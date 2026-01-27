<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Dos Pasos</title>
    <link rel="icon" href="/assets/images/SOLUXMOVIL.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    <div class="card-header bg-primary text-white text-center py-3 border-0">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-shield-lock-fill me-2"></i>Seguridad
                        </h5>
                    </div>

                    <div class="card-body p-5 text-center">

                        <div class="mb-4 d-inline-block p-3 rounded-circle bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-envelope-check-fill" style="font-size: 2.5rem;"></i>
                        </div>

                        <h4 class="fw-bold text-dark mb-2">Verificación en 2 Pasos</h4>
                        <p class="text-muted small mb-4">
                            Ingresa el código de 6 dígitos que enviamos a tu correo electrónico para continuar.
                        </p>

                        <form action="{{ route('2fa.confirmar') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="codigo" class="visually-hidden">Código de seguridad</label>
                                <input type="text"
                                       id="codigo"
                                       name="codigo"
                                       class="form-control form-control-lg text-center fw-bold text-primary border-2"
                                       placeholder="######"
                                       maxlength="6"
                                       required
                                       autofocus
                                       autocomplete="off"
                                       style="letter-spacing: 0.8rem; font-size: 1.5rem; background-color: #f8f9fa;"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                                    Verificar Acceso <i class="bi bi-arrow-right-short"></i>
                                </button>
                            </div>
                        </form>

                        <div class="text-center mb-4">
                            <p class="text-muted small mb-0">¿No recibiste el código?</p>
                            <a href="#" class="text-decoration-none fw-bold small">Reenviar código</a>
                        </div>

                        <hr class="opacity-25 my-4">

                        <form action="#" method="POST">
                            <button type="submit" class="btn btn-link text-secondary text-decoration-none btn-sm">
                                <i class="bi bi-box-arrow-left me-1"></i> Cancelar y volver al inicio
                            </button>
                        </form>

                    </div>
                </div>

                <div class="text-center mt-4 text-muted small">
                    <i class="bi bi-lock-fill me-1"></i> Conexión Segura SSL
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
