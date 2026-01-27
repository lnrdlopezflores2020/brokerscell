document.addEventListener('DOMContentLoaded', function () {
    // Intentamos obtener ambos formularios
    const formClientes = document.getElementById('formClientes'); // Asegúrate de agregar id="formClientes" en tu HTML de clientes
    const formUsuarios = document.getElementById('formUsuarios'); // Asegúrate de agregar id="formUsuarios" en tu HTML de usuarios
    // ==========================================
    // LÓGICA PARA FORMULARIO DE CLIENTES
    // ==========================================
    if (formClientes) {
        formClientes.addEventListener('submit', function (event) {
            let esValido = true;

            // 1. Nombre y Apellido (Letras, min 2 chars)
            if (!validarCampo(document.getElementById('nombre'), /^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]{2,50}$/)) esValido = false;
            if (!validarCampo(document.getElementById('apellido'), /^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]{2,50}$/)) esValido = false;

            // 2. Teléfono (10 dígitos exactos)
            if (!validarCampo(document.getElementById('telefono'), /^\d{10}$/)) esValido = false;

            // 3. Dirección y Número Exterior (No vacíos)
            if (!validarNoVacio(document.getElementById('direccion'))) esValido = false;

            // Nota: Usamos los IDs sugeridos 'num_ext' y 'num_int'. Si usas los viejos, cámbialos aquí.
            if (!validarNoVacio(document.getElementById('num_ext'))) esValido = false;

            // 4. Num Interior (Opcional - solo valida si escribieron algo)
            const numIntInput = document.getElementById('num_int');
            if (numIntInput && numIntInput.value.trim() !== '') {
                // Si escribieron algo, validamos que no sean caracteres raros (opcional)
                // Si está vacío, se considera válido porque es opcional.
            }

            // 5. Select de Usuario Vinculado
            // Nota: En el HTML sugerido el ID del select era "Usuario" o "usuario_fk"
            const usuarioSelect = document.getElementById('Usuario') || document.getElementById('usuario_fk');
            if (usuarioSelect && !validarNoVacio(usuarioSelect)) esValido = false;

            if (!esValido) {
                event.preventDefault(); // Detener envío si hay errores
            }
        });
    }

    // ==========================================
    // LÓGICA PARA FORMULARIO DE USUARIOS
    // ==========================================
    if (formUsuarios) {
        formUsuarios.addEventListener('submit', function (event) {
            let esValido = true;

            // 1. Email (Regex estándar de email)
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!validarCampo(document.getElementById('email'), emailRegex)) esValido = false;

            // 2. Rol (Select no vacío)
            if (!validarNoVacio(document.getElementById('rol'))) esValido = false;

            // 3. Validar Contraseña
            const passInput = document.getElementById('password'); // ID sugerido en el HTML mejorado
            const confirmInput = document.getElementById('password_confirmation');

            // Solo validamos contraseña si el campo existe
            if (passInput) {
                // Si el campo tiene el atributo 'required' (crear usuario), no puede estar vacío
                // Si NO tiene 'required' (editar usuario), puede estar vacío
                const esRequerido = passInput.hasAttribute('required');
                const valor = passInput.value;

                if (esRequerido && valor.trim() === '') {
                    marcarInvalido(passInput);
                    esValido = false;
                } else if (valor.trim() !== '' && valor.length < 8) {
                    // Si escribieron algo, debe tener al menos 8 caracteres
                    marcarInvalido(passInput);
                    esValido = false;
                } else {
                    // Si no es requerido y está vacío, es válido (se mantiene la pass vieja)
                    // Si tiene contenido y > 8 chars, es válido
                    marcarValido(passInput);
                }

                // 4. Confirmar Contraseña (deben coincidir si se escribió password)
                if (confirmInput && valor.trim() !== '') {
                    if (valor !== confirmInput.value) {
                        marcarInvalido(confirmInput);
                        // Opcional: Poner mensaje de "No coinciden"
                        esValido = false;
                    } else {
                        marcarValido(confirmInput);
                    }
                }
            }

            if (!esValido) {
                event.preventDefault();
            }
        });
    }


    // ==========================================
    // FUNCIONES AUXILIARES (REUTILIZABLES)
    // ==========================================

    function validarCampo(input, regex) {
        if (!input) return true; // Si el input no existe en este form, lo ignoramos
        const valor = input.value.trim();
        if (regex.test(valor)) {
            marcarValido(input);
            return true;
        } else {
            marcarInvalido(input);
            return false;
        }
    }

    function validarNoVacio(input) {
        if (!input) return true;
        if (input.value.trim() !== '') {
            marcarValido(input);
            return true;
        } else {
            marcarInvalido(input);
            return false;
        }
    }

    function marcarValido(input) {
        if (!input) return;
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    }

    function marcarInvalido(input) {
        if (!input) return;
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    }
});


