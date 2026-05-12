@php
    $layout = 'cpanel/plantilla';

    switch(auth()->user()->rol_usuario) {
        case 'tecnico':
            $layout = 'cpanel/plantillaTecnicos';
            break;
    }
@endphp

@extends($layout)
@section('title', 'Reparaciones')
@section('content')
    {{-- Contenedor principal que ocupa toda la altura disponible --}}
    <div class="container-fluid d-flex flex-column py-4" style="min-height: calc(100vh - 85px);">
        
        <div class="card shadow-sm border-0 rounded-4 bg-body flex-grow-1 d-flex flex-column overflow-hidden">
            
            {{-- ENCABEZADO DE LA TARJETA --}}
            <div class="card-header bg-transparent border-bottom pt-4 pb-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="card-title fw-bold text-body m-0">
                        <i class="bi bi-tools text-brand-blue me-2"></i>Gestión de Reparaciones
                    </h4>
                    <p class="text-secondary small mb-0 mt-1">Control y seguimiento del historial de equipos en el taller.</p>
                </div>
                
                <div class="d-flex flex-wrap gap-2">
                    {{-- Botones de Admin: Enfocados en reportes globales del historial --}}
                    @if(auth()->user()->rol_usuario === 'administrador')
                        <a class="btn btn-outline-danger fw-medium d-flex align-items-center shadow-sm" href="{{url('admon/reportes/reparaciones')}}" target="_blank" data-bs-toggle="tooltip" title="Generar PDF de todas las reparaciones">
                            <i class="bi bi-file-earmark-pdf-fill me-2"></i> Reporte PDF
                        </a>
                    @endif

                    {{-- Botones de Técnico (Intactos) --}}
                    @if(auth()->user()->rol_usuario === 'tecnico')
                        <a class="btn btn-brand-blue fw-bold shadow-sm d-flex align-items-center" href="/tecnico/reparaciones/create" style="background-color: #0d6efd; color: white;">
                            <i class="bi bi-plus-circle-fill me-2"></i> Nueva Reparación
                        </a>
                    @endif
                </div>
            </div>

            {{-- BARRA DE BÚSQUEDA (Optimizador de flujo para Admin y Técnico) --}}
            <div class="px-4 py-3 border-bottom bg-body-tertiary">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group shadow-sm border border-subtle bg-body rounded-pill overflow-hidden">
                            <span class="input-group-text bg-transparent border-0 text-brand-purple ps-4">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="searchHistorial" class="form-control border-0 shadow-none bg-transparent py-2" placeholder="Buscar folio, descripción o estado...">
                        </div>
                    </div>
                </div>
            </div>

            {{-- CUERPO DE LA TARJETA (Flex para estirar la tabla en el espacio sobrante) --}}
            <div class="card-body p-0 d-flex flex-column flex-grow-1" style="height: 0;">
                
                {{-- Contenedor de la tabla con Scroll automático --}}
                <div class="table-responsive flex-grow-1" style="overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0" id="tablaReparaciones">
                        
                        {{-- Encabezado pegajoso (Sticky) --}}
                        <thead class="table-light text-secondary small text-uppercase" style="position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th scope="col" class="ps-4 fw-semibold border-0 py-3 text-center" style="width: 90px;">Folio</th>
                                <th scope="col" class="fw-semibold border-0 py-3"><i class="bi bi-card-text me-1"></i> Descripción</th>
                                <th scope="col" class="fw-semibold border-0 py-3"><i class="bi bi-calendar3 me-1"></i> Ingreso</th>
                                <th scope="col" class="fw-semibold border-0 py-3"><i class="bi bi-calendar-check me-1"></i> Entrega</th>
                                <th scope="col" class="fw-semibold border-0 py-3 text-center">Estado</th>
                                <th scope="col" class="fw-semibold border-0 py-3 text-end"><i class="bi bi-currency-dollar me-1"></i> Costo</th>
                                <th scope="col" class="text-center pe-4 fw-semibold border-0 py-3" style="width: 160px;">Acciones</th>
                            </tr>
                        </thead>
                        
                        <tbody class="border-top-0">
                            @forelse($data as $fila)
                                @php
                                    // Lógica para colores de las insignias según estado
                                    $badgeColor = 'secondary';
                                    $iconStatus = 'bi-clock-history';
                                    
                                    if(strtolower($fila->est_reparacion) == 'en revision') {
                                        $badgeColor = 'warning';
                                        $iconStatus = 'bi-search';
                                    } elseif(strtolower($fila->est_reparacion) == 'en reparacion') {
                                        $badgeColor = 'primary';
                                        $iconStatus = 'bi-wrench-adjustable';
                                    } elseif(strtolower($fila->est_reparacion) == 'terminado') {
                                        $badgeColor = 'success';
                                        $iconStatus = 'bi-check-circle-fill';
                                    } elseif(strtolower($fila->est_reparacion) == 'entregado') {
                                        $badgeColor = 'dark';
                                        $iconStatus = 'bi-bag-check-fill';
                                    }
                                    
                                    // Folio con ceros a la izquierda
                                    $folioStr = str_pad($fila->ID_rep, 5, '0', STR_PAD_LEFT);
                                @endphp

                                <tr class="reparacion-row">
                                    {{-- Folio --}}
                                    <td class="ps-4 text-center">
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2 py-1 folio-text">
                                            #{{ $folioStr }}
                                        </span>
                                    </td>

                                    {{-- Descripción --}}
                                    <td>
                                        <span class="d-inline-block text-truncate text-body desc-text" style="max-width: 250px;" title="{{$fila->descripcion}}">
                                            {{$fila->descripcion}}
                                        </span>
                                    </td>

                                    {{-- Fechas --}}
                                    <td class="text-body fw-medium" style="font-size: 0.9rem;">
                                        {{ \Carbon\Carbon::parse($fila->fec_inicio)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-body fw-medium" style="font-size: 0.9rem;">
                                        {{ \Carbon\Carbon::parse($fila->fec_est_entrega)->format('d/m/Y') }}
                                    </td>

                                    {{-- Estado (Badge dinámico) --}}
                                    <td class="text-center estado-text">
                                        <span class="badge rounded-pill bg-{{$badgeColor}} bg-opacity-10 text-{{$badgeColor == 'warning' ? 'warning-emphasis' : $badgeColor}} border border-{{$badgeColor}}-subtle px-3 py-2 text-uppercase fw-bold" style="font-size: 0.75rem;">
                                            <i class="bi {{$iconStatus}} me-1"></i> {{$fila->est_reparacion}}
                                        </span>
                                    </td>

                                    {{-- Costo --}}
                                    <td class="text-end fw-bold text-success fs-6">
                                        ${{ number_format($fila->costo, 2) }}
                                    </td>

                                    {{-- Acciones (Botones agrupados) --}}
                                    <td class="text-center pe-4">
                                        <div class="btn-group shadow-sm" role="group">
                                            
                                            {{-- ========================================== --}}
                                            {{-- ACCIONES DE ADMINISTRADOR                    --}}
                                            {{-- ========================================== --}}
                                            @if(auth()->user()->rol_usuario === 'administrador')
                                                {{-- Ver Historial --}}
                                                <a class="btn btn-sm btn-light border text-info hover-info" href="{{url('/admon/reparaciones/'.$fila->ID_rep)}}" data-bs-toggle="tooltip" title="Ver Detalles del Historial">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                                {{-- Editar Registro --}}
                                                <a class="btn btn-sm btn-light border text-primary hover-primary" href="{{url('/admon/reparaciones/'.$fila->ID_rep.'/edit')}}" data-bs-toggle="tooltip" title="Editar Registro">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                {{-- Generar PDF --}}
                                                <a class="btn btn-sm btn-light border text-danger hover-danger" href="{{route('admon_reportes.nota', $fila->ID_rep)}}" target="_blank" data-bs-toggle="tooltip" title="Generar Nota PDF">
                                                    <i class="bi bi-file-pdf-fill"></i>
                                                </a>
                                                
                                                {{-- Eliminar (Limpiar historial) MODIFICADO PARA SWEETALERT --}}
                                                <form action="{{url('/admon/reparaciones', $fila->ID_rep)}}" method="post" class="d-inline m-0 p-0 form-delete">
                                                    @csrf
                                                    {{method_field('DELETE')}}
                                                    <button class="btn btn-sm btn-light border text-danger hover-danger btn-delete" type="button" data-folio="{{$folioStr}}" data-bs-toggle="tooltip" title="Eliminar del Historial">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- ========================================== --}}
                                            {{-- ACCIONES DE TÉCNICO                        --}}
                                            {{-- ========================================== --}}
                                           @if(auth()->user()->rol_usuario === 'tecnico')
                                                <a class="btn btn-sm btn-light border text-danger hover-danger" href="{{route('reportes.nota', $fila->ID_rep)}}" target="_blank" data-bs-toggle="tooltip" title="Generar Nota PDF">
                                                    <i class="bi bi-file-pdf-fill"></i>
                                                </a>
                                                <a class="btn btn-sm btn-light border text-primary hover-primary" href="/tecnico/Actualizar/{{$fila->ID_rep}}/edit" data-bs-toggle="tooltip" title="Actualizar Estado">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyStateRow">
                                    <td colspan="7" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                                <i class="bi bi-tools display-4 text-secondary opacity-50"></i>
                                            </div>
                                            <h5 class="fw-bold text-body mb-1">El historial está vacío</h5>
                                            <p class="text-secondary mb-0">Aún no hay equipos registrados en la base de datos.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Colores marca */
        .text-brand-purple { color: #6f42c1 !important; }
        
        /* Efectos hover sutiles para los botones de acción en la tabla */
        .hover-info:hover { background-color: #0dcaf0 !important; color: white !important; border-color: #0dcaf0 !important; }
        .hover-primary:hover { background-color: #0d6efd !important; color: white !important; border-color: #0d6efd !important; }
        .hover-danger:hover { background-color: #dc3545 !important; color: white !important; border-color: #dc3545 !important; }
    </style>

    {{-- LIBRERÍA SWEETALERT 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   {{-- LIBRERÍA SWEETALERT 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Inicializar tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // 2. Buscador en tiempo real para optimizar gestión
            const searchInput = document.getElementById('searchHistorial');
            const rows = document.querySelectorAll('.reparacion-row');

            if(searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const term = this.value.toLowerCase().trim();

                    rows.forEach(row => {
                        const folio = row.querySelector('.folio-text').innerText.toLowerCase();
                        const desc = row.querySelector('.desc-text').innerText.toLowerCase();
                        const estado = row.querySelector('.estado-text').innerText.toLowerCase();

                        // Mostrar si coincide con folio, descripción o estado
                        if(folio.includes(term) || desc.includes(term) || estado.includes(term)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // 3. Confirmación de Eliminación (Modal Centrado)
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    const folio = this.getAttribute('data-folio');
                    
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: `Eliminarás el registro ${folio} del historial. Esta acción es irreversible.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="bi bi-trash3-fill"></i> Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // 4. Alerta Modal Centrada de Éxito
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación Exitosa!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#0d6efd', // Azul primario
                    timer: 3500,
                    timerProgressBar: true
                });
            @endif

            // 5. Alerta Modal Centrada de Error
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Ha ocurrido un problema',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc3545' // Rojo peligro
                });
            @endif
        });
    </script>
@endsection