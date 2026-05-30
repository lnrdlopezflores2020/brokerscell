<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Dos Pasos | Brokerscell</title>
    <link rel="icon" href="/assets/images/brokerscell.jpeg" type="image/jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --brand-purple: #6f42c1;
            --brand-red: #dc3545;
            --brand-blue: #0d6efd;
            --brand-green: #198754;
            --brand-dark: #0f172a;
        }

        body {
            font-family: 'Poppins', sans-serif;
            /* Fondo oscuro profundo para hacer resaltar la tarjeta */
            background: linear-gradient(135deg, var(--brand-dark) 0%, #2d1b4e 100%);
            min-height: 100vh;
        }

        /* Barra de colores de la marca */
        .color-bar {
            height: 6px;
            background: linear-gradient(90deg, var(--brand-purple) 0%, var(--brand-blue) 33%, var(--brand-green) 66%, var(--brand-red) 100%);
        }

        /* Estilos del Botón Principal */
        .btn-brand {
            background-color: var(--brand-purple);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-brand:hover {
            background-color: #59339d;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(111, 66, 193, 0.3);
        }

        /* Estilos completamente nuevos para las casillas del código */
        .code-container {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-bottom: 2rem;
            direction: ltr;
        }

        .code-input {
            width: 55px;
            height: 65px;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            border: none;
            border-bottom: 4px solid #e2e8f0;
            border-radius: 8px 8px 0 0;
            background-color: #f8fafc;
            color: var(--brand-purple);
            transition: all 0.3s ease;
            box-shadow: inset 0 -2px 0 transparent; /* Preparar para la transición */
        }

        .code-input:focus {
            outline: none;
            background-color: #f3f0ff;
            border-bottom-color: var(--brand-purple);
        }

        /* Truco visual: si tiene texto (no muestra el placeholder), se pone verde */
        .code-input:not(:placeholder-shown) {
            border-bottom-color: var(--brand-green);
        }

        /* Ocultar flechas del input number */
        .code-input::-webkit-outer-spin-button,
        .code-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .code-input[type=number] {
            -moz-appearance: textfield;
        }

        /* Enlace de retroceso */
        .back-link {
            color: #94a3b8;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: white;
        }
    </style>
</head>
<body class="d-flex align-items-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                {{-- Integración de los 4 colores en la barra superior --}}
                <div class="color-bar"></div>

                <div class="card-body p-5 p-sm-5 text-center bg-white">

                    {{-- Icono central --}}
                    <div class="mb-4 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background-color: #f3f0ff; color: var(--brand-purple);">
                        <i class="bi bi-fingerprint" style="font-size: 3rem;"></i>
                    </div>

                    <h3 class="fw-bold text-dark mb-2">Verificación de Seguridad</h3>
                    <p class="text-secondary small mb-4 px-2">
                        Para proteger tu cuenta en <strong>Brokerscell</strong>, hemos enviado un código de 6 dígitos a tu correo electrónico.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 text-center small border-0 bg-danger bg-opacity-10 text-danger rounded-3 mb-4 fw-medium">
                            <i class="bi bi-shield-x me-2"></i>{{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('2fa.confirmar') }}" method="POST" id="twoFactorForm">
                        @csrf
                        
                        <input type="hidden" name="codigo" id="codigo_hidden" required>

                        <div class="code-container" id="inputsContainer">
                            {{-- Agregado placeholder=" " (espacio en blanco) para activar el selector :not(:placeholder-shown) de CSS --}}
                            <input type="number" class="code-input" maxlength="1" placeholder=" " autofocus>
                            <input type="number" class="code-input" maxlength="1" placeholder=" " disabled>
                            <input type="number" class="code-input" maxlength="1" placeholder=" " disabled>
                            <input type="number" class="code-input" maxlength="1" placeholder=" " disabled>
                            <input type="number" class="code-input" maxlength="1" placeholder=" " disabled>
                            <input type="number" class="code-input" maxlength="1" placeholder=" " disabled>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-brand btn-lg rounded-pill fw-bold shadow-sm" id="submitBtn">
                                Validar Acceso <i class="bi bi-unlock-fill ms-2"></i>
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-2">
                        <p class="text-muted small mb-1">¿El código no llega?</p>
                        <a href="#" class="text-decoration-none fw-bold small" style="color: var(--brand-blue);">
                            <i class="bi bi-arrow-clockwise me-1"></i> Solicitar un nuevo código
                        </a>
                    </div>

                </div>
            </div>

            {{-- Controles fuera de la tarjeta para un aspecto más limpio --}}
            <div class="text-center">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link back-link text-decoration-none btn-sm fw-medium">
                        <i class="bi bi-arrow-left-circle me-1"></i> Cancelar y volver al inicio
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputs = document.querySelectorAll(".code-input");
        const hiddenInput = document.getElementById("codigo_hidden");
        const form = document.getElementById("twoFactorForm");

        inputs.forEach((input, index) => {
            // Manejar entrada de teclado
            input.addEventListener("keyup", function(e) {
                const currentInput = input;
                const nextInput = input.nextElementSibling;
                const prevInput = input.previousElementSibling;

                // Si el valor es mayor a 1 caracter (previene bugs rápidos), dejar solo el último
                if (currentInput.value.length > 1) {
                    currentInput.value = currentInput.value.slice(-1);
                }

                // Avanzar al siguiente si se escribió un número
                if (nextInput && currentInput.value !== "") {
                    nextInput.removeAttribute("disabled");
                    nextInput.focus();
                }

                if (e.key === "Backspace") {
                    // Retroceder al borrar
                    inputs.forEach((input, index2) => {
                        if (index <= index2 && prevInput) {
                            if (index2 > index) {
                                input.setAttribute("disabled", true);
                            }
                            input.value = "";
                            prevInput.focus();
                        }
                    });
                }
                
                updateHiddenInput();
            });

            // Permitir pegar el código de 6 dígitos de una vez
            input.addEventListener("paste", function(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData("text").slice(0, 6).replace(/[^0-9]/g, '');
                
                if (pastedData) {
                    for (let i = 0; i < pastedData.length; i++) {
                        if (inputs[i]) {
                            inputs[i].value = pastedData[i];
                            inputs[i].removeAttribute("disabled");
                            if (inputs[i+1]) inputs[i+1].focus();
                        }
                    }
                    updateHiddenInput();
                }
            });
        });

        // Actualizar el valor del input oculto que va al servidor
        function updateHiddenInput() {
            let code = "";
            inputs.forEach(input => {
                code += input.value;
            });
            hiddenInput.value = code;
        }

        // Prevenir envío si no están los 6 dígitos
        form.addEventListener("submit", function(e) {
            updateHiddenInput();
            if (hiddenInput.value.length !== 6) {
                e.preventDefault();
                alert("Por favor ingresa el código completo de 6 dígitos.");
            }
        });
    });
</script>

</body>
</html>