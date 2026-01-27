{{-- 1. LÓGICA DEL FORMULARIO: Detectamos si existe la variable $dispositivo --}}
@php
    // Si $dispositivo existe (edición), usamos su ID. Si no (creación), es null.
    $esEdicion = isset($dispositivo) && $dispositivo->ID_tel;
    $urlAction = $esEdicion ? url('tecnico/dispositivos', $dispositivo->ID_tel) : route('dispositivos.store');
@endphp

<form action="{{ $urlAction }}" method="POST">
    @csrf

    {{-- Si es edición, agregamos el método PUT --}}
    @if($esEdicion)
        @method('PUT')
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="row g-4">

                {{-- SELECCIONAR CLIENTE --}}
                <div class="col-12">
                    <label for="cliente" class="form-label fw-bold text-muted small">PROPIETARIO DEL EQUIPO</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text bg-light text-primary"><i class="bi bi-person-circle"></i></span>
                        <div class="form-floating">
                            <select class="form-select" id="cliente" name="id_client_fk" required>
                                <option value="" disabled {{ !$esEdicion ? 'selected' : '' }}>Seleccione un cliente...</option>

                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->ID_client }}"
                                        {{-- Lógica Segura: Usamos '??' para evitar errores si $dispositivo no existe --}}
                                        {{ ($dispositivo->id_client_fk ?? '') == $cliente->ID_client ? 'selected' : '' }}>

                                        {{ $cliente->nombre }} {{ $cliente->apellido }}
                                    </option>
                                @endforeach

                            </select>
                            <label for="cliente">Cliente</label>
                        </div>
                    </div>
                </div>

                <div class="col-12"><hr class="text-muted opacity-25"></div>

                {{-- TIPO DE DISPOSITIVO --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted small">TIPO</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-secondary"><i class="bi bi-grid-3x3-gap-fill"></i></span>
                        <div class="form-floating">
                            <select class="form-select" name="tipo" id="tipo" required>
                                <option value="" disabled {{ !$esEdicion ? 'selected' : '' }}>Tipo...</option>

                                {{-- Usamos ($dispositivo->tipo ?? '') para que no falle al crear --}}
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
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted small">MARCA</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-secondary"><i class="bi bi-tag-fill"></i></span>
                        <div class="form-floating">
                            {{-- old('marca', $dispositivo->marca ?? '') --}}
                            <input type="text" class="form-control" name="marca" id="marca"
                                   value="{{ old('marca', $dispositivo->marca ?? '') }}"
                                   placeholder="Ej: Samsung" required>
                            <label for="marca">Marca</label>
                        </div>
                    </div>
                </div>

                {{-- MODELO --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted small">MODELO</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-secondary"><i class="bi bi-qr-code"></i></span>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="modelo" id="modelo"
                                   value="{{ old('modelo', $dispositivo->modelo ?? '') }}"
                                   placeholder="Ej: Galaxy S22" required>
                            <label for="modelo">Modelo</label>
                        </div>
                    </div>
                </div>

                {{-- BOTONES --}}
                <div class="col-12 mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ url('tecnico/dispositivos') }}" class="btn btn-secondary">Cancelar</a>

                    <button type="submit" class="btn {{ $esEdicion ? 'btn-primary' : 'btn-success' }} px-4 fw-bold">
                        <i class="bi {{ $esEdicion ? 'bi-check-circle' : 'bi-save' }} me-2"></i>
                        {{ $esEdicion ? 'Actualizar Dispositivo' : 'Guardar Dispositivo' }}
                    </button>
                </div>

            </div>
        </div>
    </div>
</form>
