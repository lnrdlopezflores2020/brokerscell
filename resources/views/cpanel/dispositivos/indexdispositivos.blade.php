@php
    $layout = 'cpanel/plantilla'; // Plantilla por defecto (ej. para admin)

    switch(auth()->user()->rol_usuario) {
        case 'tecnico':
            $layout = 'cpanel/plantillaTecnicos'; // Ruta a la plantilla de técnico
            break;
    }
@endphp
@extends($layout)
@section('title', 'dispositivos')
@section('content')
    {{-- Contenedor principal adaptable a la altura de la pantalla --}}
    <div class="container-fluid py-4 d-flex flex-column" style="min-height: calc(100vh - 80px);">
        
        <div class="card shadow-sm border-0 rounded-4 bg-body flex-grow-1 d-flex flex-column overflow-hidden">
            
            {{-- Barra decorativa superior --}}
            <div style="height: 6px; background: linear-gradient(90deg, #0d6efd, #0d6efd);"></div>

            {{-- ENCABEZADO DE LA TARJETA --}}
            <div class="card-header bg-transparent border-bottom pt-4 pb-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="card-title fw-bold text-body m-0">
                        <i class="bi bi-pc-display-horizontal text-brand-purple me-2"></i>Gestión de Dispositivos
                    </h4>
                    <p class="text-secondary small mb-0 mt-1">Directorio de equipos registrados en el sistema.</p>
                </div>
                <div>
                    <a class="btn btn-brand-purple fw-bold shadow-sm d-flex align-items-center" href="{{url('/tecnico/dispositivos/create')}}">
                        <i class="bi bi-plus-circle-fill me-2"></i> Agregar Dispositivo
                    </a>
                </div>
            </div>
            
            {{-- CUERPO DE LA TARJETA (Flex para habilitar el scroll dinámico) --}}
            <div class="card-body p-0 d-flex flex-column flex-grow-1" style="height: 0;">
                
                {{-- Contenedor de la tabla con Scroll automático --}}
                <div class="table-responsive flex-grow-1" style="overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        
                        {{-- Encabezado pegajoso estilo moderno --}}
                        <thead class="table-light text-secondary small text-uppercase" style="position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th scope="col" class="ps-4 fw-semibold border-0 py-3 text-center" style="width: 100px;"><i class="bi bi-hash"></i> ID</th>
                                <th scope="col" class="fw-semibold border-0 py-3"><i class="bi bi-laptop me-1"></i> Tipo</th>
                                <th scope="col" class="fw-semibold border-0 py-3"><i class="bi bi-tag-fill me-1"></i> Marca</th>
                                <th scope="col" class="fw-semibold border-0 py-3"><i class="bi bi-cpu me-1"></i> Modelo</th>
                                <th scope="col" class="text-center pe-4 fw-semibold border-0 py-3" style="width: 150px;"><i class="bi bi-gear-fill me-1"></i> Acciones</th>
                            </tr>
                        </thead>
                        
                        <tbody class="border-top-0">
                        @forelse($data as $fila)
                            <tr>
                                {{-- ID Badge --}}
                                <td class="ps-4 text-center py-3">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2 py-1">
                                        <i class="bi bi-qr-code me-1"></i>{{ str_pad($fila->ID_tel, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                
                                {{-- Datos --}}
                                <td class="text-body fw-medium"> {{$fila->tipo}} </td>
                                <td class="text-body"> <i class="bi bi-patch-check text-brand-purple opacity-75 me-1"></i>{{$fila->marca}} </td>
                                <td class="text-body"> {{$fila->modelo}} </td>
                                
                                {{-- Acciones --}}
                                <td class="text-center pe-4">
                                    <div class="btn-group shadow-sm" role="group">
                                        {{-- Botón Editar --}}
                                        <a class="btn btn-sm btn-light border text-primary hover-primary px-3" href="{{url('/tecnico/dispositivos/'.$fila->ID_tel.'/edit')}}" data-bs-toggle="tooltip" title="Editar Dispositivo">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- Formulario Eliminar con SweetAlert --}}
                                        <form action="{{url('/tecnico/dispositivos/' . $fila->ID_tel) }}" method="POST" class="d-inline m-0 p-0 form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-light border text-danger hover-danger btn-delete px-3" type="button"
                                                    data-marca="{{$fila->marca}}" 
                                                    data-modelo="{{$fila->modelo}}"
                                                    data-bs-toggle="tooltip" title="Eliminar Dispositivo">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- Estado Vacío (Empty State) --}}
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                            <i class="bi bi-phone display-4 text-secondary opacity-50"></i>
                                        </div>
                                        <h5 class="fw-bold text-body mb-1">No hay dispositivos registrados</h5>
                                        <p class="text-secondary mb-3">Comienza agregando un equipo nuevo al sistema.</p>
                                        <a class="btn btn-brand-blue rounded-pill px-4 shadow-sm" href="{{url('/tecnico/dispositivos/create')}}">
                                            <i class="bi bi-plus-lg me-2"></i>Agregar Dispositivo
                                        </a>
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
        /* Estilos de marca */
        .text-brand-blue { color: #0d6efd !important; }
        .hover-info:hover { background-color: #0dcaf0 !important; color: white !important; border-color: #0dcaf0 !important; }
        .hover-primary:hover { background-color: #0d6efd !important; color: white !important; border-color: #0d6efd !important; }
        .hover-danger:hover { background-color: #dc3545 !important; color: white !important; border-color: #dc3545 !important; }
    </style>

    {{-- LIBRERÍA SWEETALERT 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializar tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Confirmación de Eliminación (Modal Centrado)
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
                        cancelButtonText: 'Cancelar',
                        backdrop: `rgba(0,0,0,0.4)`
                    }).then((result) => {
                        if (result.isConfirmed) { form.submit(); }
                    });
                });
            });

            // Alertas de Éxito y Error
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación Exitosa!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#0d6efd',
                    timer: 3500,
                    timerProgressBar: true,
                    backdrop: `rgba(0,0,0,0.4)`
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Ha ocurrido un problema',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc3545',
                    backdrop: `rgba(0,0,0,0.4)`
                });
            @endif
        });
    </script>
@endsection 