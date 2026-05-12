@extends('cpanel/plantillaTecnicos')
@section('title', 'reparaciones')
@section('content')
    {{-- Contenedor principal que ocupa toda la altura disponible --}}
    <div class="container-fluid d-flex flex-column" style="min-height: calc(100vh - 120px);">
        
        <div class="card shadow-sm border-0 rounded-4 bg-body flex-grow-1 d-flex flex-column">
            
            {{-- ENCABEZADO --}}
            <div class="card-header bg-transparent border-bottom pt-4 pb-3 px-4 px-md-5">
                <h4 class="mb-0 fw-bold text-body">
                    <i class="bi bi-tools text-primary me-2"></i> Nueva Reparación
                </h4>
                <p class="text-secondary small mb-0 mt-1">Completa los datos para registrar un nuevo ingreso al taller.</p>
            </div>
            
            {{-- CUERPO DE LA TARJETA (Flex para estirar el contenido) --}}
            <div class="card-body p-4 p-md-5 d-flex flex-column flex-grow-1">

                <form action="{{ url('tecnico/reparaciones') }}" method="POST" class="d-flex flex-column flex-grow-1">
                    @csrf

                    {{-- FILA 1: CLIENTE Y DISPOSITIVO --}}
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="cliente_select" class="form-label fw-bold text-body small text-uppercase tracking-wide">1. Seleccionar Cliente</label>
                            <select id="cliente_select" class="form-select form-select-lg border-subtle bg-body-tertiary" required>
                                <option value="">-- Buscar Cliente --</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->ID_client }}">
                                        {{ $cliente->nombre }} {{ $cliente->apellido }} (Tel: {{ $cliente->telefono }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="id_tel_fk" class="form-label fw-bold text-body small text-uppercase tracking-wide">2. Seleccionar Dispositivo</label>
                            <select name="id_tel_fk" id="id_tel_fk" class="form-select form-select-lg border-subtle bg-body-tertiary" disabled required>
                                <option value="">-- Primero seleccione un cliente --</option>
                            </select>
                            <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Este es el equipo que se asociará a la reparación.</div>
                        </div>
                    </div>

                    <hr class="border-secondary opacity-10 my-4">

                    {{-- FILA 2: FECHAS, ESTADO Y PRECIO --}}
                    <div class="row g-4 mb-4">
                        {{-- Fecha Inicio --}}
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-body small text-uppercase tracking-wide">Fecha Inicio</label>
                            <input type="date" name="fec_inicio" class="form-control form-control-lg border-subtle bg-body-tertiary" value="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Fecha Entrega --}}
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-body small text-uppercase tracking-wide">Fecha Est. Entrega</label>
                            <input type="date" name="fec_est_entrega" class="form-control form-control-lg border-subtle bg-body-tertiary" required>
                        </div>

                        {{-- Estado --}}
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-body small text-uppercase tracking-wide">Estado Inicial</label>
                            <select name="est_reparacion" class="form-select form-select-lg border-subtle bg-body-tertiary">
                                <option value="Pendiente">Pendiente</option>
                                <option value="En revision">En revisión</option>
                                <option value="En Reparacion">En reparación</option>
                            </select>
                        </div>

                        {{-- Precio --}}
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-body small text-uppercase tracking-wide">Costo Estimado</label>
                            <div class="input-group input-group-lg shadow-sm">
                                <span class="input-group-text bg-primary text-white border-primary"><i class="bi bi-currency-dollar"></i></span>
                                <input type="number"
                                       name="costo"
                                       class="form-control border-primary"
                                       step="0.01"
                                       min="0"
                                       placeholder="0.00"
                                       required>
                            </div>
                        </div>
                    </div>

                    {{-- FILA 3: DESCRIPCIÓN (Ocupa el resto del espacio vertical) --}}
                    <div class="row mb-4 flex-grow-1 d-flex flex-column">
                        <div class="col-12 d-flex flex-column flex-grow-1">
                            <label class="form-label fw-bold text-body small text-uppercase tracking-wide">Descripción del Problema / Falla</label>
                            <textarea name="descripcion" class="form-control form-control-lg border-subtle bg-body-tertiary flex-grow-1" style="min-height: 150px; resize: none;" placeholder="Ej: Pantalla rota, no carga, se reinicia constantemente, mojado..." required></textarea>
                        </div>
                    </div>

                    {{-- BOTONES AL FINAL (mt-auto empuja los botones hasta abajo) --}}
                    <div class="d-flex justify-content-end mt-auto pt-4 border-top">
                        <a href="{{ url('tecnico/reparaciones') }}" class="btn btn-light border text-secondary me-3 px-4 fw-medium">Cancelar</a>
                        <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm hover-lift">
                            <i class="bi bi-save me-2"></i>Guardar Reparación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .tracking-wide { letter-spacing: 0.05em; }
        .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    </style>

    {{-- SCRIPT --}}
    <script>
        document.getElementById('cliente_select').addEventListener('change', function() {
            let clienteId = this.value;
            let dispositivoSelect = document.getElementById('id_tel_fk');

            dispositivoSelect.innerHTML = '<option value="">Cargando dispositivos...</option>';
            dispositivoSelect.disabled = true;

            if (clienteId) {
                fetch('/api/clientes/' + clienteId + '/dispositivos')
                    .then(response => response.json())
                    .then(data => {
                        dispositivoSelect.innerHTML = '<option value="">-- Seleccione Dispositivo --</option>';
                        if (data.length > 0) {
                            data.forEach(device => {
                                let option = document.createElement('option');
                                option.value = device.ID_tel;
                                option.text = `${device.marca} ${device.modelo} (${device.tipo})`;
                                dispositivoSelect.appendChild(option);
                            });
                            dispositivoSelect.disabled = false;
                        } else {
                            dispositivoSelect.innerHTML = '<option value="">Este cliente no tiene dispositivos registrados</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        dispositivoSelect.innerHTML = '<option value="">Error al cargar</option>';
                    });
            } else {
                dispositivoSelect.innerHTML = '<option value="">-- Primero seleccione un cliente --</option>';
                dispositivoSelect.disabled = true;
            }
        });
    </script>
@endsection