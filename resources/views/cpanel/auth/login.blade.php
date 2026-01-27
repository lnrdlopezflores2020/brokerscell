<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | SoluxMovil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" href="/assets/images/SOLUXMOVIL.png" type="image/png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f6f9; /* Color de fondo suave */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Contenedor principal estilo tarjeta */
        .login-wrapper {
            background-color: #fff;
            width: 900px;
            max-width: 90%;
            height: 550px;
            display: flex; /* Aquí ocurre la magia de dividir en dos */
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden; /* Para que la imagen respete los bordes redondeados */
        }

        /* Lado Izquierdo: Imagen */
        .login-image {
            flex: 1; /* Ocupa el 50% */
            /* Cambia esta URL por tu imagen de branding o una de tu carpeta assets */
            background-image: url('https://images.unsplash.com/photo-1497215728101-856f4ea42174?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        /* Capa oscura sobre la imagen (opcional para dar contraste) */
        .login-image::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.1));
        }

        /* Lado Derecho: Formulario */
        .login-form-container {
            flex: 1; /* Ocupa el otro 50% */
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px;
        }

        .login-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .login-header h2 {
            font-size: 28px;
            color: #333;
            font-weight: 600;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Estilos de los Inputs */
        .form-group {
            margin-bottom: 20px;
        }

        .input-field {
            width: 100%;
            padding: 15px;
            background: #f7f9fc;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: #4a90e2; /* Color de acento */
            background: #fff;
            box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.1);
        }

        /* Estilo del Botón */
        .login-button {
            width: 100%;
            padding: 15px;
            background-color: #2563eb; /* Azul corporativo */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .login-button:hover {
            background-color: #1d4ed8;
        }

        /* Enlaces y Errores */
        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: #666;
            text-decoration: none;
            font-size: 13px;
        }

        .forgot-password a:hover {
            color: #2563eb;
            text-decoration: underline;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #fecaca;
        }

        /* Responsive: En móviles la imagen desaparece o se va arriba */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                height: auto;
            }
            .login-image {
                display: none; /* Ocultamos la imagen en pantallas muy pequeñas */
            }
            .login-form-container {
                padding: 40px 25px;
            }
        }

    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-image"></div>
    <div class="login-form-container">
        <div class="login-header">
            <h2>Bienvenido</h2>
            <p>Ingresa tus credenciales para acceder</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }} </div>
        @endif

        <form action="{{route('login.validate')}}" method="POST">
            @csrf

            <div class="form-group">
                <input type="email" class="input-field" placeholder="Correo electrónico" name="email" required autofocus>
            </div>

            <div class="form-group">
                <input type="password" class="input-field" placeholder="Contraseña" name="password" required>
            </div>

            <button type="submit" class="login-button">Iniciar sesión</button>
        </form>

        <div class="forgot-password">
            <a href="#">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>
</body>
</html>
