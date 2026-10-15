@extends('cpanel/plantilla')
@section('title', 'editar')
@section('content')
    <form action="{{url('admon/usuarios/'.$fila->ID_usuario)}}" id="formUsuarios" method="post">
        @csrf
        {{method_field('PATCH')}}
        @include('cpanel/usuarios/form')
    </form>
@endsection
