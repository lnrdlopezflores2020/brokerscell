@extends('cpanel/plantilla')
@section('title', 'Detalles de Reparación')
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 bg-body overflow-hidden">
                <div class="card-header bg-body-tertiary border-bottom p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-brand-purple text-uppercase fw-bold mb-1" style="letter-spacing: 1px; font-size: 0.7rem;">AUDITORÍA DE SERVICIO</h6>
                        <h4 class="fw-bold text-body m-0">Folio #{{ str_pad($reparacion->ID_rep, 6, '0', STR_PAD_LEFT) }}</h4>
                    </div>
                    <a href="/admon/reparaciones" class="btn btn-sm btn-light border rounded-pill">Volver</a>
                </div>

                <div class="card-body p-4 p-md-5">
                    
                    <div class="row mb-5">
                        <div class="col-sm-6 mb-4 mb-sm-0">
                            <p class="text-muted small text-uppercase fw-bold mb-2">Datos del Cliente</p>
                            <h6 class="fw-bold text-body">{{ $reparacion->dispositivo->cliente->nombre ?? 'N/A' }} {{ $reparacion->dispositivo->cliente->apellido ?? '' }}</h6>
                            <p class="text-secondary mb-1"><i class="bi bi-telephone me-2"></i>{{ $reparacion->dispositivo->cliente->telefono ?? 'Sin teléfono' }}</p>
                            <p class="text-secondary mb-0"><i class="bi bi-geo-alt me-2"></i>{{ $reparacion->dispositivo->cliente->direccion ?? 'Sin dirección' }}</p>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <p class="text-muted small text-uppercase fw-bold mb-2">Fechas de Operación</p>
                            <p class="text-body mb-1"><strong>Ingresó:</strong> {{ \Carbon\Carbon::parse($reparacion->fec_inicio)->format('d/m/Y ') }}</p>
                            <p class="text-body mb-0"><strong>Entrega:</strong> {{ \Carbon\Carbon::parse($reparacion->fec_est_entrega)->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div class="bg-body-tertiary border rounded-4 p-4 mb-4">
                        <p class="text-muted small text-uppercase fw-bold mb-3 border-bottom pb-2">Información Técnica</p>
                        <div class="row">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <span class="d-block text-secondary small">Equipo</span>
                                <span class="fw-bold text-body">{{ $reparacion->dispositivo->marca ?? '' }} {{ $reparacion->dispositivo->modelo ?? '' }}</span>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <span class="d-block text-secondary small">Estado</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-3 py-1 mt-1 text-uppercase">{{ $reparacion->est_reparacion }}</span>
                            </div>
                            <div class="col-md-4">
                                <span class="d-block text-secondary small">Costo Total</span>
                                <span class="fw-bold text-success fs-5">${{ number_format($reparacion->costo, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <p class="text-muted small text-uppercase fw-bold mb-2">Diagnóstico / Trabajo Realizado</p>
                        <div class="p-3 border rounded-3 bg-light">
                            <p class="mb-0 text-dark fst-italic">{{ $reparacion->descripcion }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection