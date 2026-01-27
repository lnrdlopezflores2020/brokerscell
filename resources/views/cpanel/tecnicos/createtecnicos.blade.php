@extends('cpanel/plantilla')
@section('title', 'Técnicos')
@section('content')
    <form action="{{url('admon/tecnicos')}}" name="form" id="formTecnicos" method="post">
        @csrf
        @include('cpanel/tecnicos/form')
    </form>
@endsection
