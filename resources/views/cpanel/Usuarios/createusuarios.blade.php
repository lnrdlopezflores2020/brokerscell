@extends('cpanel/plantilla')
@section('title','Usuarios')
@section('content')
    <form action="{{url('admon/usuarios  ')}}" name="form" id="formUsuarios" method="post">
        @csrf
        @include('cpanel/usuarios/form')
    </form>
@endsection
