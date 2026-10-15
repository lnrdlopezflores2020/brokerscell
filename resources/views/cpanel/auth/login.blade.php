<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Brokerscell</title>
    <link rel="icon" href="/assets/images/brokerscell.jpeg" type="image/jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" href="/assets/images/BROKERSCELL.png" type="image/png">
    
    <style>
        :root {
            /* Paleta Brokerscell */
            --brand-purple: #6f42c1;
            --brand-red: #dc3545;
            --brand-blue: #0d6efd;
            --brand-green: #198754;
            --primary-hover: #59339d;
            
            /* Colores de UI */
            --bg-color: #f4f7f6;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --input-bg: #f8fafc;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Contenedor externo para centrar */
        .logo-wrapper {
            text-align: center;
            margin-bottom: 25px;
        }

        /* Degradado circular (Resplandor) detrás de la imagen */
        .logo-container {
            display: inline-block;
            position: relative;
            padding: 15px; /* Espacio para que se vea el resplandor */
            border-radius: 50%;
            /* Degradado radial usando los colores de tu marca */
            background: radial-gradient(circle at center, rgba(111, 66, 193, 0.25) 0%, rgba(13, 110, 253, 0.1) 50%, transparent 100%);
        }

        /* Estilos para hacer la imagen redonda y elegante */
        .logo-container img {
            width: 140px;
            height: 140px; /* Altura igual al ancho para un círculo perfecto */
            object-fit: cover; /* Evita que la imagen se deforme */
            border-radius: 50%; /* Recorta el JPEG en un círculo */
            background-color: #ffffff; /* Fondo blanco de apoyo */
            border: 3px solid #ffffff; /* Borde blanco para separarlo del resplandor */
            box-shadow: 0 8px 20px rgba(111, 66, 193, 0.15); /* Sombra morada sutil */
            transition: transform 0.3s ease;
        }

        /* Pequeña animación al pasar el mouse (opcional) */
        .logo-container img:hover {
            transform: scale(1.05);
        }

        body {
            background-color: var(--bg-color);
            /* Fondo con destellos sutiles morados y azules */
            background-image: radial-gradient(circle at top right, rgba(111, 66, 193, 0.1) 0%, transparent 40%),
                              radial-gradient(circle at bottom left, rgba(13, 110, 253, 0.1) 0%, transparent 40%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Contenedor principal estilo tarjeta */
        .login-wrapper {
            background-color: #fff;
            width: 950px;
            max-width: 100%;
            min-height: 580px;
            display: flex;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
        }

        /* Barra superior con los 4 colores de la marca */
        .color-bar {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--brand-purple) 0%, var(--brand-blue) 33%, var(--brand-green) 66%, var(--brand-red) 100%);
            z-index: 10;
        }

        /* Lado Izquierdo: Imagen orientada a tecnología/reparación */
        .login-image {
            flex: 1.2;
            background-image: url('https://images.unsplash.com/photo-1597740985671-2a8a3b80502e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        /* Capa oscura tipo gradiente sobre la imagen (Morado a Azul) */
        .login-image::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(111, 66, 193, 0.85) 0%, rgba(13, 110, 253, 0.85) 100%);
        }

        /* Texto sobre la imagen */
        .image-content {
            position: absolute;
            bottom: 40px;
            left: 40px;
            right: 40px;
            color: white;
            z-index: 1;
        }

        .image-content h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .image-content p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }

        /* Lado Derecho: Formulario */
        .login-form-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px 60px;
            background: #ffffff;
            position: relative;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-container img {
            width: 160px;
            height: auto;
        }

        .login-header {
            margin-bottom: 35px;
            text-align: center;
        }

        .login-header h2 {
            font-size: 26px;
            color: var(--text-dark);
            font-weight: 700;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 5px;
        }

        /* Estilos de los Inputs con Iconos */
        .form-group {
            margin-bottom: 22px;
            position: relative;
        }

        .form-group i.icon-left {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .input-field {
            width: 100%;
            padding: 14px 14px 14px 45px;
            background: var(--input-bg);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-size: 14px;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--brand-purple);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(111, 66, 193, 0.1);
        }

        .input-field:focus + i.icon-left,
        .input-field:not(:placeholder-shown) + i.icon-left {
            color: var(--brand-purple);
        }

        /* Botón de mostrar/ocultar contraseña */
        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: var(--text-dark);
        }

        /* Estilo del Botón */
        .login-button {
            width: 100%;
            padding: 14px;
            background-color: var(--brand-purple);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(111, 66, 193, 0.2);
        }

        .login-button:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(111, 66, 193, 0.3);
        }

        .login-button:active {
            transform: translateY(1px);
        }

        /* Enlaces y Errores */
        .forgot-password {
            text-align: center;
            margin-top: 25px;
        }

        .forgot-password a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: var(--brand-purple);
        }

        .alert-error {
            background-color: #fef2f2;
            color: #b91c1c;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            border: 1px solid #fecaca;
        }

        .alert-error i {
            margin-right: 10px;
            font-size: 16px;
        }

        /* Responsive */
        @media (max-width: 850px) {
            .login-wrapper {
                flex-direction: column;
                min-height: auto;
            }
            .login-image {
                display: none;
            }
            .login-form-container {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <!-- Barra decorativa con los colores de Brokerscell -->
    <div class="color-bar"></div>

    <div class="login-image">
        <div class="image-content">
            <h3>Brokerscell</h3>
            <p>Sistema integral de gestión técnica.</p>
        </div>
    </div>
    
    <div class="login-form-container">
        
        <div class="logo-wrapper">
            <div class="logo-container">
                <img src="/assets/images/brokerscell.jpeg" alt="Logo Brokerscell">
            </div>
        </div>

        <div class="login-header">
            <h2>Bienvenido de nuevo</h2>
            <p>Ingresa tus credenciales para acceder a tu panel</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{route('login.validate')}}" method="POST">
            @csrf

            <div class="form-group">
                <input type="email" class="input-field" placeholder="Correo electrónico" name="email" required autofocus>
                <i class="bi bi-envelope icon-left"></i>
            </div>

            <div class="form-group">
                <input type="password" class="input-field" placeholder="Contraseña" name="password" id="passwordField" required>
                <i class="bi bi-lock icon-left"></i>
                <i class="bi bi-eye-slash toggle-password" id="togglePassword" title="Mostrar contraseña"></i>
            </div>

            <button type="submit" class="login-button">Iniciar sesión</button>
        </form>
    </div>
</div>

<script>
    // Script para alternar la visibilidad de la contraseña
    const togglePassword = document.querySelector('#togglePassword');
    const passwordField = document.querySelector('#passwordField');

    togglePassword.addEventListener('click', function (e) {
        // Alternar el tipo de input
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        // Alternar el icono
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>