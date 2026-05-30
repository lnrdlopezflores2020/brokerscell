@extends('cpanel/plantilla')
@section('title','Usuarios')
@section('content')
    {{-- Contenedor principal que ocupa toda la altura disponible --}}
    <div class="container-fluid d-flex flex-column py-4" style="min-height: calc(100vh - 85px);">
        
        <div class="card shadow-sm border-0 rounded-4 bg-body flex-grow-1 d-flex flex-column overflow-hidden">
            
            {{-- ENCABEZADO DE LA TARJETA --}}
            <div class="card-header bg-transparent border-bottom pt-4 pb-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="card-title fw-bold text-body m-0">
                        <i class="bi bi-people-fill text-primary me-2"></i>Gestión de Usuarios
                    </h4>
                    <p class="text-secondary small mb-0 mt-1">Administra los accesos y roles del sistema.</p>
                </div>
                
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-outline-success fw-medium d-flex align-items-center shadow-sm" href="{{ url('/admon/reportes/usuarios/excel') }}" target="_blank">
                        <i class="bi bi-file-earmark-excel-fill me-2"></i> Reporte Excel
                    </a>
                    <a class="btn btn-primary fw-bold shadow-sm d-flex align-items-center" href="/admon/usuarios/create">
                        <i class="bi bi-plus-circle-fill me-2"></i> Nuevo Usuario
                    </a>
                </div>
            </div>

            {{-- CUERPO DE LA TARJETA --}}
            <div class="card-body p-0 d-flex flex-column flex-grow-1" style="height: 0;">
                
                {{-- Contenedor de la tabla con Scroll automático --}}
                <div class="table-responsive flex-grow-1" style="overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        
                        {{-- Encabezado pegajoso --}}
                        <thead class="table-light text-secondary small text-uppercase" style="position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th scope="col" class="ps-4 fw-semibold border-0 py-3 text-center" style="width: 80px;">ID</th>
                                <th scope="col" class="fw-semibold border-0 py-3"><i class="bi bi-envelope me-1"></i> Email / Correo</th>
                                <th scope="col" class="fw-semibold border-0 py-3 text-center">Rol de Acceso</th>
                                <th scope="col" class="text-center pe-4 fw-semibold border-0 py-3" style="width: 150px;">Acciones</th>
                            </tr>
                        </thead>
                        
                        <tbody class="border-top-0">
                            @forelse($data as $fila)
                                <tr>
                                    {{-- ID --}}
                                    <td class="ps-4 text-center">
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle">
                                            #{{ str_pad($fila->ID_usuario, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>

                                    {{-- Correo --}}
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center me-3 flex-shrink-0" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person-fill fs-5"></i>
                                            </div>
                                            <a href="mailto:{{$fila->emai}}" class="text-decoration-none text-body fw-medium text-break">
                                                {{$fila->emai}}
                                            </a>
                                        </div>
                                    </td>

                                    {{-- Rol con Badge Dinámico --}}
                                    <td class="text-center">
                                        @if(strtolower($fila->rol_usuario) == 'admin' || strtolower($fila->rol_usuario) == 'administrador')
                                            <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger-subtle px-3 py-2 text-uppercase fw-bold">
                                                <i class="bi bi-shield-lock-fill me-1"></i>{{$fila->rol_usuario}}
                                            </span>
                                        @elseif(strtolower($fila->rol_usuario) == 'tecnico')
                                            <span class="badge rounded-pill bg-info bg-opacity-10 text-info border border-info-subtle px-3 py-2 text-uppercase fw-bold">
                                                <i class="bi bi-wrench-adjustable me-1"></i>{{$fila->rol_usuario}}
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary-subtle px-3 py-2 text-uppercase fw-bold">
                                                <i class="bi bi-person-fill me-1"></i>{{$fila->rol_usuario}}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="text-center pe-4">
                                        <div class="btn-group shadow-sm" role="group">
                                            <a class="btn btn-sm btn-light border text-primary hover-primary" href="{{url('/admon/usuarios/'.$fila->ID_usuario.'/edit')}}" data-bs-toggle="tooltip" title="Editar Usuario">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            {{-- PROTECCIÓN CONTRA ELIMINACIÓN DE ADMINISTRADORES --}}
                                            @if(strtolower($fila->rol_usuario) == 'admin' || strtolower($fila->rol_usuario) == 'administrador')
                                                <button type="button" class="btn btn-sm btn-light border text-muted" disabled data-bs-toggle="tooltip" title="Acción bloqueada: No se puede eliminar a un administrador." style="cursor: not-allowed;">
                                                    <i class="bi bi-lock-fill"></i>
                                                </button>
                                            @else
                                                {{-- Formulario de eliminación adaptado para SweetAlert --}}
                                                <form action="{{url('/admon/usuarios', $fila->ID_usuario)}}" method="post" class="d-inline m-0 p-0 form-delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-light border text-danger hover-danger btn-delete" type="button" 
                                                            data-email="{{$fila->emai}}" data-bs-toggle="tooltip" title="Eliminar Usuario">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                                <i class="bi bi-shield-x display-4 text-secondary opacity-50"></i>
                                            </div>
                                            <h5 class="fw-bold text-body mb-1">No hay usuarios registrados</h5>
                                            <p class="text-secondary mb-0">El sistema requiere al menos un administrador activo.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ZONA DE PAGINACIÓN --}}
            <div class="card-footer bg-white border-top d-flex justify-content-center pt-4 pb-2">
                {{ $data->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>

    <style>
        /* Efectos hover para los botones de acción */
        .hover-primary:hover { background-color: #0d6efd !important; color: white !important; border-color: #0d6efd !important; }
        .hover-danger:hover { background-color: #dc3545 !important; color: white !important; border-color: #dc3545 !important; }
    </style>

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
                        const folio = row.querySelector('.folio-text')?.innerText.toLowerCase() || '';
                        const desc = row.querySelector('.desc-text')?.innerText.toLowerCase() || '';
                        const estado = row.querySelector('.estado-text')?.innerText.toLowerCase() || '';

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
                    const email = this.getAttribute('data-email');
                    
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: `Eliminarás al usuario con correo ${email}. Esta acción es irreversible.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="bi bi-trash3-fill"></i> Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        backdrop: `rgba(0,0,0,0.4)`
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
                    timerProgressBar: true,
                    backdrop: `rgba(0,0,0,0.4)`
                });
            @endif

            // 5. Alerta Modal Centrada de Error
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Ha ocurrido un problema',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc3545', // Rojo peligro
                    backdrop: `rgba(0,0,0,0.4)`
                });
            @endif
        });
    </script>
@endsection