@php
    // Determinamos el layout y prefijo de URL según el rol
    $rol = strtolower(trim(auth()->user()->rol_usuario));
    if ($rol === 'administrador') {
        $layout = 'cpanel/plantilla';
        $url_prefix = 'admon';
    } else {
        $layout = 'cpanel/plantillaTecnicos';
        $url_prefix = 'tecnico';
    }
@endphp

@extends($layout)
@section('title', 'Actualizar Reparación')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-pencil-square"></i> Actualizar Estado - Folio #{{ str_pad($reparacion->ID_rep, 6, '0', STR_PAD_LEFT) }}
                        </h5>
                        <span class="badge bg-light text-primary">{{ $reparacion->fec_inicio }}</span>
                    </div>

                    <div class="card-body">
                        {{-- Formulario apunta a la ruta update (PUT) --}}
                        <form action="{{ url('tecnico/Actualizar/' . $reparacion->ID_rep) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- INFORMACIÓN DE SOLO LECTURA --}}
                            <div class="alert alert-light border mb-4">
                                <div class="row">
                                    {{-- Cliente --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-muted small text-uppercase">Cliente</label>
                                        <input type="text" class="form-control bg-white"
                                               value="{{ $reparacion->dispositivo->cliente->nombre }} {{ $reparacion->dispositivo->cliente->apellido }}"
                                               disabled>
                                    </div>

                                    {{-- Dispositivo --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-muted small text-uppercase">Dispositivo</label>
                                        <input type="text" class="form-control bg-white"
                                               value="{{ $reparacion->dispositivo->marca }} {{ $reparacion->dispositivo->modelo }} ({{ $reparacion->dispositivo->tipo }})"
                                               disabled>
                                    </div>

                                    {{-- Falla Reportada --}}
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-bold text-muted small text-uppercase">Descripción de la Falla</label>
                                        <textarea class="form-control bg-white" rows="3" disabled>{{ $reparacion->descripcion }}</textarea>
                                    </div>

                                    {{-- Costo (Solo visual) --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-muted small text-uppercase">Costo Acordado</label>
                                        <div class="input-group">
                                            <span class="input-group-text border-0 bg-light">$</span>
                                            <input type="text" class="form-control bg-white border-0 fw-bold"
                                                   value="{{ number_format($reparacion->costo, 2) }}"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- ÚNICO CAMPO EDITABLE: ESTADO --}}
                            <div class="mb-4">
                                <label for="est_reparacion" class="form-label fw-bold fs-5 text-primary">
                                    <i class="bi bi-stoplights"></i> Actualizar Estado de Reparación
                                </label>
                                <select name="est_reparacion" id="est_reparacion" class="form-select form-select-lg shadow-sm border-primary">
                                    <option value="Pendiente" {{ $reparacion->est_reparacion == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="En revision" {{ $reparacion->est_reparacion == 'En revision' ? 'selected' : '' }}>En revisión</option>
                                    <option value="En Reparacion" {{ $reparacion->est_reparacion == 'En Reparacion' ? 'selected' : '' }}>En reparación</option>
                                    <option value="Terminado" {{ $reparacion->est_reparacion == 'Terminado' ? 'selected' : '' }}>Terminado / Listo</option>
                                    <option value="Entregado" {{ $reparacion->est_reparacion == 'Entregado' ? 'selected' : '' }}>Entregado al Cliente</option>
                                </select>
                                <div class="form-text mt-2">
                                    Seleccione el nuevo estado para avanzar el flujo de trabajo.
                                </div>
                            </div>

                            {{-- BOTONES DE ACCIÓN --}}
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ url('/tecnico/reparaciones') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Volver
                                </a>
                                <button type="submit" class="btn btn-primary px-5 btn-lg">
                                    <i class="bi bi-save"></i> Actualizar Estado
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
