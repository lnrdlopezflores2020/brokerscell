<div class="container mt-5">

    {{-- Título --}}
    <div class="row mb-4">
        <div class="col-12 border-bottom pb-2">
            <h3 class="text-primary fw-bold">
                <i class="bi bi-person-gear me-2"></i>Gestión de Usuario
            </h3>
        </div>
    </div>

    {{-- Inicio del Formulario --}}
    {{-- Nota: Asegúrate de tener la etiqueta <form> abriendo antes de este div en tu código principal --}}

    <div class="row g-4">

        {{-- CAMPO: EMAIL --}}
        <div class="col-md-6">
            <div class="input-group has-validation">
                <span class="input-group-text bg-light text-primary">
                    <i class="bi bi-envelope-at-fill"></i>
                </span>
                <div class="form-floating">
                    {{-- Corregí '$fila->emai' a '$fila->email' asumiendo que fue error de dedo, si tu BD es 'emai', cámbialo --}}
                    <input type="email"
                           class="form-control"
                           id="email"
                           name="email"
                           value="{{ old('email', $fila->emai ?? '') }}"
                           placeholder="nombre@ejemplo.com"
                           required>
                    <label for="email">Correo Electrónico</label>
                </div>
                <div class="invalid-feedback">Ingresa un correo válido.</div>
            </div>
        </div>

        {{-- CAMPO: ROL --}}
        <div class="col-md-6">
            <div class="input-group has-validation">
                <span class="input-group-text bg-light text-primary">
                    <i class="bi bi-shield-lock-fill"></i>
                </span>
                <div class="form-floating">
                    <select class="form-select" id="rol" name="rol" required>
                        <option value="" disabled {{ !isset($fila) ? 'selected' : '' }}>Selecciona un rol...</option>

                        {{-- Lógica limpia para seleccionar la opción correcta al editar --}}
                        <option value="cliente" {{ old('rol', $fila->rol_usuario ?? '') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="tecnico" {{ old('rol', $fila->rol_usuario ?? '') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                        <option value="administrador" {{ old('rol', $fila->rol_usuario ?? '') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    <label for="rol">Rol de Usuario</label>
                </div>
                <div class="invalid-feedback">Debes asignar un rol.</div>
            </div>
        </div>

        <div class="col-12"><hr class="text-muted opacity-25"></div>

        {{-- CAMPO: CONTRASEÑA --}}
        <div class="col-md-6">
            <div class="input-group has-validation">
                <span class="input-group-text bg-light text-danger">
                    <i class="bi bi-key-fill"></i>
                </span>
                <div class="form-floating">
                    {{-- Si estás editando, el password no debería ser required a menos que quieras cambiarlo --}}
                    <input type="password"
                           class="form-control"
                           id="password"
                           name="password"
                           placeholder="Contraseña"
                        {{ isset($fila) ? '' : 'required' }}>
                    <label for="password">Contraseña</label>
                </div>
                <div class="form-text ms-2">Mínimo 8 caracteres. {{ isset($fila) ? '(Dejar en blanco para no cambiar)' : '' }}</div>
            </div>
        </div>

        {{-- CAMPO: CONFIRMAR CONTRASEÑA (Recomendado) --}}
        <div class="col-md-6">
            <div class="input-group has-validation">
                <span class="input-group-text bg-light text-danger">
                    <i class="bi bi-check-circle-fill"></i>
                </span>
                <div class="form-floating">
                    <input type="password"
                           class="form-control"
                           id="password_confirmation"
                           name="password_confirmation"
                           placeholder="Confirmar"
                        {{ isset($fila) ? '' : 'required' }}>
                    <label for="password_confirmation">Confirmar Contraseña</label>
                </div>
            </div>
        </div>

        {{-- BOTONES --}}
        <div class="col-12 mt-4 d-flex justify-content-end gap-2">
            <a href="{{ url('/admon/usuarios') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" id="btnGuardar" class="btn btn-success px-4 fw-bold">
                <i class="bi bi-save me-2"></i>Guardar Usuario
            </button>
        </div>

    </div>
</div>
