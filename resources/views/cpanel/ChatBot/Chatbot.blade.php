@extends('cpanel/plantillaClientes')
@section('title', 'Soporte')
@section('title', 'Asistente IA')

@section('content')
    <div class="container-fluid p-0" style="background-color: #131314; height: 90vh;">

        {{-- ÁREA DEL CHAT --}}
        <div id="chat-container" class="d-flex flex-column p-4 overflow-auto" style="height: 80%; scroll-behavior: smooth;">

            {{-- Mensaje de Bienvenida --}}
            <div class="d-flex align-items-start mb-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                     style="width: 40px; height: 40px; background: linear-gradient(135deg, #4285f4, #d96570);">
                    <i class="bi bi-stars text-white"></i>
                </div>
                <div class="text-white">
                    <div class="fw-bold mb-1">SoluxBot</div>
                    <div class="p-3 rounded-4" style="background-color: #1e1f20; max-width: 600px; line-height: 1.6;">
                        ¡Hola! Soy la IA de SoluxMovil 🤖. <br>
                        Puedo darte presupuestos estimados al instante. <br>
                        Ejemplo: <i>"¿Cuánto cuesta cambiar la pantalla de un iPhone 11?"</i>
                    </div>
                </div>
            </div>

            {{-- AQUÍ SE AGREGARÁN LOS MENSAJES CON JS --}}

        </div>

        {{-- ÁREA DE INPUT (FLOTANTE) --}}
        <div class="fixed-bottom p-3 d-flex justify-content-center" style="background: linear-gradient(to top, #131314 80%, transparent);">
            <div class="input-group" style="max-width: 800px;">
                <input type="text" id="user-input"
                       class="form-control border-0 py-3 ps-4 shadow-lg text-white"
                       placeholder="Escribe tu consulta aquí..."
                       style="background-color: #1e1f20; border-radius: 30px 0 0 30px; color: white !important;">

                <button class="btn border-0 pe-4 shadow-lg" id="btn-send"
                        style="background-color: #1e1f20; border-radius: 0 30px 30px 0;">
                    <i class="bi bi-send-fill fs-5 text-primary"></i>
                </button>
            </div>
        </div>

    </div>

    {{-- ESTILOS EXTRA PARA MODO OSCURO --}}
    <style>
        /* Scrollbar oscura */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #131314; }
        ::-webkit-scrollbar-thumb { background: #444; border-radius: 4px; }

        /* Input focus sin borde azul feo */
        #user-input:focus { box-shadow: none; outline: none; background-color: #2d2e2f; }
        #user-input::placeholder { color: #888; }
    </style>

    {{-- LÓGICA JAVASCRIPT --}}
    <script>
        const chatContainer = document.getElementById('chat-container');
        const userInput = document.getElementById('user-input');
        const btnSend = document.getElementById('btn-send');

        // Enviar con Enter
        userInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') sendMessage();
        });

        btnSend.addEventListener('click', sendMessage);

        async function sendMessage() {
            const text = userInput.value.trim();
            if (text === '') return;

            // 1. Agregar mensaje del usuario (Derecha)
            appendMessage('user', text);
            userInput.value = '';

            // 2. Mostrar indicador "Escribiendo..."
            const loadingId = appendLoading();
            scrollToBottom();

            try {
                // 3. Petición al Servidor Laravel
                const response = await fetch("{{ route('chatbot.send') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: text })
                });

                const data = await response.json();

                // 4. Quitar loading y mostrar respuesta IA
                document.getElementById(loadingId).remove();
                appendMessage('bot', data.reply);

            } catch (error) {
                document.getElementById(loadingId).remove();
                appendMessage('bot', 'Lo siento, ocurrió un error. Intenta de nuevo.');
            }

            scrollToBottom();
        }

        function appendMessage(role, text) {
            const div = document.createElement('div');
            div.className = `d-flex align-items-start mb-4 ${role === 'user' ? 'justify-content-end' : ''}`;

            let avatar = '';
            let bgClass = role === 'user' ? 'bg-primary text-white' : 'text-white';
            let style = role === 'user' ? 'border-radius: 20px 20px 5px 20px;' : 'background-color: #1e1f20; border-radius: 20px 20px 20px 5px;';

            // Icono del Bot
            if (role === 'bot') {
                avatar = `
            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                 style="width: 40px; height: 40px; background: linear-gradient(135deg, #4285f4, #d96570); flex-shrink: 0;">
                <i class="bi bi-stars text-white"></i>
            </div>`;
            }

            let content = `
            ${role === 'bot' ? avatar : ''}
            <div class="p-3 shadow-sm ${bgClass}" style="max-width: 80%; ${style}">
                ${text}
            </div>
        `;

            div.innerHTML = content;
            chatContainer.appendChild(div);
        }

        function appendLoading() {
            const id = 'loading-' + Date.now();
            const div = document.createElement('div');
            div.id = id;
            div.className = 'd-flex align-items-start mb-4';
            div.innerHTML = `
            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                 style="width: 40px; height: 40px; background: linear-gradient(135deg, #4285f4, #d96570);">
                <i class="bi bi-stars text-white"></i>
            </div>
            <div class="p-3 text-white rounded-4" style="background-color: #1e1f20;">
                <span class="spinner-grow spinner-grow-sm" role="status"></span> Escribiendo...
            </div>
        `;
            chatContainer.appendChild(div);
            return id;
        }

        function scrollToBottom() {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    </script>
@endsection
