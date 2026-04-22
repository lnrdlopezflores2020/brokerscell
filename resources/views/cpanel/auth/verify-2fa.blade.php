<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Dos Pasos | SoluxMovil</title>
    <link rel="icon" href="/assets/images/SOLUX.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            background-image: radial-gradient(circle at 50% 0%, #e0e7ff 0%, transparent 60%);
        }

        /* Estilos para las casillas del código */
        .code-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .code-input {
            width: 50px;
            height: 60px;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            border: 2px solid #dee2e6;
            border-radius: 12px;
            background-color: #ffffff;
            color: #2563eb;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .code-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
            transform: translateY(-2px);
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
    </style>
</head>
<body class="min-vh-100 d-flex align-items-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="bg-primary" style="height: 6px;"></div>

                <div class="card-body p-5 text-center">

                    <div class="mb-4 d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary" style="width: 80px; height: 80px;">
                        <i class="bi bi-shield-lock-fill" style="font-size: 2.5rem;"></i>
                    </div>

                    <h4 class="fw-bold text-dark mb-2">Autenticación</h4>
                    <p class="text-muted small mb-4">
                        Hemos enviado un código de 6 dígitos a tu correo electrónico. Ingrésalo a continuación.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 text-start small border-0 bg-danger bg-opacity-10 text-danger rounded-3 mb-4">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('2fa.confirmar') }}" method="POST" id="twoFactorForm">
                        @csrf
                        
                        <input type="hidden" name="codigo" id="codigo_hidden" required>

                        <div class="code-container" id="inputsContainer">
                            <input type="number" class="code-input" maxlength="1" autofocus>
                            <input type="number" class="code-input" maxlength="1">
                            <input type="number" class="code-input" maxlength="1">
                            <input type="number" class="code-input" maxlength="1">
                            <input type="number" class="code-input" maxlength="1">
                            <input type="number" class="code-input" maxlength="1">
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold shadow-sm" id="submitBtn">
                                Verificar Acceso <i class="bi bi-arrow-right-short fs-5 align-middle"></i>
                            </button>
                        </div>
                    </form>

                    <div class="text-center mb-4">
                        <p class="text-muted small mb-1">¿No recibiste el código?</p>
                        <a href="#" class="text-primary text-decoration-none fw-semibold small">Reenviar código</a>
                    </div>

                    <hr class="opacity-10 my-4">

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted text-decoration-none btn-sm fw-medium">
                            <i class="bi bi-arrow-left me-1"></i> Volver al inicio
                        </button>
                    </form>

                </div>
            </div>

            <div class="text-center mt-4 text-muted small fw-medium">
                <i class="bi bi-lock-fill me-1 text-success"></i> Conexión Segura SSL
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
                if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
                    nextInput.removeAttribute("disabled");
                    nextInput.focus();
                }

                if (e.key === "Backspace") {
                    // Retroceder al borrar
                    inputs.forEach((input, index2) => {
                        if (index <= index2 && prevInput) {
                            input.setAttribute("disabled", true);
                            input.value = "";
                            prevInput.focus();
                        }
                    });
                } else if (currentInput.value !== "" && nextInput) {
                    // Avanzar normalmente
                    nextInput.removeAttribute("disabled");
                    nextInput.focus();
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
