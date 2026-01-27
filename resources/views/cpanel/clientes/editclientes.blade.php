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
@endsection
