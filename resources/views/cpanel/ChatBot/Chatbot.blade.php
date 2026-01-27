@extends('cpanel/plantillaClientes')
@section('title', 'Soporte')
@section('content')
    <div div class="container-fluid py-4 w-100" style="min-width: 320px;">
        <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="col-md-8 col-lg-6 text-center">

                {{-- Tarjeta Principal --}}
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-5">

                        {{-- Icono Animado o Ilustrativo --}}
                        <div class="mb-4 text-primary bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <i class="bi bi-headset display-3"></i>
                        </div>

                        <h2 class="fw-bold text-dark mb-3">Ayuda y Soporte</h2>

                        <p class="lead text-muted mb-4">
                            En <strong class="text-primary">SoluxMovil</strong> nos preocupamos por brindarte una atención y servicio de calidad.
                        </p>

                        <div class="alert alert-info border-0 d-inline-block px-4 py-3 rounded-pill mb-4">
                            <i class="bi bi-calendar-event me-2"></i>
                            Esta sección estará disponible a partir de <strong>Junio de 2026</strong>.
                        </div>

                        <p class="text-muted small mb-4">
                            Estamos trabajando para mejorar tu experiencia. Mientras tanto, si tienes dudas sobre otros servivios, puedes contactarnos directamente en taller.
                        </p>

                        {{-- Botón de Regreso --}}
                        <a href="{{ route('Mis-reparaciones.index') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill">
                            <i class="bi bi-arrow-left me-2"></i> Volver a Mis Reparaciones
                        </a>

                    </div>

                    {{-- Barra decorativa inferior --}}
                    <div class="card-footer bg-primary py-2 border-0"></div>
                </div>

            </div>
        </div>
    </div>
@endsection
