@php
    // 1. Limpiamos el rol para evitar errores de espacios
    $rol = strtolower(trim(auth()->user()->rol_usuario));

    // 2. Lógica EXPLICITA:
    // Si la base de datos dice que eres administrador, OBLIGAMOS a usar 'admon'
    // sin importar lo que diga la URL.
    if ($rol === 'administrador') {
        $layout = 'cpanel/plantilla';
        $url_prefix = 'admon';
    } else {
        // Para cualquier otro caso (tecnico), usamos la ruta de técnico
        $layout = 'cpanel/plantillaTecnicos';
        $url_prefix = 'tecnico';
    }
@endphp

@extends($layout)
@section('title','clientes')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-4 bg-body">
            
            {{-- ENCABEZADO DE LA TARJETA --}}
            <div class="card-header bg-transparent border-bottom pt-4 pb-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="card-title fw-bold text-body m-0">
                        <i class="bi bi-people-fill text-primary me-2"></i>Directorio de Clientes
                    </h4>
                    <p class="text-secondary small mb-0 mt-1">Gestiona la información y el contacto de tus clientes registrados.</p>
                </div>
                
                <div class="d-flex flex-wrap gap-2">
                    {{-- Botón PDF/Excel: Solo para admin --}}
                    @if(auth()->user()->rol_usuario === 'administrador')
                        <div class="btn-group shadow-sm" role="group">
                            <a class="btn btn-outline-danger fw-medium d-flex align-items-center" href="{{url('admon/reportes/pdfClientes')}}" target="_blank" title="Exportar a PDF">
                                <i class="bi bi-file-earmark-pdf-fill me-2"></i> PDF
                            </a>
                            <a class="btn btn-outline-success fw-medium d-flex align-items-center" href="{{ route('reportes_clientes.excel') }}" target="_blank" title="Exportar a Excel">
                                <i class="bi bi-file-earmark-excel-fill me-2"></i> Excel
                            </a>
                        </div>
                    @endif

                    {{-- Botón Agregar dinámico --}}
                    <a class="btn btn-primary fw-bold shadow-sm d-flex align-items-center" href="{{ url($url_prefix . '/clientes/create') }}">
                        <i class="bi bi-plus-circle-fill me-2"></i> Nuevo Cliente
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 600px; overflow-y: auto; overflow-x: auto;">
                    <table class="table table-hover align-middle mb-0">
                        
                        <thead class="table-light text-secondary small text-uppercase" style="position: sticky; top: 0; z-index: 1;">
                            <tr>
                                <th scope="col" class="ps-4 fw-semibold border-0 py-3">Cliente</th>
                                <th scope="col" class="fw-semibold border-0 py-3"><i class="bi bi-person-badge me-1"></i> Usuario App</th>
                                <th scope="col" class="fw-semibold border-0 py-3"><i class="bi bi-telephone me-1"></i> Contacto</th>
                                <th scope="col" class="fw-semibold border-0 py-3"><i class="bi bi-geo-alt me-1"></i> Dirección</th>
                                <th scope="col" class="text-center pe-4 fw-semibold border-0 py-3" style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        
                        <tbody class="border-top-0">
                        @forelse($data as $fila)
                            <tr>
                                {{-- COLUMNA 1: Avatar + Nombre + ID --}}
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        {{-- Generador de Avatar con iniciales --}}
                                        <div class="bg-primary bg-opacity-10 text-primary fw-bold rounded-circle d-flex justify-content-center align-items-center me-3 flex-shrink-0" style="width: 45px; height: 45px; font-size: 1.1rem;">
                                            {{ strtoupper(substr($fila->nombre, 0, 1)) }}{{ strtoupper(substr($fila->apellido, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-body">{{$fila->nombre}} {{$fila->apellido}} {{ $fila->amat ?? '' }}</h6>
                                            <small class="text-muted">ID: #{{ str_pad($fila->ID_client, 5, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>

                                {{-- COLUMNA 2: Usuario Asociado --}}
                                <td class="py-3">
                                    @if($fila->usuario)
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <div>
                                                <span class="d-block text-body fw-medium" style="font-size: 0.9rem;">{{ $fila->usuario->name }}</span>
                                                <small class="text-secondary">{{ $fila->usuario->emai }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle rounded-pill px-3 py-1 fw-normal">
                                            <i class="bi bi-dash-circle me-1"></i>Sin usuario web
                                        </span>
                                    @endif
                                </td>

                                {{-- COLUMNA 3: Teléfono --}}
                                <td class="py-3">
                                    <span class="text-body fw-medium">
                                        {{ $fila->telefono ?? 'No registrado' }}
                                    </span>
                                </td>

                                {{-- COLUMNA 4: Dirección completa --}}
                                <td class="py-3">
                                    <span class="d-block text-body" style="font-size: 0.9rem;">{{ $fila->direccion }}</span>
                                    <small class="text-secondary">
                                        Ext: <span class="fw-medium text-body">{{ $fila->num_ext }}</span> 
                                        @if($fila->num_int)
                                            | Int: <span class="fw-medium text-body">{{ $fila->num_int }}</span>
                                        @endif
                                    </small>
                                </td>

                                {{-- COLUMNA 5: Acciones --}}
                                <td class="text-center pe-4 py-3">
                                    <div class="btn-group shadow-sm" role="group">
                                        {{-- Botón Editar --}}
                                        <a class="btn btn-sm btn-light border text-primary hover-primary"
                                           href="{{ url($url_prefix . '/clientes/' . $fila->ID_client . '/edit') }}"
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Cliente">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- Formulario Eliminar --}}
                                        <form action="{{url($url_prefix . '/clientes/' . $fila->ID_client) }}" method="POST" class="d-inline m-0 p-0 form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-light border text-danger hover-danger btn-delete" type="button"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Cliente" data-name="{{$fila->nombre}} {{$fila->apellido}}">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                            <i class="bi bi-person-x display-4 text-secondary opacity-50"></i>
                                        </div>
                                        <h5 class="fw-bold text-body mb-1">No hay clientes registrados</h5>
                                        <p class="text-secondary mb-3">Comienza agregando tu primer cliente a la base de datos.</p>
                                        <a class="btn btn-primary rounded-pill px-4" href="{{ url($url_prefix . '/clientes/create') }}">
                                            <i class="bi bi-plus-lg me-2"></i>Agregar Cliente
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
        /* Efectos hover sutiles para los botones de acción */
        .hover-primary:hover { background-color: #0d6efd !important; color: white !important; border-color: #0d6efd !important; }
        .hover-danger:hover { background-color: #dc3545 !important; color: white !important; border-color: #dc3545 !important; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializar tooltips de Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // SweetAlert Confirmación de Eliminación
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const form = this.closest('form');
                    const clientName = this.getAttribute('data-name');
                    
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: `Estás a punto de eliminar al cliente ${clientName}. Esta acción es irreversible.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Script de SweetAlert para mensajes de éxito
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación Exitosa!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#0d6efd',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            // Alerta de Error (Por si falla alguna validación o proceso)
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc3545'
                });
            @endif
        });
    </script>
@endsection