@extends('cpanel.plantilla')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid py-4">

        {{-- 1. ENCABEZADO --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">Dashboard General</h2>
                <p class="text-muted mb-0">Resumen de operaciones  {{ date('d-m-Y') }}</p>
            </div>
        </div>

        {{-- 2. TARJETAS DE ESTADÍSTICAS (KPIs) --}}
        <div class="row g-3 mb-4">
            {{-- Ingresos --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="text-muted small fw-bold text-uppercase">Ingresos Totales</div>
                            <div class="icon-shape bg-success bg-opacity-10 text-success rounded p-2">
                                <i class="bi bi-currency-dollar fs-5"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1">${{ number_format($ingresosTotales, 2) }}</h3>
                        <span class="badge bg-success bg-opacity-10 text-success small">Acumulado</span>
                    </div>
                </div>
            </div>

            {{-- En Reparación --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="text-muted small fw-bold text-uppercase">En Taller</div>
                            <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded p-2">
                                <i class="bi bi-tools fs-5"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $enReparacion }}</h3>
                        <span class="text-muted small">Equipos trabajando</span>
                    </div>
                </div>
            </div>

            {{-- Clientes --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="text-muted small fw-bold text-uppercase">Clientes</div>
                            <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded p-2">
                                <i class="bi bi-people-fill fs-5"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $totalClientes }}</h3>
                        <span class="text-muted small">Registrados</span>
                    </div>
                </div>
            </div>

            {{-- Entregados --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="text-muted small fw-bold text-uppercase">Entregados</div>
                            <div class="icon-shape bg-info bg-opacity-10 text-info rounded p-2">
                                <i class="bi bi-check-circle-fill fs-5"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $entregados }}</h3>
                        <span class="text-muted small">Total histórico</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. SECCIÓN DE GRÁFICOS --}}
        <div class="row g-3 mb-4">

            {{-- GRÁFICO 2: Estado del Taller --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h6 class="mb-0 fw-bold">Estado Actual de Equipos</h6>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <div style="width: 100%; max-width: 300px;">
                            <canvas id="chartEstados"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GRÁFICO 3: Clientes vs Usuarios --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h6 class="mb-0 fw-bold">Usuarios del Sistema</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartClientesUsuarios"></canvas>
                        <div class="mt-3 text-center small text-muted">
                            Comparativa entre personal administrativo/técnico y clientes finales.
                        </div>
                    </div>
                </div>
            </div>

            {{-- GRÁFICO 1: Tendencia de Reparaciones --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold">Tendencia de Ingresos ({{ date('Y') }})</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartReparaciones" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. TABLA DE ÚLTIMOS INGRESOS --}}
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">Últimos 5 Ingresos</h6>
                        <a href="/admon/reparaciones" class="btn btn-sm btn-light text-primary fw-bold">Ver todos</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4">Dispositivo</th>
                                <th>Cliente</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($ultimosIngresos as $item)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark">{{ $item->dispositivo->modelo }}</span>
                                        <br><small class="text-muted">{{ $item->dispositivo->marca }}</small>
                                    </td>
                                    <td>
                                        {{ $item->dispositivo->cliente->nombre }} {{ $item->dispositivo->cliente->apellido }}
                                    </td>
                                    <td>
                                        @php
                                            $color = 'secondary';
                                            if($item->est_reparacion == 'En revision') $color = 'warning text-dark';
                                            if($item->est_reparacion == 'En Reparacion') $color = 'primary';
                                            if($item->est_reparacion == 'Terminado') $color = 'success';
                                            if($item->est_reparacion == 'Entregado') $color = 'dark';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">{{ $item->est_reparacion }}</span>
                                    </td>
                                    <td class="small text-muted">
                                        {{ \Carbon\Carbon::parse($item->fec_inicio)->format('d M') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No hay registros recientes</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Accesos Rápidos --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-primary text-white h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Accesos Rápidos</h5>
                        <div class="d-grid gap-3">
                            <a href="/admon/clientes" class="btn btn-light text-start p-3 fw-bold text-primary shadow-sm hover-scale">
                                <i class="bi bi-people-fill me-2"></i> Gestión de Clientes
                            </a>
                            <a href="/admon/usuarios" class="btn btn-outline-light text-start p-3 fw-bold hover-scale">
                                <i class="bi bi-shield-lock-fill me-2"></i> Gestión de Staff
                            </a>
                            <a href="{{ route('admon.respaldos') }}" class="btn btn-outline-light text-start p-3 fw-bold hover-scale">
                                <i class="bi bi-database-down me-2"></i> Respaldo de BD
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        .icon-shape { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; }
        .hover-scale { transition: transform 0.2s; }
        .hover-scale:hover { transform: scale(1.02); }
    </style>

    {{-- CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // --- GRÁFICO 1: TENDENCIA MENSUAL ---
            const ctxRep = document.getElementById('chartReparaciones');
            if (ctxRep) {
                new Chart(ctxRep.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        datasets: [{
                            label: 'Reparaciones',

                            data: @json($dataTendencia),
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            tension: 0.3,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                    }
                });
            }

            // --- GRÁFICO 2: ESTADOS (DONA) ---
            const ctxEstados = document.getElementById('chartEstados');
            if (ctxEstados) {
                new Chart(ctxEstados.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Pendientes', 'En Revisión', 'En Taller', 'Listos', 'Entregados'],
                        datasets: [{
                            data: [
                                {{ $pendientes }},
                                {{ $enRevision }},
                                {{ $enReparacion }},
                                {{ $terminados }},
                                {{ $entregados }}
                            ],
                            backgroundColor: ['#6c757d', '#ffc107', '#0d6efd', '#198754', '#212529'],
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        cutout: '75%',
                        plugins: {
                            legend: { position: 'bottom', labels: { boxWidth: 12, padding: 15 } }
                        }
                    }
                });
            }

            // --- GRÁFICO 3: CLIENTES VS STAFF ---
            const ctxUsers = document.getElementById('chartClientesUsuarios');
            if (ctxUsers) {
                new Chart(ctxUsers.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Clientes', 'Staff Interno'],
                        datasets: [{
                            label: 'Total',
                            data: [{{ $totalClientes }}, {{ $totalStaff }}],
                            backgroundColor: ['rgba(13, 110, 253, 0.8)', 'rgba(33, 37, 41, 0.8)'],
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                    }
                });
            }
        });
    </script>
@endsection
