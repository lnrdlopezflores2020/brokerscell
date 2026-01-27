@extends('cpanel/plantillaTecnicos')
@section('title', 'dispositivos')
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
            @include('cpanel/dispositivos/form')
    </div>

@endsection
