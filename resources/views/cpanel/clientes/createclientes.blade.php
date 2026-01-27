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
        // 1. Definimos la configuración del Toast UNA sola vez
        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // 2. Bloque para mensaje de ÉXITO
        @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
        @endif

        // 3. Bloque para mensaje de ERROR (El que faltaba)
        @if(session('error'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}'
        });
        @endif

        // 4. (Opcional) Bloque para errores de validación de formulario estándar
        @if($errors->any())
        Toast.fire({
            icon: 'warning',
            title: 'Por favor corrige los errores en el formulario.'
        });
        @endif
    </script>
@endsection
