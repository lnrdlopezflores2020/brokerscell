@extends('cpanel/plantillaClientes')
@section('title', 'inicio')
@section('content')
    <div class="container-fluid py-4">

        {{-- 1. ENCABEZADO Y BIENVENIDA --}}
        {{-- Agregamos flex-wrap para que no se rompa en móviles --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 border-bottom pb-4 gap-3">
            <div class="text-center text-md-start">
                <h2 class="fw-bold text-dark mb-1">Hola, {{ auth()->user()->datosCliente->nombre ?? 'Cliente' }} 👋</h2>
                <p class="text-secondary mb-0">Panel de control de reparaciones</p>
            </div>
            <div>
                <a href="https://wa.me/521XXXXXXXXXX" target="_blank" class="btn btn-success rounded-pill px-4 shadow-sm w-100">
                    <i class="bi bi-whatsapp me-2"></i> Soporte
                </a>
            </div>
        </div>

        {{-- 2. WIDGETS DE ESTADÍSTICAS --}}
        {{-- row-cols-1: 1 columna en móvil. row-cols-md-3: 3 columnas en PC --}}
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">

            {{-- Pendientes --}}
            <div class="col">
                <div class="card bg-primary text-white border-0 shadow h-100 rounded-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2 text-white-50 small fw-bold">En Reparación</h6>
                            <h2 class="display-6 fw-bold mb-0">{{ $pendientes }}</h2>
                        </div>
                        <div class="p-3 bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-tools fs-4 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Listos --}}
            <div class="col">
                <div class="card bg-success text-white border-0 shadow h-100 rounded-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2 text-white-50 small fw-bold">Listos / Entregados</h6>
                            <h2 class="display-6 fw-bold mb-0">{{ $listos }}</h2>
                        </div>
                        <div class="p-3 bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-check-lg fs-4 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Inversión --}}
            <div class="col">
                <div class="card bg-white text-dark border-0 shadow h-100 rounded-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2 text-muted small fw-bold">Inversión Total</h6>
                            <h2 class="display-6 fw-bold text-dark mb-0">${{ number_format($totalGastado, 2) }}</h2>
                        </div>
                        <div class="p-3 bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-wallet2 fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. LISTA DE REPARACIONES --}}
        <div class="d-flex align-items-center mb-4">
            <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                <i class="bi bi-phone fs-4"></i>
            </div>
            <h4 class="fw-bold text-dark mb-0">Tus Dispositivos</h4>
        </div>

        @if($reparaciones->isEmpty())
            <div class="card border-0 shadow-sm py-5 text-center bg-white rounded-4">
                <div class="card-body">
                    <div class="mb-3 p-4 d-inline-block bg-light rounded-circle text-muted">
                        <i class="bi bi-box-seam display-1 opacity-25"></i>
                    </div>
                    <h5 class="text-dark fw-bold">No tienes reparaciones activas</h5>
                    <p class="text-muted small mb-0">Tus nuevos servicios aparecerán aquí automáticamente.</p>
                </div>
            </div>
        @else
            {{-- Aquí usamos row-cols-1 para móvil y row-cols-lg-3 para pantallas grandes --}}
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach($reparaciones as $rep)
                    @php
                        $color = 'secondary';
                        $progreso = 10;
                        $textoEstado = 'Recibido';
                        $iconStatus = 'bi-clipboard';
                        $badgeClass = 'bg-secondary text-white';
                        $textColorClass = 'text-secondary';
                        $borderClass = 'border-secondary';

                        if($rep->est_reparacion == 'En revision') {
                            $color = 'warning';
                            $badgeClass = 'bg-warning text-dark';
                            $progreso = 35;
                            $textoEstado = 'En Diagnóstico';
                            $iconStatus = 'bi-search';
                            $textColorClass = 'text-warning'; // Bootstrap warning text is messy, usually better strict color
                            $borderClass = 'border-warning';
                        } elseif($rep->est_reparacion == 'En Reparacion') {
                            $color = 'primary';
                            $badgeClass = 'bg-primary text-white';
                            $progreso = 65;
                            $textoEstado = 'Reparando';
                            $iconStatus = 'bi-wrench';
                            $textColorClass = 'text-primary';
                            $borderClass = 'border-primary';
                        } elseif($rep->est_reparacion == 'Terminado') {
                            $color = 'success';
                            $badgeClass = 'bg-success text-white';
                            $progreso = 100;
                            $textoEstado = 'Listo';
                            $iconStatus = 'bi-check-circle-fill';
                            $textColorClass = 'text-success';
                            $borderClass = 'border-success';
                        } elseif($rep->est_reparacion == 'Entregado') {
                            $color = 'dark';
                            $badgeClass = 'bg-dark text-white';
                            $progreso = 100;
                            $textoEstado = 'Entregado';
                            $iconStatus = 'bi-bag-check-fill';
                            $textColorClass = 'text-dark';
                            $borderClass = 'border-dark';
                        }
                    @endphp

                    <div class="col">
                        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">

                            {{-- Encabezado Card --}}
                            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                            <span class="badge bg-light text-secondary border fw-normal p-2">
                                #{{ str_pad($rep->ID_rep, 6, '0', STR_PAD_LEFT) }}
                            </span>
                                <span class="badge rounded-pill {{ $badgeClass }} px-3 py-2">
                                {{ strtoupper($rep->est_reparacion) }}
                            </span>
                            </div>

                            <div class="card-body px-4 pt-2">
                                {{-- Info Dispositivo --}}
                                <div class="text-center mb-4 mt-2">
                                    <h5 class="fw-bold text-dark mb-1 text-break">{{ $rep->dispositivo->marca }} {{ $rep->dispositivo->modelo }}</h5>
                                    <span class="badge bg-light text-secondary border rounded-pill fw-normal">
                                    {{ $rep->dispositivo->tipo }}
                                </span>
                                </div>

                                {{-- Barra Progreso --}}
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between small mb-1">
                                    <span class="fw-bold {{ $rep->est_reparacion == 'En revision' ? 'text-dark' : $textColorClass }}">
                                        <i class="bi {{ $iconStatus }} me-1"></i> {{ $textoEstado }}
                                    </span>
                                        <span class="text-muted fw-bold">{{ $progreso }}%</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $color }} progress-bar-striped progress-bar-animated"
                                             role="progressbar"
                                             style="width: {{ $progreso }}%;"></div>
                                    </div>
                                </div>

                                {{-- Descripción --}}
                                <div class="p-3 mb-4 bg-light rounded-3 border-start border-4 {{ $borderClass }}">
                                    <small class="text-uppercase text-muted fw-bold d-block mb-1">Falla Reportada</small>
                                    <p class="mb-0 small text-dark fst-italic text-break">"{{ Str::limit($rep->descripcion, 90) }}"</p>
                                </div>

                                {{-- Datos Económicos --}}
                                <div class="row g-0 border rounded-3 text-center bg-white overflow-hidden mb-3">
                                    <div class="col-4 py-2 border-end bg-light bg-opacity-10">
                                        <div class="text-muted small fw-bold" style="font-size: 0.65rem;">INGRESO</div>
                                        <div class="fw-bold text-dark small">{{ \Carbon\Carbon::parse($rep->fec_inicio)->format('d M') }}</div>
                                    </div>
                                    <div class="col-4 py-2 border-end bg-light bg-opacity-10">
                                        <div class="text-muted small fw-bold" style="font-size: 0.65rem;">ENTREGA</div>
                                        <div class="fw-bold text-primary small">{{ \Carbon\Carbon::parse($rep->fec_est_entrega)->format('d M') }}</div>
                                    </div>
                                    <div class="col-4 py-2 bg-light bg-opacity-10">
                                        <div class="text-muted small fw-bold" style="font-size: 0.65rem;">TOTAL</div>
                                        <div class="fw-bold text-success small">${{ number_format($rep->costo, 0) }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                                @if($rep->est_reparacion == 'Terminado' || $rep->est_reparacion == 'Entregado')
                                    <a href="{{ route('cliente.nota_entrega', $rep->ID_rep) }}"
                                       class="btn btn-outline-success w-100 fw-bold shadow-sm"
                                       target="_blank">
                                        <i class="bi bi-file-earmark-pdf-fill me-2"></i> Nota
                                    </a>
                                @else
                                    <button class="btn btn-light text-secondary w-100 border" disabled>
                                        <span class="spinner-grow spinner-grow-sm me-2 text-{{ $color }}" role="status" aria-hidden="true"></span>
                                        En proceso...
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
