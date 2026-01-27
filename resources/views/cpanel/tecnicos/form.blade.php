<div class="container mt-5">

    {{-- Título de la sección --}}
    <div class="row mb-4">
        <div class="col-12 border-bottom pb-2">
            <h3 class="text-primary fw-bold"><i class="bi bi-person-vcard-fill me-2"></i>Datos del Técnico</h3>
        </div>
    </div>

    <div class="row g-3">

        {{-- SECCIÓN 1: INFORMACIÓN PERSONAL --}}
        <div class="col-12 text-muted small fw-bold mt-4 mb-2">INFORMACIÓN PERSONAL</div>

        <div class="col-md-6">
            <div class="input-group has-validation">
                <span class="input-group-text bg-light text-primary"><i class="bi bi-person-fill"></i></span>
                <div class="form-floating">
                    <input type="text"
                           class="form-control"
                           id="nombre"
                           name="nombre"
                           value="{{ old('nombre', $fila->nombre ?? '') }}"
                           placeholder="Nombre"
                           required>
                    <label for="nombre">Nombre</label>
                </div>
                <div class="invalid-feedback">Por favor, ingresa el nombre.</div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group has-validation">
                <span class="input-group-text bg-light text-primary"><i class="bi bi-person-fill"></i></span>
                <div class="form-floating">
                    <input type="text"
                           class="form-control"
                           id="apellido"
                           name="apellido"
                           value="{{ old('apellido', $fila->apellido ?? '') }}"
                           placeholder="Apellido"
                           required>
                    <label for="apellido">Apellido</label>
                </div>
                <div class="invalid-feedback">Por favor, ingresa el apellido.</div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group has-validation">
                <span class="input-group-text bg-light text-primary"><i class="bi bi-telephone-fill"></i></span>
                <div class="form-floating">
                    <input type="tel"
                           class="form-control"
                           id="telefono"
                           name="telefono"
                           value="{{ old('telefono', $fila->tel_tecnico ?? '') }}"
                           placeholder="Teléfono"
                           pattern="[0-9]{10}"
                           title="Ingresa 10 dígitos numéricos"
                           required>
                    <label for="telefono">Teléfono (10 dígitos)</label>
                </div>
                <div class="invalid-feedback">Ingresa un número válido de 10 dígitos.</div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group has-validation">
                <span class="input-group-text bg-light text-primary"><i class="bi bi-envelope-at-fill"></i></span>
                <div class="form-floating">
                    <select name="usuario_fk" class="form-select" id="Usuario" required>
                        <option value="" selected disabled>Seleccionar cuenta...</option>
                        @foreach($usuariosTecnicos as $user)
                            <option value="{{ $user->ID_usuario }}"
                                {{ old('usuario_fk', $fila->usuario_fk ?? '') == $user->ID_usuario ? 'selected' : '' }}>
                                {{ $user->email ?? $user->emai }}
                            </option>
                        @endforeach
                    </select>
                    <label for="Usuario">Vincular Cuenta de Usuario</label>
                </div>
                <div class="invalid-feedback">Selecciona un usuario.</div>
            </div>
        </div>

        {{-- BOTONES DE ACCIÓN --}}
        <div class="col-12 mt-4 d-flex justify-content-end gap-2">
            <a href="{{ url('/admon/clientes') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" id="btnGuardar" class="btn btn-success px-4 fw-bold">
                <i class="bi bi-save me-2"></i>Guardar Técnico
            </button>
        </div>
    </div>
</div>

