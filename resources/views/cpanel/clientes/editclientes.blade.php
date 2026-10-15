@php
    // 1. Limpiamos el rol para evitar errores de espacios
    $rol = strtolower(trim(auth()->user()->rol_usuario));

    // 2. Lógica EXPLICITA:
    // Si la base de datos dice que eres administrador, OBLIGAMOS a usar 'admon'
    // sin importar lo que diga la URL.
    if ($rol === 'administrador') {
        $layout = 'cpanel/plantilla';
        $url_prefix = 'admon';
    } else {
        // Para cualquier otro caso (tecnico), usamos la ruta de técnico
        $layout = 'cpanel/plantillaTecnicos';
        $url_prefix = 'tecnico';
    }
@endphp

@extends($layout)
@section('title','Editar')

@section('content')
    <form action="{{url($url_prefix . '/clientes/' .$fila->ID_client)}}" id="formClientes" method="post">
        @csrf
        {{method_field('PATCH')}}
        @include('cpanel/clientes/form')
    </form>

    {{-- LIBRERÍA SWEETALERT2 (Puedes omitir esta línea si ya la incluyes en tu plantilla principal) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SCRIPT PARA CAPTURAR EXCEPCIONES Y ÉXITOS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // Si el controlador devuelve un mensaje de ERROR (Excepciones SQL, validaciones, etc.)
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Acción Denegada',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Entendido',
                    backdrop: `rgba(0,0,0,0.4)`
                });
            @endif

            // Si el controlador devuelve un mensaje de ÉXITO
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación Exitosa!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#198754',
                    confirmButtonText: 'Aceptar',
                    timer: 3000, // Se cierra automáticamente en 3 segundos
                    timerProgressBar: true
                });
            @endif
            
        });
    </script>
@endsection
