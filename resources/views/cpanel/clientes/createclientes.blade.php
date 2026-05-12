@php
    // 1. Limpiamos el rol para evitar errores de espacios
    $rol = strtolower(trim(auth()->user()->rol_usuario));

    // 2. Lógica EXPLICITA:
    if ($rol === 'administrador') {
        $layout = 'cpanel/plantilla';
        $url_prefix = 'admon';
    } else {
        $layout = 'cpanel/plantillaTecnicos';
        $url_prefix = 'tecnico';
    }
@endphp

@extends($layout)
@section('title','clientes')
@section('content')
    <form action="{{ url($url_prefix . '/clientes') }}" name="form" id="formClientes" method="post">
        @csrf
        @include('cpanel/clientes/form')
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. CONFIRMACIÓN ANTES DE GUARDAR
            const formClientes = document.getElementById('formClientes');
            if(formClientes) {
                formClientes.addEventListener('submit', function(e) {
                    e.preventDefault(); // Detiene el envío automático
                    
                    Swal.fire({
                        title: '¿Guardar cliente?',
                        text: "Verifica que los datos ingresados sean correctos.",
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
                                title: 'Guardando...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            formClientes.submit(); // Envía el formulario
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
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc3545'
                });
            @endif

            // 4. ERRORES DE VALIDACIÓN (Si faltan campos)
            @if($errors->any())
                Swal.fire({
                    icon: 'warning',
                    title: 'Información incompleta',
                    text: 'Por favor, revisa los campos en rojo para poder continuar.',
                    confirmButtonColor: '#ffc107'
                });
            @endif
            
        });
    </script>
@endsection