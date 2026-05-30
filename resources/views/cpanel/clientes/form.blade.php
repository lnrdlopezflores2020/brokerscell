{{-- Contenedor principal que ocupa toda la altura disponible --}}
<div class="container-fluid d-flex flex-column" style="min-height: calc(100vh - 120px);">
    
    <div class="card shadow-sm border-0 rounded-4 bg-body flex-grow-1 d-flex flex-column">
        
        {{-- ENCABEZADO DE LA TARJETA --}}
        <div class="card-header bg-transparent border-bottom pt-4 pb-3 px-4 px-md-5">
            <h4 class="mb-0 fw-bold text-body">
                <i class="bi bi-person-vcard-fill text-primary me-2"></i> Datos del Cliente
            </h4>
            <p class="text-secondary small mb-0 mt-1">Completa la información personal y de ubicación del cliente.</p>
        </div>

        {{-- CUERPO DE LA TARJETA --}}
        <div class="card-body p-4 p-md-5 d-flex flex-column flex-grow-1">

            <div class="d-flex flex-column flex-grow-1">
                
                <div class="row g-4">
                    {{-- SECCIÓN 1: INFORMACIÓN PERSONAL --}}
                    <div class="col-12 mb-2">
                        <div class="text-uppercase text-primary fw-bold small" style="letter-spacing: 1px;">Información Personal</div>
                        <hr class="mt-2 mb-0 border-secondary opacity-10">
                    </div>

                    {{-- Nombre --}}
                    <div class="col-md-4">
                        <div class="input-group input-group-lg has-validation shadow-sm">
                            <span class="input-group-text bg-body-tertiary border-subtle text-primary"><i class="bi bi-person-fill"></i></span>
                            <div class="form-floating flex-grow-1">
                                <input type="text"
                                       class="form-control border-subtle bg-body"
                                       id="nombre"
                                       name="nombre"
                                       value="{{ old('nombre', $fila->nombre ?? '') }}"
                                       placeholder="Nombre(s)"
                                       required>
                                <label for="nombre" class="text-secondary">Nombre(s)</label>
                            </div>
                            <div class="invalid-feedback">Por favor, ingresa el nombre.</div>
                        </div>
                    </div>

                    {{-- Apellido Paterno --}}
                    <div class="col-md-4">
                        <div class="input-group input-group-lg has-validation shadow-sm">
                            <span class="input-group-text bg-body-tertiary border-subtle text-primary"><i class="bi bi-person-fill"></i></span>
                            <div class="form-floating flex-grow-1">
                                <input type="text"
                                       class="form-control border-subtle bg-body"
                                       id="apellido"
                                       name="apellido"
                                       value="{{ old('apellido', $fila->apellido ?? '') }}"
                                       placeholder="Apellido Paterno"
                                       required>
                                <label for="apellido" class="text-secondary">Apellido Paterno</label>
                            </div>
                            <div class="invalid-feedback">Por favor, ingresa el apellido paterno.</div>
                        </div>
                    </div>

                    {{-- Apellido Materno (NUEVO CAMPO - Opcional) --}}
                    <div class="col-md-4">
                        <div class="input-group input-group-lg shadow-sm">
                            <span class="input-group-text bg-body-tertiary border-subtle text-primary"><i class="bi bi-person-fill"></i></span>
                            <div class="form-floating flex-grow-1">
                                <input type="text"
                                       class="form-control border-subtle bg-body"
                                       id="amat"
                                       name="amat"
                                       value="{{ old('amat', $fila->amat ?? '') }}"
                                       placeholder="Apellido Materno">
                                <label for="amat" class="text-secondary">Apellido Materno</label>
                            </div>
                        </div>
                    </div>

                    {{-- Teléfono --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-lg has-validation shadow-sm">
                            <span class="input-group-text bg-body-tertiary border-subtle text-primary"><i class="bi bi-telephone-fill"></i></span>
                            <div class="form-floating flex-grow-1">
                                <input type="tel"
                                       class="form-control border-subtle bg-body"
                                       id="telefono"
                                       name="telefono"
                                       value="{{ old('telefono', $fila->telefono ?? '') }}"
                                       placeholder="Teléfono"
                                       pattern="[0-9]{10}"
                                       title="Ingresa 10 dígitos numéricos"
                                       required>
                                <label for="telefono" class="text-secondary">Teléfono (10 dígitos)</label>
                            </div>
                            <div class="invalid-feedback">Ingresa un número válido de 10 dígitos.</div>
                        </div>
                    </div>

                    {{-- Usuario --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-lg has-validation shadow-sm">
                            <span class="input-group-text bg-body-tertiary border-subtle text-primary"><i class="bi bi-envelope-at-fill"></i></span>
                            <div class="form-floating flex-grow-1">
                                <select name="usuario_fk" class="form-select border-subtle bg-body" id="Usuario">
                                    <option value="" selected disabled>Seleccionar cuenta...</option>
                                    @foreach($usuariosClientes as $user)
                                        <option value="{{ $user->ID_usuario }}"
                                            {{ old('usuario_fk', $fila->usuario_fk ?? '') == $user->ID_usuario ? 'selected' : '' }}>
                                            {{ $user->email ?? $user->emai }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="Usuario" class="text-secondary">Vincular Cuenta de Usuario (Opcional)</label>
                            </div>
                            <div class="invalid-feedback">Selecciona un usuario.</div>
                        </div>
                    </div>

                    {{-- SECCIÓN 2: DIRECCIÓN --}}
                    <div class="col-12 mt-5 mb-2">
                        <div class="text-uppercase text-danger fw-bold small" style="letter-spacing: 1px;">Ubicación</div>
                        <hr class="mt-2 mb-0 border-secondary opacity-10">
                    </div>

                    <div class="col-md-6">
                        <div class="input-group input-group-lg has-validation shadow-sm">
                            <span class="input-group-text bg-body-tertiary border-subtle text-danger"><i class="bi bi-geo-alt-fill"></i></span>
                            <div class="form-floating flex-grow-1">
                                <input type="text"
                                       class="form-control border-subtle bg-body"
                                       id="direccion"
                                       name="direccion"
                                       value="{{ old('direccion', $fila->direccion ?? '') }}"
                                       placeholder="Dirección"
                                       required>
                                <label for="direccion" class="text-secondary">Calle / Avenida</label>
                            </div>
                            <div class="invalid-feedback">Ingresa la calle.</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group input-group-lg has-validation shadow-sm">
                            <span class="input-group-text bg-body-tertiary border-subtle text-danger"><i class="bi bi-hash"></i></span>
                            <div class="form-floating flex-grow-1">
                                <input type="number"
                                       class="form-control border-subtle bg-body"
                                       id="num_ext"
                                       name="num_ext"
                                       value="{{ old('num_ext', $fila->num_ext ?? '') }}"
                                       placeholder="N. Ext."
                                       required>
                                <label for="num_ext" class="text-secondary">N. Exterior</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group input-group-lg shadow-sm">
                            <span class="input-group-text bg-body-tertiary border-subtle text-danger"><i class="bi bi-building"></i></span>
                            <div class="form-floating flex-grow-1">
                                <input type="text"
                                       class="form-control border-subtle bg-body"
                                       id="num_int"
                                       name="num_int"
                                       value="{{ old('num_int', $fila->num_int ?? '') }}"
                                       placeholder="N. Int.">
                                <label for="num_int" class="text-secondary">N. Int. (Opcional)</label>
                            </div>
                        </div>
                    </div>

                    {{-- LOCALIDAD --}}
                    <div class="col-md-6">
                        <div class="input-group input-group-lg shadow-sm">
                            <span class="input-group-text bg-body-tertiary border-subtle text-danger"><i class="bi bi-map-fill"></i></span>
                            <div class="form-floating flex-grow-1">
                                <input type="text"
                                       class="form-control border-subtle bg-body"
                                       id="localidad"
                                       name="localidad"
                                       value="{{ old('localidad', $fila->localidad ?? '') }}"
                                       placeholder="Ej. San Martín Texmelucan">
                                <label for="localidad" class="text-secondary">Localidad / Municipio</label>
                            </div>
                        </div>
                    </div>

                    {{-- ESTADO (LISTA DESPLEGABLE) --}}
                    @php
                        $estadosMexico = [
                            'Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche', 'Chiapas', 
                            'Chihuahua', 'Ciudad de México', 'Coahuila', 'Colima', 'Durango', 'Estado de México', 
                            'Guanajuato', 'Guerrero', 'Hidalgo', 'Jalisco', 'Michoacán', 'Morelos', 'Nayarit', 
                            'Nuevo León', 'Oaxaca', 'Puebla', 'Querétaro', 'Quintana Roo', 'San Luis Potosí', 
                            'Sinaloa', 'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala', 'Veracruz', 'Yucatán', 'Zacatecas'
                        ];
                    @endphp

                    <div class="col-md-6">
                        <div class="input-group input-group-lg shadow-sm">
                            <span class="input-group-text bg-body-tertiary border-subtle text-danger"><i class="bi bi-pin-map-fill"></i></span>
                            <div class="form-floating flex-grow-1">
                                <select class="form-select border-subtle bg-body" id="estado" name="estado">
                                    <option value="" selected disabled>Seleccionar estado...</option>
                                    @foreach($estadosMexico as $estado)
                                        <option value="{{ $estado }}" {{ old('estado', $fila->estado ?? '') == $estado ? 'selected' : '' }}>
                                            {{ $estado }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="estado" class="text-secondary">Estado</label>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- BOTONES DE ACCIÓN --}}
                <div class="d-flex justify-content-end mt-auto pt-4 border-top">
                    @if(auth()->user()->rol_usuario === 'administrador')
                       <a href="{{ url('/admon/clientes') }}" class="btn btn-light border text-secondary me-3 px-4 fw-medium">Cancelar</a>
                    @endif

                    @if(auth()->user()->rol_usuario === 'tecnico')
                       <a href="{{ url('/tecnico/clientes') }}" class="btn btn-light border text-secondary me-3 px-4 fw-medium">Cancelar</a>
                    @endif
                    <button type="submit" id="btnGuardar" class="btn btn-success px-5 fw-bold shadow-sm hover-lift">
                        <i class="bi bi-save me-2"></i>Guardar Cliente
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>

<style>
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>