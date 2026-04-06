@php
    $layout = 'cpanel/plantilla';

    switch(auth()->user()->rol_usuario) {
        case 'tecnico':
            $layout = 'cpanel/plantillaTecnicos';
            break;
    }
@endphp

@extends($layout)
@section('title', 'tecnicos')
@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title h1 m-0"><i class="bi bi-tools me-2"></i>Reparaciones</h4>
                <div>
                    @if(auth()->user()->rol_usuario === 'administrador')
                        <a class="btn btn-success me-2" href="{{url('admon/reportes/reparaciones')}}" target="_blank" role="button">
                            <i class="bi bi-file-earmark-pdf"></i> Reporte PDF
                        </a>
                    @endif

                    @if(auth()->user()->rol_usuario === 'tecnico')
                        <a class="btn btn-primary" href="/tecnico/reparaciones/create" role="button">
                            <i class="bi bi-plus-lg"></i> Nueva Reparación
                        </a>
                    @endif
                </div>
            </div>

            {{-- CAMBIO: Agregamos max-height y overflow-y para crear la caja con scroll --}}
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover table-bordered align-middle">

                    {{-- CAMBIO: Agregamos position sticky, top 0 y z-index 1 para fijar el encabezado --}}
                    <thead class="table-dark" style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                        <th scope="col"><i class="bi bi-hash"></i> # Orden</th>
                        <th scope="col"><i class="bi bi-card-text"></i> Descripción</th>
                        <th scope="col"><i class="bi bi-calendar-event"></i> Fecha Inicio</th>
                        <th scope="col"><i class="bi bi-calendar-check"></i> Fecha Entrega</th>
                        <th scope="col"><i class="bi bi-activity"></i> Estado</th>
                        <th scope="col"><i class="bi bi-currency-dollar"></i> Costo</th>
                        <th scope="col" class="text-center"><i class="bi bi-printer"></i> Nota</th>
                        @if(auth()->user()->rol_usuario === 'tecnico')
                            <th scope="col" class="text-center"><i class="bi bi-gear-fill"></i> Acciones</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $fila)
                        <tr>
                            <td class="fw-bold"> <span class="badge bg-secondary">{{$fila->ID_rep}} </span></td>
                            <td> {{$fila->descripcion}} </td>
                            <td> {{$fila->fec_inicio}} </td>
                            <td> {{$fila->fec_est_entrega}} </td>
                            <td>
                                <i class="bi bi-info-circle me-1 text-primary"></i>
                                {{$fila->est_reparacion}}
                            </td>
                            <td class="fw-bold text-success">${{$fila->costo}}</td>
                            <td class="text-center">
                                @if(auth()->user()->rol_usuario === 'tecnico')
                                    <a class="btn btn-outline-danger btn-sm" href="{{route('reportes.nota', $fila->ID_rep)}}" target="_blank" role="button" title="Imprimir Nota">
                                        <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                                    </a>
                                @endif

                                @if(auth()->user()->rol_usuario === 'administrador')
                                    <a class="btn btn-outline-danger btn-sm" href="{{route('admon_reportes.nota', $fila->ID_rep)}}" target="_blank" role="button" title="Imprimir Nota">
                                        <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                                    </a>
                                @endif
                            </td>
                            @if(auth()->user()->rol_usuario === 'tecnico')
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        {{-- Asegúrate de tener una ruta llamada 'reparaciones.edit' o ajusta la URL --}}
                                        <a class="btn btn-warning btn-sm text-dark"
                                           href="{{-- route('reparaciones.edit', $fila->ID_rep) --}} /tecnico/Actualizar/{{$fila->ID_rep}}/edit"
                                           role="button"
                                           title="Actualizar Estado">
                                            <i class="bi bi-pencil-square"></i> Actualizar
                                        </a>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No hay reparaciones registradas en este momento.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
