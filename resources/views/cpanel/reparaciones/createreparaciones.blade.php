@extends('cpanel/plantillaTecnicos')
@section('title', 'reparaciones')
@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-tools"></i> Nueva Reparación</h5>
        </div>
        <div class="card-body">

            <form action="{{ url('tecnico/reparaciones') }}" method="POST">
                @csrf

                {{-- FILA 1: CLIENTE Y DISPOSITIVO --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cliente_select" class="form-label fw-bold">1. Seleccionar Cliente</label>
                        <select id="cliente_select" class="form-select" required>
                            <option value="">-- Buscar Cliente --</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->ID_client }}">
                                    {{ $cliente->nombre }} {{ $cliente->apellido }} (Tel: {{ $cliente->telefono }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_tel_fk" class="form-label fw-bold">2. Seleccionar Dispositivo</label>
                        <select name="id_tel_fk" id="id_tel_fk" class="form-select" disabled required>
                            <option value="">-- Primero seleccione un cliente --</option>
                        </select>
                        <small class="text-muted">Este es el dato que se asociará a la reparación.</small>
                    </div>
                </div>

                <hr>

                {{-- FILA 2: FECHAS, ESTADO Y PRECIO (NUEVO) --}}
                <div class="row">
                    {{-- Fecha Inicio --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" name="fec_inicio" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    {{-- Fecha Entrega --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Fecha Est. Entrega</label>
                        <input type="date" name="fec_est_entrega" class="form-control" required>
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Estado Inicial</label>
                        <select name="est_reparacion" class="form-select">
                            <option value="Pendiente">Pendiente</option>
                            <option value="En revision">En revisión</option>
                            <option value="En Reparacion">En reparación</option>
                        </select>
                    </div>

                    {{-- NUEVO CAMPO: PRECIO --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Costo Estimado</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number"
                                   name="costo"
                                   class="form-control"
                                   step="0.01"
                                   min="0"
                                   placeholder="0.00"
                                   required>
                        </div>
                    </div>
                </div>

                {{-- FILA 3: DESCRIPCIÓN --}}
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Descripción del Problema / Falla</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Ej: Pantalla rota, no carga, se reinicia..." required></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ url('tecnico/reparaciones') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Guardar Reparación</button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT (Se mantiene igual) --}}
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
