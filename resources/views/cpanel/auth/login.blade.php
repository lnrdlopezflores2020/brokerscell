<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | SoluxMovil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" href="/assets/images/SOLUX.png" type="image/png">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-color: #f0f2f5;
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

        body {
            background-color: var(--bg-color);
            background-image: radial-gradient(circle at top right, #e0e7ff 0%, transparent 40%),
                              radial-gradient(circle at bottom left, #dbeafe 0%, transparent 40%);
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
        }

        /* Lado Izquierdo: Imagen orientada a tecnología/reparación */
        .login-image {
            flex: 1.2;
            background-image: url('https://images.unsplash.com/photo-1597740985671-2a8a3b80502e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        /* Capa oscura tipo gradiente sobre la imagen */
        .login-image::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%);
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
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .image-content p {
            font-size: 14px;
            color: #cbd5e1;
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
        }

        .logo-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-container img {
            width: 140px;
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
            padding: 14px 14px 14px 45px; /* Espacio para el icono izquierdo */
            background: var(--input-bg);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-size: 14px;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary-color);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .input-field:focus + i.icon-left,
        .input-field:not(:placeholder-shown) + i.icon-left {
            color: var(--primary-color);
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
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .login-button:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
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
            color: var(--primary-color);
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
    <div class="login-image">
        <div class="image-content">
            <h3>SoluxMovil</h3>
            <p>Sistema integral de gestión técnica. Controla tus reparaciones, clientes y finanzas desde un solo lugar.</p>
        </div>
    </div>
    
    <div class="login-form-container">
        
        <div class="logo-container">
            <img src="/assets/images/SOLUXMOVIL.png" alt="Logo SoluxMovil">
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

        <div class="forgot-password">
            <a href="#">¿Olvidaste tu contraseña?</a>
        </div>
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