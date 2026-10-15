@extends('cpanel/plantilla')
@section('title', 'Editar Historial')
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 bg-body overflow-hidden">
                
                <div style="height: 6px; background: #dc3545;"></div>
                
                <div class="card-header bg-transparent border-bottom pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold text-body m-0">
                        <i class="bi bi-pencil-square text-danger me-2"></i>Edición Administrativa
                    </h4>
                    <a href="/admon/reparaciones" class="btn btn-sm btn-outline-secondary rounded-pill">Volver</a>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="alert alert-warning bg-warning bg-opacity-10 border-warning-subtle text-warning-emphasis mb-4 rounded-3 d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <small>Estás modificando un registro oficial del historial. Asegúrate de que los datos sean correctos antes de guardar.</small>
                    </div>

                    <form action="{{ url('/admon/reparaciones', $reparacion->ID_rep) }}" method="POST">
                        @csrf
                        {{ method_field('PATCH') }}
                        
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Descripción de Falla / Solución</label>
                                <input type="text" name="descripcion" value="{{ $reparacion->descripcion }}" class="form-control bg-body-tertiary" required>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Estado</label>
                                <select name="est_reparacion" class="form-select bg-body-tertiary" required>
                                    <option value="En revision" {{ $reparacion->est_reparacion == 'En revision' ? 'selected' : '' }}>En Revisión</option>
                                    <option value="En reparacion" {{ $reparacion->est_reparacion == 'En reparacion' ? 'selected' : '' }}>En Reparación</option>
                                    <option value="Terminado" {{ $reparacion->est_reparacion == 'Terminado' ? 'selected' : '' }}>Terminado</option>
                                    <option value="Entregado" {{ $reparacion->est_reparacion == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Fecha Entrega</label>
                                <input type="date" name="fec_est_entrega" value="{{ \Carbon\Carbon::parse($reparacion->fec_est_entrega)->format('Y-m-d') }}" class="form-control bg-body-tertiary" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Costo (MXN)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary text-danger fw-bold">$</span>
                                    <input type="number" name="costo" step="0.01" min="0" value="{{ $reparacion->costo }}" class="form-control bg-body-tertiary text-danger fw-bold" required>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-end border-top pt-4">
                            <button type="submit" class="btn btn-danger fw-bold px-4 rounded-pill">
                                <i class="bi bi-save me-2"></i>Sobrescribir Registro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
