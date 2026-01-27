@extends('cpanel/plantilla')
@section('title','Editar')
@section('content')
    <form action="{{url('admon/tecnicos/'.$fila->ID_tec)}}" id="formClientes" method="post">
        @csrf
        {{method_field('PATCH')}}
        @include('cpanel/tecnicos/form')
    </form>
@endsection
