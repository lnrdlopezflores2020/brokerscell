<div class="container-fluid py-4 h-100 d-flex flex-column">
    <div class="card shadow-sm border-0 rounded-4 bg-body flex-grow-1 overflow-hidden d-flex flex-column">
        
        {{-- Línea superior decorativa --}}
        <div style="height: 6px; background: linear-gradient(90deg, #0d6efd, #0d6efd);"></div>

        {{-- Cuerpo de la tarjeta con scroll si el contenido excede la pantalla --}}
        <div class="card-body p-4 p-md-5 overflow-auto">
            
            {{-- Título de la sección --}}
            <div class="row mb-4">
                <div class="col-12 border-bottom pb-4">
                    <h3 class="fw-bold m-0" style="color: #0d6efd;">
                        <i class="bi bi-person-vcard-fill me-2"></i>Datos del Técnico
                    </h3>
                    <p class="text-secondary mt-2 mb-0 fs-6">Completa o modifica la información del personal técnico.</p>
                </div>
            </div>

            <div class="row g-4">
                {{-- SECCIÓN 1: INFORMACIÓN PERSONAL --}}
                <div class="col-12 text-muted small fw-bold text-uppercase mb-1" style="letter-spacing: 1px;">
                    Información Personal
                </div>

                {{-- NOMBRE --}}
                <div class="col-md-4">
                    <div class="input-group has-validation shadow-sm rounded-3 input-group-lg">
                        <span class="input-group-text bg-light border-end-0" style="color: #0d6efd;"><i class="bi bi-person-fill"></i></span>
                        <div class="form-floating flex-grow-1">
                            <input type="text"
                                   class="form-control border-start-0"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ old('nombre', $fila->nombre ?? '') }}"
                                   placeholder="Nombre(s)"
                                   required>
                            <label for="nombre">Nombre(s)</label>
                        </div>
                        <div class="invalid-feedback">Por favor, ingresa el nombre.</div>
                    </div>
                </div>

                {{-- APELLIDO PATERNO --}}
                <div class="col-md-4">
                    <div class="input-group has-validation shadow-sm rounded-3 input-group-lg">
                        <span class="input-group-text bg-light border-end-0" style="color: #0d6efd;"><i class="bi bi-person-fill"></i></span>
                        <div class="form-floating flex-grow-1">
                            <input type="text"
                                   class="form-control border-start-0"
                                   id="apellido"
                                   name="apellido"
                                   value="{{ old('apellido', $fila->apellido ?? '') }}"
                                   placeholder="Apellido Paterno"
                                   required>
                            <label for="apellido">Apellido Paterno</label>
                        </div>
                        <div class="invalid-feedback">Por favor, ingresa el apellido paterno.</div>
                    </div>
                </div>

                {{-- APELLIDO MATERNO (Opcional) --}}
                <div class="col-md-4">
                    <div class="input-group shadow-sm rounded-3 input-group-lg">
                        <span class="input-group-text bg-light border-end-0" style="color: #0d6efd;"><i class="bi bi-person-fill"></i></span>
                        <div class="form-floating flex-grow-1">
                            <input type="text"
                                   class="form-control border-start-0"
                                   id="amat"
                                   name="amat"
                                   value="{{ old('amat', $fila->amat ?? '') }}"
                                   placeholder="Apellido Materno">
                            <label for="amat">Apellido Materno (Opcional)</label>
                        </div>
                    </div>
                </div>

                {{-- TELÉFONO --}}
                <div class="col-md-6">
                    <div class="input-group has-validation shadow-sm rounded-3 input-group-lg">
                        <span class="input-group-text bg-light border-end-0" style="color: #0d6efd;"><i class="bi bi-telephone-fill"></i></span>
                        <div class="form-floating flex-grow-1">
                            <input type="tel"
                                   class="form-control border-start-0"
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

                {{-- VINCULAR USUARIO --}}
                <div class="col-md-6">
                    <div class="input-group has-validation shadow-sm rounded-3 input-group-lg">
                        <span class="input-group-text bg-light border-end-0" style="color: #0d6efd;"><i class="bi bi-envelope-at-fill"></i></span>
                        <div class="form-floating flex-grow-1">
                            <select name="usuario_fk" class="form-select border-start-0" id="Usuario" required>
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
                        <div class="invalid-feedback">Selecciona un usuario válido para el técnico.</div>
                    </div>
                </div>

                {{-- BOTONES DE ACCIÓN --}}
                <div class="col-12 mt-5 pt-4 border-top d-flex justify-content-end gap-3">
                    <a href="{{ url('/admon/tecnicos') }}" class="btn btn-light border fw-medium px-4 py-2 rounded-pill shadow-sm hover-dark transition-all d-flex align-items-center">
                        Cancelar
                    </a>
                    <button type="submit" id="btnGuardar" class="btn text-white px-5 py-2 fw-bold rounded-pill shadow-sm transition-all d-flex align-items-center" style="background-color: #0d6efd;">
                        <i class="bi bi-save-fill me-2 fs-5"></i>Guardar Técnico
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ESTILOS COMPLEMENTARIOS --}}
<style>
    /* Transiciones y efectos Hover para los botones */
    .transition-all { transition: all 0.2s ease; }
    .transition-all:hover {
        background-color: #0d6efd !important;
        transform: translateY(-2px);
    }
    .hover-dark:hover {
        background-color: #e2e8f0 !important;
        transform: translateY(-2px);
        color: #000 !important;
    }
    /* Estilo para enfocar los inputs sin perder el borde continuo */
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: none;
    }
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25) !important;
        border-radius: 0.5rem;
    }
</style>