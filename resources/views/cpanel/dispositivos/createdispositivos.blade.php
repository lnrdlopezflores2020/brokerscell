@extends('cpanel/plantillaTecnicos')
@section('title','Registrar Dispositivo')

@section('content')
    <div class="container mt-5">

        {{-- Título --}}
        <div class="row mb-4">
            <div class="col-12 border-bottom pb-2">
                <h3 class="text-primary fw-bold">
                    <i class="bi bi-phone-fill me-2"></i>Registrar Dispositivo
                </h3>
            </div>
        </div>

        {{-- Formulario --}}
        <form action="{{ url('/tecnico/dispositivos') }}" method="POST" id="formDispositivo">
            @csrf
            @include('cpanel/dispositivos/form')
            
            {{-- Asegúrate de que en tu archivo form.blade.php el botón tenga id="btnGuardar" --}}
        </form>
    </div>

    {{-- LIBRERÍA SWEETALERT 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. Alerta de ÉXITO (Si se guardó correctamente)
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#198754',
                    timer: 3000,
                    timerProgressBar: true,
                    backdrop: `rgba(0,0,0,0.4)`
                });
            @endif

            // 2. Alerta de ERROR (Captura la excepción del controlador)
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Registro',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Entendido',
                    backdrop: `rgba(0,0,0,0.4)`
                });
            @endif

            // 3. Validación de campos vacíos (HTML5 nativo)
            const btnGuardar = document.getElementById('btnGuardar');
            const form = document.getElementById('formDispositivo');

            if (btnGuardar) {
                btnGuardar.addEventListener('click', function(e) {
                    if (!form.checkValidity()) {
                        // Si el formulario no es válido, el navegador mostrará su advertencia
                        // Opcionalmente, podemos lanzar un aviso propio:
                        e.preventDefault(); 
                        Swal.fire({
                            icon: 'warning',
                            title: 'Campos incompletos',
                            text: 'Por favor, rellena todos los campos obligatorios.',
                            confirmButtonColor: '#0d6efd'
                        });
                    }
                });
            }
        });
    </script>
@endsection