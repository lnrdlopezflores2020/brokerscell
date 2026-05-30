@extends('cpanel/plantillaTecnicos')
@section('title','Editar Dispositivo')

@section('content')
    <div class="container mt-5">

        {{-- Título --}}
        <div class="row mb-4">
            <div class="col-12 border-bottom pb-2">
                <h3 class="text-primary fw-bold">
                    <i class="bi bi-pencil-square me-2"></i>Editar Dispositivo
                </h3>
            </div>
        </div>

        {{-- Formulario de Edición --}}
        <form action="{{ url('/tecnico/dispositivos/'.$dispositivo->ID_tel) }}" method="POST" id="formDispositivo">
            @csrf
            {{ method_field('PATCH') }}
            @include('cpanel/dispositivos/form')
        </form>
    </div>

    {{-- LIBRERÍA SWEETALERT 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#198754',
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc3545'
        });
    @endif

    const form = document.getElementById('formDispositivo');

    form.addEventListener('submit', function(e) {

        if (!form.checkValidity()) {

            e.preventDefault();
            e.stopPropagation();

            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor completa todos los campos obligatorios.',
                confirmButtonColor: '#0d6efd'
            });

            form.reportValidity();
        }
    });

});
    </script>
@endsection
