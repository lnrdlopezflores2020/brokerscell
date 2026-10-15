@extends('cpanel/plantilla')
@section('title','Editar')

@section('content')
    <form action="{{url('admon/tecnicos/'.$fila->ID_tec)}}" id="formClientes" method="post">
        @csrf
        {{method_field('PATCH')}}
        @include('cpanel/tecnicos/form')
    </form>

    {{-- LIBRERÍA SWEETALERT 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SCRIPTS PARA CAPTURAR ALERTAS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. Alerta de Éxito (Modal Centrado)
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación Exitosa!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#198754',
                    confirmButtonText: 'Aceptar',
                    timer: 3000, 
                    timerProgressBar: true,
                    backdrop: `rgba(0,0,0,0.4)`
                });
            @endif

            // 2. Alerta de Error (Modal Centrado)
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
            
        });
    </script>
@endsection
