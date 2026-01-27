@extends('cpanel/plantilla')
@section('title', 'Respaldo de Base de Datos')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                {{-- Mensajes de Alerta --}}
                @if(session('error'))
                    <div class="alert alert-danger shadow-sm border-0 mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    </div>
                @endif

                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-danger text-white text-center py-4">
                        <i class="bi bi-database-fill-lock display-4"></i>
                        <h4 class="fw-bold mt-2 mb-0">Zona de Seguridad</h4>
                        <p class="mb-0 opacity-75">Respaldo General del Sistema</p>
                    </div>

                    <div class="card-body p-4">
                        <p class="text-muted text-center mb-4">
                            Estás a punto de descargar una copia completa de la base de datos de <strong>SoluxMovil</strong>.
                            Por seguridad, confirma tu identidad.
                        </p>

                        <form action="{{ route('admon.respaldo.descargar') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold text-secondary small text-uppercase">
                                    Contraseña de Administrador
                                </label>
                                <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-key"></i>
                                </span>
                                    <input type="password"
                                           name="password"
                                           class="form-control border-start-0 ps-0"
                                           placeholder="Ingresa tu contraseña actual"
                                           required>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-dark btn-lg">
                                    <i class="bi bi-cloud-download-fill me-2"></i> Generar y Descargar SQL
                                </button>
                                <a href="{{ url('/admon/inicio') }}" class="btn btn-light text-muted">Cancelar</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-light text-center py-3">
                        <small class="text-muted fst-italic">
                            <i class="bi bi-shield-lock"></i> Acción monitoreada por el sistema.
                        </small>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
