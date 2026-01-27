@extends('cpanel/plantillaTecnicos')
@section('title', 'Inico')
@section('content')
    <div class="container-fluid py-4">

        {{-- 1. ENCABEZADO DE BIENVENIDA --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">Hola, {{ auth()->user()->datosTecnico-> nombre ?? 'tecnico' }} 👋</h2>
                <p class="text-muted">Aquí tienes tus reparaciones asignadas para hoy.</p>
            </div>
            <div class="date text-end">
            <span class="badge bg-light text-dark border px-3 py-2">
                <i class="bi bi-calendar-event me-2"></i>{{ now()->format('d M, Y') }}
            </span>
            </div>
        </div>

        {{-- 2. TARJETAS DE ESTADO (KPIs) --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold">Por Diagnosticar</h6>
                                {{-- Aquí mostramos el conteo de 'Pendiente' --}}
                                <h2 class="mb-0 fw-bold text-danger">{{ $stats['Pendiente'] ?? 0 }}</h2>
                            </div>
                            <div class="icon-box bg-danger bg-opacity-10 text-danger rounded-circle p-3">
                                <i class="bi bi-clipboard-pulse fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm border-start border-4 border-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold">En Taller</h6>
                                {{-- Aquí mostramos la suma de 'En revision' + 'En Reparacion' --}}
                                <h2 class="mb-0 fw-bold text-warning">{{ $stats['en_proceso'] ?? 0 }}</h2>
                            </div>
                            <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle p-3">
                                <i class="bi bi-tools fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold">Finalizados (Hoy)</h6>
                                <h2 class="mb-0 fw-bold text-success">{{ $stats['terminados'] ?? 0 }}</h2>
                            </div>
                            <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle p-3">
                                <i class="bi bi-check-circle-fill fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. TABLA DE TRABAJO --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-list-task me-2 text-primary"></i>Cola de Trabajo</h5>

                {{-- Filtro rápido (Opcional) --}}
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary active">Todos</button>
                    <button type="button" class="btn btn-outline-secondary">Urgentes</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
                    <tr>
                        <th scope="col">Folio</th>
                        <th scope="col">Dispositivo / Modelo</th>
                        <th scope="col">Falla Reportada</th>
                        <th scope="col">Fecha Ingreso</th>
                        <th scope="col" class="text-center">Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($reparaciones as $item)
                        <tr>
                            {{-- Usamos ID_rep --}}
                            <td class="fw-bold text-primary">#{{ $item->ID_rep }}</td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-2 text-secondary">
                                        {{-- Icono dinámico según el tipo --}}
                                        @if(strtolower($item->tipo) == 'laptop')
                                            <i class="bi bi-laptop"></i>
                                        @else
                                            <i class="bi bi-phone"></i>
                                        @endif
                                    </div>
                                    <div>
                                        {{-- Marca y Modelo --}}
                                        <div class="fw-bold">{{ $item->marca }} {{ $item->modelo }}</div>
                                        {{-- Nombre Cliente --}}
                                        <small class="text-muted">{{ $item->cliente_nombre }} {{ $item->cliente_apellido }}</small>
                                    </div>
                                </div>
                            </td>

                            <td class="text-wrap" style="max-width: 250px;">
                                {{-- Usamos 'descripcion' --}}
                                <span class="d-block text-truncate" title="{{ $item->descripcion }}">{{ $item->descripcion }}</span>
                            </td>

                            <td>
                                {{-- Usamos 'fec_inicio' --}}
                                <small class="d-block fw-bold">{{ \Carbon\Carbon::parse($item->fec_inicio)->format('d/m/Y') }}</small>
                                {{-- Calculamos días transcurridos --}}
                                <small class="text-muted">{{ \Carbon\Carbon::parse($item->fec_inicio)->diffForHumans() }}</small>
                            </td>

                            <td class="text-center">
                                @php
                                    // Actualizamos los colores para coincidir con tus nuevos valores
                                    $estadoColor = match($item->est_reparacion) {
                                        'Pendiente' => 'bg-danger text-white',
                                        'En revision' => 'bg-info text-dark',
                                        'En Reparacion' => 'bg-warning text-dark',
                                        'Terminado' => 'bg-success text-white',
                                        'Entregado' => 'bg-dark text-white',
                                        default => 'bg-light text-dark border'
                                    };
                                @endphp
                                <span class="badge rounded-pill {{ $estadoColor }} px-3 py-2">
        {{ $item->est_reparacion }}
    </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No hay reparaciones pendientes en el taller.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación (si aplica) --}}
            <div class="card-footer bg-white border-top-0 d-flex justify-content-end">
                {{-- {{ $reparaciones->links() }} --}}
            </div>
        </div>
    </div>
@endsection
