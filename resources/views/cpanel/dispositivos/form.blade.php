{{-- 1. LÓGICA DEL FORMULARIO --}}
@php
    $esEdicion = isset($dispositivo) && $dispositivo->ID_tel;
    $urlAction = $esEdicion ? url('tecnico/dispositivos', $dispositivo->ID_tel) : route('dispositivos.store');
@endphp

@section('content')
<div class="container-fluid py-4 h-100 d-flex flex-column">
    <form action="{{ $urlAction }}" method="POST" id="formDispositivo" class="d-flex flex-column flex-grow-1">
        @csrf
        @if($esEdicion)
            @method('PUT')
        @endif

        <div class="card shadow-sm border-0 rounded-4 bg-body flex-grow-1 overflow-hidden d-flex flex-column">
            
            {{-- Línea superior decorativa --}}
            <div style="height: 6px; background: linear-gradient(90deg, #0d6efd, #0d6efd);"></div>

            <div class="card-body p-4 p-md-5 overflow-auto">
                
                {{-- TÍTULO DE LA SECCIÓN --}}
                <div class="row mb-5">
                    <div class="col-12 border-bottom pb-4">
                        <h3 class="fw-bold m-0" style="color: #0d6efd;">
                            <i class="bi {{ $esEdicion ? 'bi-pencil-square' : 'bi-plus-circle-fill' }} me-2"></i>
                            {{ $esEdicion ? 'Actualizar Dispositivo' : 'Registrar Nuevo Dispositivo' }}
                        </h3>
                        <p class="text-secondary mt-2 mb-0 fs-6">Completa o modifica la información del equipo en el sistema.</p>
                    </div>
                </div>

                {{-- CONTENEDOR DE CAMPOS CON MÁS ESPACIO (g-4) --}}
                <div class="row g-4">

                    {{-- SECCIÓN 1: CLIENTE --}}
                    <div class="col-12 mb-2">
                        <div class="text-muted small fw-bold text-uppercase mb-3" style="letter-spacing: 1px;">Propietario del Equipo</div>
                        <div class="input-group has-validation shadow-sm rounded-3 input-group-lg">
                            <span class="input-group-text bg-light border-end-0" style="color: #0d6efd;"><i class="bi bi-person-circle"></i></span>
                            <div class="form-floating flex-grow-1">
                                <select class="form-select border-start-0" id="cliente" name="id_client_fk" required>
                                    <option value="" disabled {{ !$esEdicion ? 'selected' : '' }}>Seleccione un cliente...</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->ID_client }}"
                                            {{ ($dispositivo->id_client_fk ?? '') == $cliente->ID_client ? 'selected' : '' }}>
                                            {{ $cliente->nombre }} {{ $cliente->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="cliente">Asignar Cliente Registrado</label>
                            </div>
                            <div class="invalid-feedback">Por favor selecciona al dueño del equipo.</div>
                        </div>
                    </div>

                    <div class="col-12"><hr class="text-muted opacity-10 my-3"></div>

                    {{-- SECCIÓN 2: DATOS TÉCNICOS --}}
                    <div class="col-12 mb-1">
                        <div class="text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">Especificaciones Técnicas</div>
                    </div>

                    {{-- TIPO DE DISPOSITIVO --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="input-group shadow-sm rounded-3 input-group-lg">
                            <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-grid-3x3-gap-fill"></i></span>
                            <div class="form-floating flex-grow-1">
                                <select class="form-select border-start-0" name="tipo" id="tipo" required>
                                    <option value="" disabled {{ !$esEdicion ? 'selected' : '' }}>Tipo...</option>
                                    <option value="Celular" {{ ($dispositivo->tipo ?? '') == 'Celular' ? 'selected' : '' }}>Celular / Smartphone</option>
                                    <option value="Tablet"  {{ ($dispositivo->tipo ?? '') == 'Tablet' ? 'selected' : '' }}>Tablet / iPad</option>
                                    <option value="Laptop"  {{ ($dispositivo->tipo ?? '') == 'Laptop' ? 'selected' : '' }}>Laptop / Portátil</option>
                                    <option value="PC"      {{ ($dispositivo->tipo ?? '') == 'PC' ? 'selected' : '' }}>PC Escritorio</option>
                                    <option value="Consola" {{ ($dispositivo->tipo ?? '') == 'Consola' ? 'selected' : '' }}>Consola de Videojuegos</option>
                                    <option value="Otro"    {{ ($dispositivo->tipo ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                <label for="tipo">Tipo de Equipo</label>
                            </div>
                        </div>
                    </div>

                    {{-- MARCA --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="input-group shadow-sm rounded-3 input-group-lg">
                            <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-tag-fill"></i></span>
                            <div class="form-floating flex-grow-1">
                                <input type="text" class="form-control border-start-0" name="marca" id="marca"
                                       value="{{ old('marca', $dispositivo->marca ?? '') }}"
                                       placeholder="Ej: Samsung" required>
                                <label for="marca">Marca (Ej. Apple, Samsung)</label>
                            </div>
                        </div>
                    </div>

                    {{-- MODELO --}}
                    <div class="col-lg-4 col-md-12">
                        <div class="input-group shadow-sm rounded-3 input-group-lg">
                            <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-qr-code"></i></span>
                            <div class="form-floating flex-grow-1">
                                <input type="text" class="form-control border-start-0" name="modelo" id="modelo"
                                       value="{{ old('modelo', $dispositivo->modelo ?? '') }}"
                                       placeholder="Ej: Galaxy S22" required>
                                <label for="modelo">Modelo Exacto</label>
                            </div>
                        </div>
                    </div>

                    {{-- BOTONES DE ACCIÓN --}}
                    <div class="col-12 mt-5 pt-4 border-top d-flex justify-content-end gap-3">
                        <a href="{{ url('tecnico/dispositivos') }}" class="btn btn-light border fw-medium px-4 py-2 rounded-pill shadow-sm hover-dark transition-all d-flex align-items-center">
                            Cancelar
                        </a>
                        <button type="submit" class="btn text-white px-5 py-2 fw-bold rounded-pill shadow-sm transition-all d-flex align-items-center" style="background-color: #0d6efd;">
                            <i class="bi {{ $esEdicion ? 'bi-check-circle-fill' : 'bi-save-fill' }} me-2 fs-5"></i>
                            {{ $esEdicion ? 'Actualizar Dispositivo' : 'Guardar Dispositivo' }}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

{{-- ESTILOS COMPLEMENTARIOS --}}
<style>
    .transition-all { transition: all 0.2s ease; }
    .transition-all:hover {
        background-color: #0d6efd !important;
        transform: translateY(-2px);
    }
    .hover-dark:hover {
        background-color: #e2e8f0 !important;
        transform: translateY(-2px);
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: none;
    }
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25) !important;
        border-radius: 0.5rem;
    }
</style>

{{-- SCRIPT PARA SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // INTERCEPTAR ENVÍO DEL FORMULARIO
        const formDispositivo = document.getElementById('formDispositivo');
        if(formDispositivo) {
            formDispositivo.addEventListener('submit', function(e) {
                e.preventDefault(); 
                
                const isEdit = {{ $esEdicion ? 'true' : 'false' }};
                const titleText = isEdit ? '¿Actualizar dispositivo?' : '¿Guardar nuevo dispositivo?';
                
                Swal.fire({
                    title: titleText,
                    text: "Verifica que la marca y modelo sean correctos antes de continuar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#6f42c1',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-save"></i> Sí, proceder',
                    cancelButtonText: 'Revisar datos'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Procesando...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        formDispositivo.submit(); 
                    }
                });
            });
        }
    });
</script>
@endsection