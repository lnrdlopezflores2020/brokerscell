@extends('cpanel.plantilla')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid py-4">

        {{-- 1. ENCABEZADO --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold text-dark mb-1">
                    <i class="bi bi-grid-1x2-fill text-primary me-2"></i>Dashboard General
                </h2>
                <p class="text-muted mb-0">Resumen de operaciones del taller • {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</p>
            </div>
            <div>
                <button class="btn btn-white border shadow-sm rounded-pill px-4" onclick="window.location.reload();">
                    <i class="bi bi-arrow-clockwise me-2"></i>Actualizar Datos
                </button>
            </div>
        </div>

        {{-- 2. TARJETAS DE ESTADÍSTICAS (KPIs) --}}
        <div class="row g-4 mb-4">
            {{-- Ingresos --}}
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="text-muted small fw-bold text-uppercase tracking-wide">Ingresos Totales</div>
                            <div class="icon-shape bg-success bg-opacity-10 text-success rounded-circle">
                                <i class="bi bi-currency-dollar fs-4"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1 text-dark">${{ number_format($ingresosTotales, 2) }}</h3>
                        <div class="d-flex align-items-center mt-2">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill small fw-medium px-2 py-1">Acumulado</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- En Reparación --}}
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="text-muted small fw-bold text-uppercase tracking-wide">En Taller</div>
                            <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-circle">
                                <i class="bi bi-tools fs-4"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1 text-dark">{{ $enReparacion }}</h3>
                        <div class="d-flex align-items-center mt-2">
                            <span class="text-muted small fw-medium">Equipos trabajando</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Clientes --}}
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="text-muted small fw-bold text-uppercase tracking-wide">Clientes</div>
                            <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle">
                                <i class="bi bi-people-fill fs-4"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1 text-dark">{{ $totalClientes }}</h3>
                        <div class="d-flex align-items-center mt-2">
                            <span class="text-muted small fw-medium">Registrados en sistema</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Entregados --}}
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="text-muted small fw-bold text-uppercase tracking-wide">Entregados</div>
                            <div class="icon-shape bg-info bg-opacity-10 text-info rounded-circle">
                                <i class="bi bi-check-circle-fill fs-4"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1 text-dark">{{ $entregados }}</h3>
                        <div class="d-flex align-items-center mt-2">
                            <span class="text-muted small fw-medium">Total histórico</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. SECCIÓN DE GRÁFICOS --}}
        <div class="row g-4 mb-4">
            
            {{-- GRÁFICO 1: Tendencia de Reparaciones (Moviendo el principal arriba) --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                        <h6 class="mb-0 fw-bold text-dark fs-5">Tendencia de Ingresos ({{ date('Y') }})</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas id="chartReparaciones"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GRÁFICO 2: Estado del Taller --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="mb-0 fw-bold text-dark fs-5">Estado Actual de Equipos</h6>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center p-4">
                        <div style="position: relative; height: 250px; width: 100%; display: flex; justify-content: center;">
                            <canvas id="chartEstados"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GRÁFICO 3: Clientes vs Usuarios --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="mb-0 fw-bold text-dark fs-5">Usuarios del Sistema</h6>
                    </div>
                    <div class="card-body p-4">
                        <div style="position: relative; height: 220px; width: 100%;">
                            <canvas id="chartClientesUsuarios"></canvas>
                        </div>
                        <div class="mt-3 text-center small text-muted fw-medium">
                            Comparativa entre personal de staff y clientes.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. TABLA Y ACCESOS RÁPIDOS --}}
        <div class="row g-4">
            <div class="col-xl-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-bottom pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-dark fs-5">Últimos 5 Ingresos</h6>
                        <a href="/admon/reparaciones" class="btn btn-sm btn-light text-primary fw-bold rounded-pill px-3">Ver todos</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary small text-uppercase">
                            <tr>
                                <th class="ps-4 py-3 fw-semibold border-0">Dispositivo</th>
                                <th class="py-3 fw-semibold border-0">Cliente</th>
                                <th class="py-3 fw-semibold border-0">Estado</th>
                                <th class="pe-4 py-3 fw-semibold border-0 text-end">Fecha</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($ultimosIngresos as $item)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-2 me-3 text-secondary">
                                                <i class="bi bi-phone"></i>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block">{{ $item->dispositivo->modelo }}</span>
                                                <small class="text-muted">{{ $item->dispositivo->marca }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 fw-medium text-dark">
                                        {{ $item->dispositivo->cliente->nombre }} {{ $item->dispositivo->cliente->apellido }}
                                    </td>
                                    <td class="py-3">
                                        @php
                                            $estadoProps = match($item->est_reparacion) {
                                                'Pendiente' => 'bg-danger text-danger',
                                                'En revision' => 'bg-info text-info',
                                                'En Reparacion' => 'bg-warning text-warning',
                                                'Terminado' => 'bg-success text-success',
                                                'Entregado' => 'bg-dark text-dark',
                                                default => 'bg-secondary text-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $estadoProps }} bg-opacity-10 rounded-pill px-3 py-2 fw-bold">
                                            <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem; vertical-align: middle;"></i>
                                            {{ $item->est_reparacion }}
                                        </span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <span class="fw-medium text-dark">{{ \Carbon\Carbon::parse($item->fec_inicio)->format('d M') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                        No hay registros recientes
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Accesos Rápidos --}}
            <div class="col-xl-4">
                <div class="card border-0 shadow-sm bg-primary text-white h-100 rounded-4 relative overflow-hidden">
                    {{-- Elemento decorativo de fondo --}}
                    <div class="position-absolute top-0 end-0 opacity-10 p-5" style="transform: translate(20%, -20%);">
                        <i class="bi bi-lightning-charge-fill" style="font-size: 15rem;"></i>
                    </div>
                    
                    <div class="card-body p-4 position-relative z-1">
                        <h5 class="fw-bold mb-4 fs-4">Accesos Rápidos</h5>
                        <p class="text-white-50 mb-4 small">Navega a los módulos principales de administración rápidamente.</p>
                        
                        <div class="d-grid gap-3">
                            <a href="/admon/clientes" class="btn btn-light text-start p-3 fw-bold text-primary shadow-sm hover-lift rounded-3 d-flex align-items-center justify-content-between">
                                <span><i class="bi bi-people-fill me-2 fs-5"></i> Gestión de Clientes</span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>
                            <a href="/admon/usuarios" class="btn bg-white bg-opacity-10 text-white text-start p-3 fw-bold hover-lift rounded-3 border-0 d-flex align-items-center justify-content-between">
                                <span><i class="bi bi-shield-lock-fill me-2 fs-5"></i> Gestión de Staff</span>
                                <i class="bi bi-chevron-right text-white-50"></i>
                            </a>
                            <a href="/admon/reparaciones/create" class="btn bg-white bg-opacity-10 text-white text-start p-3 fw-bold hover-lift rounded-3 border-0 d-flex align-items-center justify-content-between mt-2">
                                <span><i class="bi bi-plus-circle-fill me-2 fs-5"></i> Nueva Reparación</span>
                                <i class="bi bi-chevron-right text-white-50"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        .icon-shape { width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; }
        .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
        .tracking-wide { letter-spacing: 0.05em; }
    </style>

    {{-- CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            // Configuración global de fuentes para Chart.js
            Chart.defaults.font.family = "'Poppins', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif";
            Chart.defaults.color = '#6c757d';

            // --- GRÁFICO 1: TENDENCIA MENSUAL ---
            const ctxRep = document.getElementById('chartReparaciones');
            if (ctxRep) {
                // Crear un gradiente para el gráfico de línea
                const gradient = ctxRep.getContext('2d').createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(13, 110, 253, 0.4)');
                gradient.addColorStop(1, 'rgba(13, 110, 253, 0.0)');

                new Chart(ctxRep.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        datasets: [{
                            label: 'Reparaciones',
                            data: @json($dataTendencia),
                            borderColor: '#0d6efd',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            tension: 0.4, // Curvas más suaves
                            fill: true,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#0d6efd',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                padding: 12,
                                titleFont: { size: 13 },
                                bodyFont: { size: 14, weight: 'bold' },
                                displayColors: false,
                                cornerRadius: 8
                            }
                        },
                        scales: { 
                            x: { grid: { display: false } },
                            y: { 
                                beginAtZero: true, 
                                ticks: { stepSize: 1 },
                                border: { display: false }
                            } 
                        }
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
                            backgroundColor: ['#dc3545', '#0dcaf0', '#ffc107', '#198754', '#212529'],
                            borderWidth: 0,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: { 
                                position: 'right', 
                                labels: { usePointStyle: true, boxWidth: 8, padding: 20, font: { size: 12 } } 
                            }
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
                            backgroundColor: ['#0d6efd', '#212529'],
                            borderRadius: 8,
                            barThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { 
                            x: { grid: { display: false } },
                            y: { beginAtZero: true, ticks: { stepSize: 1 }, border: { display: false } } 
                        }
                    }
                });
            }
        });
    </script>
@endsection