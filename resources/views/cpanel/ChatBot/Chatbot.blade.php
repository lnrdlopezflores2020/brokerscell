@extends('cpanel/plantillaClientes')
@section('title', 'Soporte')
@section('title', 'Asistente Virtual')

@section('content')
<div class="container-fluid py-4 h-100">
    <div class="row justify-content-center h-100">
        <div class="col-lg-8 col-xl-7 d-flex flex-column" style="height: calc(100vh - 120px);">
            
            {{-- ENCABEZADO DEL CHAT --}}
            <div class="card shadow-sm border-0 rounded-top-4 bg-body z-1">
                <div style="height: 6px; background: linear-gradient(90deg, var(--brand-purple, #6f42c1), var(--brand-blue, #0d6efd));"></div>
                <div class="card-body p-3 px-4 d-flex align-items-center">
                    <div class="position-relative me-3">
                        <div class="bg-brand-purple bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: rgba(111, 66, 193, 0.1);">
                            <i class="bi bi-robot fs-3" style="color: #6f42c1;"></i>
                        </div>
                        <span class="position-absolute bottom-0 start-100 translate-middle p-1 bg-success border border-2 border-body rounded-circle"></span>
                    </div>
                    <div>
                        <h5 class="fw-bold text-body m-0">Asistente Brokerscell</h5>
                        <p class="text-secondary small m-0">Respuestas rápidas sobre costos y servicios</p>
                    </div>
                </div>
            </div>

            {{-- ÁREA DE MENSAJES (HISTORIAL) --}}
            <div class="card shadow-sm border-0 rounded-0 bg-body-tertiary flex-grow-1 overflow-auto p-4" id="chatContainer">
                
                {{-- Mensaje de bienvenida del Bot --}}
                <div class="d-flex mb-4">
                    <div class="bg-white border shadow-sm rounded-4 rounded-top-0 p-3" style="max-width: 80%;">
                        <p class="m-0 text-body" style="font-size: 0.95rem;">
                            ¡Hola, {{ auth()->user()->name ?? 'cliente' }}! 👋 Soy el asistente virtual de Brokerscell.<br><br>
                            Para garantizar total transparencia, puedo informarte sobre los costos estimados de nuestras reparaciones más comunes o explicarte en qué consiste cada servicio.<br><br>
                            ¿En qué te puedo ayudar hoy?
                        </p>
                    </div>
                </div>

            </div>

            {{-- ÁREA DE INPUT --}}
            <div class="card shadow-sm border-0 rounded-bottom-4 bg-body z-1">
                <div class="card-body p-3">
                    <form id="chatForm" class="d-flex align-items-center gap-2">
                        @csrf
                        <input type="text" id="userInput" class="form-control border-secondary-subtle rounded-pill px-4 py-2 bg-body-tertiary focus-ring-purple" placeholder="Escribe tu pregunta aquí (Ej: ¿Cuánto cuesta cambiar pantalla?)..." required autocomplete="off">
                        <button type="submit" id="sendBtn" class="btn rounded-circle shadow-sm d-flex align-items-center justify-content-center transition-all" style="width: 45px; height: 45px; background-color: #6f42c1; color: white; border: none;">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Efecto de foco para el input */
    .focus-ring-purple:focus {
        border-color: #6f42c1 !important;
        box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.15) !important;
        background-color: var(--bs-body-bg) !important;
    }
    
    .transition-all:hover {
        transform: scale(1.05);
        background-color: #5a32a3 !important;
    }

    /* Animación de "Escribiendo" */
    .typing-dot {
        display: inline-block;
        width: 6px;
        height: 6px;
        background-color: #94a3b8;
        border-radius: 50%;
        margin: 0 2px;
        animation: typing 1.4s infinite ease-in-out both;
    }
    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }
    @keyframes typing {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatForm = document.getElementById('chatForm');
        const chatContainer = document.getElementById('chatContainer');
        const userInput = document.getElementById('userInput');
        const sendBtn = document.getElementById('sendBtn');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        chatForm.addEventListener('submit', async function(e) {
            e.preventDefault(); // Evita que la página se recargue

            const texto = userInput.value.trim();
            if(texto === '') return;

            // 1. Mostrar mensaje del cliente (Alineado a la derecha, color morado)
            chatContainer.innerHTML += `
                <div class="d-flex mb-4 justify-content-end">
                    <div class="text-white shadow-sm rounded-4 rounded-top-0 p-3" style="max-width: 80%; background-color: #6f42c1;">
                        <p class="m-0" style="font-size: 0.95rem;">${texto}</p>
                    </div>
                </div>
            `;
            
            userInput.value = '';
            userInput.disabled = true;
            sendBtn.disabled = true;
            hacerScrollAbajo();

            // 2. Mostrar indicador de "Escribiendo..."
            const typingId = 'typing-' + Date.now();
            chatContainer.innerHTML += `
                <div class="d-flex mb-4" id="${typingId}">
                    <div class="bg-white border shadow-sm rounded-4 rounded-top-0 p-3 d-flex align-items-center gap-1" style="max-width: 80%; height: 42px;">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                </div>
            `;
            hacerScrollAbajo();

            // 3. Petición al servidor (Controlador Laravel)
            try {
                const response = await fetch('/cliente/chatbot/procesar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ mensaje: texto })
                });

                const data = await response.json();

                // Eliminar animación de escribiendo
                document.getElementById(typingId).remove();

                // 4. Mostrar respuesta del Bot (Alineada a la izquierda, color blanco)
                chatContainer.innerHTML += `
                    <div class="d-flex mb-4">
                        <div class="bg-white border shadow-sm rounded-4 rounded-top-0 p-3" style="max-width: 80%;">
                            <p class="m-0 text-body" style="font-size: 0.95rem;">${data.respuesta}</p>
                        </div>
                    </div>
                `;
            } catch (error) {
                document.getElementById(typingId).remove();
                chatContainer.innerHTML += `
                    <div class="d-flex mb-4">
                        <div class="bg-danger text-white border shadow-sm rounded-4 rounded-top-0 p-3" style="max-width: 80%;">
                            <p class="m-0" style="font-size: 0.95rem;"><i class="bi bi-exclamation-triangle-fill me-2"></i>Hubo un error de conexión. Intenta de nuevo.</p>
                        </div>
                    </div>
                `;
            }

            // Reactivar input y hacer scroll
            userInput.disabled = false;
            sendBtn.disabled = false;
            userInput.focus();
            hacerScrollAbajo();
        });

        // Función auxiliar para mantener el scroll siempre abajo
        function hacerScrollAbajo() {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    });
</script>
@endsection