@extends('cpanel/plantilla')
@section('title','Usuarios')
@section('content')
    <form action="{{ url('admon/usuarios') }}" name="form" id="formUsuarios" method="post">
        @csrf
        @include('cpanel/usuarios/form')
    </form>

    {{-- LIBRERÍA SWEETALERT 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. CONFIRMACIÓN ANTES DE GUARDAR
            const formUsuarios = document.getElementById('formUsuarios');
            if(formUsuarios) {
                formUsuarios.addEventListener('submit', function(e) {
                    e.preventDefault(); // Detiene el envío automático
                    
                    Swal.fire({
                        title: '¿Guardar usuario?',
                        text: "Verifica que el correo y el rol asignado sean correctos.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#6f42c1', // Morado Brokerscell
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="bi bi-save"></i> Sí, guardar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Mostrar pequeño loader mientras procesa
                            Swal.fire({
                                title: 'Procesando...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            formUsuarios.submit(); // Envía el formulario a Laravel
                        }
                    });
                });
            }

            // 2. MENSAJE DE ÉXITO
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación Exitosa!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#6f42c1',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            // 3. MENSAJE DE ERROR
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc3545'
                });
            @endif

            // 4. ERRORES DE VALIDACIÓN (Si el usuario deja campos vacíos o correos duplicados)
            @if($errors->any())
                Swal.fire({
                    icon: 'warning',
                    title: 'Información incompleta o inválida',
                    text: 'Por favor, revisa que todos los campos requeridos estén llenos correctamente.',
                    confirmButtonColor: '#ffc107'
                });
            @endif
            
        });
    </script>
@endsection
