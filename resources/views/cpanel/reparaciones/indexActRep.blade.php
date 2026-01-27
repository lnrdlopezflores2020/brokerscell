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

            {{-- Encabezado y Botones Superiores --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title h1 m-0"><i class="bi bi-tools me-2"></i>Reparaciones</h4>
                <div>
                    @if(auth()->user()->rol_usuario === 'administrador')
                        <a class="btn btn-success me-2" href="{{url('admon/reportes/pdfClientes')}}" target="_blank" role="button">
                            <i class="bi bi-file-earmark-pdf"></i> Reporte PDF
                        </a>
                    @endif

                </div>
            </div>

            {{-- 1. BARRA DE BÚSQUEDA AÑADIDA --}}
            <div class="row mb-3">
                <div class="col-md-6 col-lg-4">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text"
                                   name="busqueda"
                                   class="form-control border-start-0 ps-0"
                                   placeholder="Buscar por # Orden..."
                                   value="{{ request('busqueda') }}">
                            <button class="btn btn-dark" type="submit">Buscar</button>

                            @if(request('busqueda'))
                                <a href="{{ url()->current() }}" class="btn btn-outline-secondary" title="Limpiar filtro">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col"><i class="bi bi-hash"></i> # Orden</th>
                        <th scope="col"><i class="bi bi-card-text"></i> Descripción</th>
                        <th scope="col"><i class="bi bi-calendar-event"></i> Fecha Inicio</th>
                        <th scope="col"><i class="bi bi-calendar-check"></i> Fecha Entrega</th>
                        <th scope="col"><i class="bi bi-activity"></i> Estado</th>
                        <th scope="col"><i class="bi bi-currency-dollar"></i> Costo</th>
                        {{-- Cambié el encabezado de la columna --}}
                        <th scope="col" class="text-center"><i class="bi bi-sliders"></i> Acciones</th>
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

                            {{-- 2. BOTÓN CAMBIADO (PDF -> ACTUALIZAR) --}}
                            <td class="text-center">

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No se encontraron reparaciones con ese criterio.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación (opcional, si la usas) --}}
            <div class="d-flex justify-content-end mt-3">
                {{-- {{$data->links()}} --}}
            </div>
        </div>
    </div>
@endsection
