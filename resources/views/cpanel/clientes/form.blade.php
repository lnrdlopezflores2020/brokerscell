<div class="container mt-5">

    {{-- Título de la sección --}}
    <div class="row mb-4">
        <div class="col-12 border-bottom pb-2">
            <h3 class="text-primary fw-bold"><i class="bi bi-person-vcard-fill me-2"></i>Datos del Cliente</h3>
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
                           value="{{ old('telefono', $fila->telefono ?? '') }}"
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
                        @foreach($usuariosClientes as $user)
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

        {{-- SECCIÓN 2: DIRECCIÓN --}}
        <div class="col-12 text-muted small fw-bold mt-4 mb-2">UBICACIÓN</div>

        <div class="col-md-6">
            <div class="input-group has-validation">
                <span class="input-group-text bg-light text-danger"><i class="bi bi-geo-alt-fill"></i></span>
                <div class="form-floating">
                    <input type="text"
                           class="form-control"
                           id="direccion"
                           name="direccion"
                           value="{{ old('direccion', $fila->direccion ?? '') }}"
                           placeholder="Dirección"
                           required>
                    <label for="direccion">Calle / Avenida</label>
                </div>
                <div class="invalid-feedback">Ingresa la calle.</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group has-validation">
                <span class="input-group-text bg-light text-danger"><i class="bi bi-hash"></i></span>
                <div class="form-floating">
                    <input type="text"
                           class="form-control"
                           id="num_ext"
                           name="num_ext"
                           value="{{ old('num_ext', $fila->num_ext ?? '') }}"
                           placeholder="N. Ext."
                           required>
                    <label for="num_ext">N. Exterior</label>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-text bg-light text-danger"><i class="bi bi-building"></i></span>
                <div class="form-floating">
                    <input type="text"
                           class="form-control"
                           id="num_int"
                           name="num_int"
                           value="{{ old('num_int', $fila->num_int ?? '') }}"
                           placeholder="N. Int.">
                    <label for="num_int">N. Int. (Opcional)</label>
                </div>
            </div>
        </div>

        {{-- BOTONES DE ACCIÓN --}}
        <div class="col-12 mt-4 d-flex justify-content-end gap-2">
            <a href="{{ url('/admon/clientes') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" id="btnGuardar" class="btn btn-success px-4 fw-bold">
                <i class="bi bi-save me-2"></i>Guardar Cliente
            </button>
        </div>
    </div>
</div>

