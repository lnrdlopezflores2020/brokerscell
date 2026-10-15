@extends('cpanel/plantilla')
@section('title', 'Técnicos')
@section('content')
    <form action="{{ url('admon/tecnicos') }}" name="form" id="formTecnicos" method="post">
        @csrf
        @include('cpanel/tecnicos/form')
    </form>

    {{-- LIBRERÍA SWEETALERT 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. CONFIRMACIÓN ANTES DE GUARDAR
            const formTecnicos = document.getElementById('formTecnicos');
            if(formTecnicos) {
                formTecnicos.addEventListener('submit', function(e) {
                    e.preventDefault(); // Detiene el envío automático del navegador
                    
                    Swal.fire({
                        title: '¿Guardar técnico?',
                        text: "Verifica que el nombre, teléfono y la cuenta vinculada sean correctos.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#6f42c1', // Morado característico de Brokerscell
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="bi bi-save"></i> Sí, guardar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Muestra una alerta de carga para evitar doble clic
                            Swal.fire({
                                title: 'Procesando...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            formTecnicos.submit(); // Envía el formulario a Laravel
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
                    confirmButtonColor: '#dc3545' // Rojo para errores
                });
            @endif

            // 4. ERRORES DE VALIDACIÓN (Si faltan campos o el teléfono es inválido)
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