    @extends('cpanel/plantillaClientes')
    @section('title', 'Mis Reparaciones')
    @section('content')
        {{-- CONTENEDOR PRINCIPAL con seguridad de ancho --}}
        <div class="container-fluid py-4 w-100" style="min-width: 320px;">

            {{-- ENCABEZADO --}}
            <div class="row mb-5 border-bottom pb-3 align-items-end">
                <div class="col-md-8">
                    <h6 class="text-uppercase text-primary fw-bold mb-1 small ls-1">PANEL DE CLIENTE</h6>
                    <h2 class="fw-bold text-dark mb-0">Mis Reparaciones</h2>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-inline-block bg-light px-3 py-2 rounded-3 border">
                        <small class="d-block text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">
                            USUARIO ACTIVO
                        </small>
                        <div class="fw-bold text-dark">
                            <i class="bi bi-person-circle text-primary me-1"></i> {{ auth()->user()->name }}
                        </div>
                    </div>
                </div>
            </div>

            @if($reparaciones->isEmpty())
                <div class="alert alert-secondary text-center border-0 shadow-sm p-5 rounded-4 bg-light">
                    <i class="bi bi-tools display-4 text-muted opacity-50 mb-3"></i>
                    <h4 class="fw-bold text-muted">Sin reparaciones activas</h4>
                </div>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach($reparaciones as $item)
                        @php
                            $color = 'secondary';
                            $icon = 'bi-circle';
                            if($item->est_reparacion == 'En revision') { $color = 'warning'; $icon = 'bi-search'; }
                            elseif($item->est_reparacion == 'En Reparacion') { $color = 'primary'; $icon = 'bi-wrench'; }
                            elseif($item->est_reparacion == 'Terminado') { $color = 'success'; $icon = 'bi-check-circle-fill'; }
                            elseif($item->est_reparacion == 'Entregado') { $color = 'dark'; $icon = 'bi-archive-fill'; }
                        @endphp

                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden w-100">
                            <div class="card-body p-4">
                                {{-- USAMOS ROW DE BOOTSTRAP: --}}
                                {{-- En pantallas pequeñas (col-12) se apilan. En grandes (col-lg-3) se ponen al lado. --}}
                                <div class="row g-4">

                                    {{-- 1. DISPOSITIVO --}}
                                    <div class="col-12 col-md-6 col-lg-3 border-end-lg">
                                        {{-- TITULO (Arriba) --}}
                                        <div class="text-uppercase text-muted fw-bold mb-2 small" style="font-size: 0.65rem; letter-spacing: 1px;">
                                            FOLIO & DISPOSITIVO
                                        </div>
                                        {{-- CONTENIDO (Abajo) --}}
                                        <div>
                                        <span class="badge bg-light text-dark border mb-1">
                                            #{{ str_pad($item->ID_rep, 6, '0', STR_PAD_LEFT) }}
                                        </span>
                                            <h5 class="fw-bold text-dark mb-0">
                                                {{ $item->dispositivo->marca }} {{ $item->dispositivo->modelo }}
                                            </h5>
                                            <small class="text-muted">{{ $item->dispositivo->tipo }}</small>
                                        </div>
                                    </div>

                                    {{-- 2. FALLA --}}
                                    <div class="col-12 col-md-6 col-lg-3 border-end-lg">
                                        {{-- TITULO (Arriba) --}}
                                        <div class="text-uppercase text-muted fw-bold mb-2 small" style="font-size: 0.65rem; letter-spacing: 1px;">
                                            MOTIVO DE INGRESO
                                        </div>
                                        {{-- CONTENIDO (Abajo) --}}
                                        <div class="bg-light rounded p-2 border border-light h-100 d-flex align-items-center">
                                            <p class="mb-0 text-dark small fst-italic lh-sm">
                                                "{{ Str::limit($item->descripcion, 80) }}"
                                            </p>
                                        </div>
                                    </div>

                                    {{-- 3. FECHAS Y COSTO --}}
                                    <div class="col-12 col-md-6 col-lg-3 border-end-lg">
                                        <div class="row">
                                            <div class="col-6">
                                                {{-- TITULO --}}
                                                <div class="text-uppercase text-muted fw-bold mb-1 small" style="font-size: 0.65rem;">
                                                    ENTREGA
                                                </div>
                                                {{-- CONTENIDO --}}
                                                <div class="fw-bold text-primary">
                                                    {{ \Carbon\Carbon::parse($item->fec_est_entrega)->format('d M') }}
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                {{-- TITULO --}}
                                                <div class="text-uppercase text-muted fw-bold mb-1 small" style="font-size: 0.65rem;">
                                                    COSTO
                                                </div>
                                                {{-- CONTENIDO --}}
                                                <div class="fw-bold text-success fs-5">
                                                    ${{ number_format($item->costo, 0) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 4. ESTADO --}}
                                    <div class="col-12 col-md-6 col-lg-3">
                                        {{-- TITULO --}}
                                        <div class="text-uppercase text-muted fw-bold mb-2 small" style="font-size: 0.65rem; letter-spacing: 1px;">
                                            ESTADO ACTUAL
                                        </div>
                                        {{-- CONTENIDO --}}
                                        <div>
                                            <div class="badge bg-{{ $color == 'warning' ? 'warning text-dark' : $color }} w-100 py-2 mb-2 d-flex justify-content-center align-items-center">
                                                <i class="bi {{ $icon }} me-2"></i> {{ strtoupper($item->est_reparacion) }}
                                            </div>

                                            @if($item->est_reparacion == 'Terminado' || $item->est_reparacion == 'Entregado')
                                                {{-- BOTÓN MODIFICADO PARA EL TUTORIAL --}}
                                                <button onclick="mostrarInstrucciones('{{ route('cliente.nota_entrega', $item->ID_rep) }}', '{{ str_pad($item->ID_rep, 6, '0', STR_PAD_LEFT) }}')"
                                                        class="btn btn-outline-dark btn-sm w-100 fw-bold">
                                                    <i class="bi bi-info-circle me-1"></i> Obtener Nota
                                                </button>
                                            @else
                                                <button class="btn btn-light btn-sm w-100 text-muted border" disabled>
                                                    <span class="spinner-grow spinner-grow-sm me-1"></span> Procesando
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- Barra inferior decorativa --}}
                            <div class="bg-{{ $color }}" style="height: 5px;"></div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <style>
            /* Solo poner linea divisoria en pantallas grandes (Desktop) */
            @media (min-width: 992px) {
                .border-end-lg {
                    border-right: 1px solid #e9ecef !important;
                }
            }
        </style>

        {{-- Agregamos SweetAlert2 desde CDN (si ya lo tienes en tu layout, borra esta linea) --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function mostrarInstrucciones(urlPdf, folio) {
                Swal.fire({
                    title: '<strong>Instrucciones de Entrega</strong>',
                    icon: 'info',
                    html: `
                <div class="text-start fs-6">
                    <p class="mb-2">Para recoger tu equipo, es necesario presentar la <b>Nota de Entrega</b>.</p>
                    <p class="mb-3">Tienes dos opciones:</p>

                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-printer-fill text-secondary me-3 fs-4"></i>
                            <div>
                                <strong>Opción A:</strong><br>
                                Descargar e imprimirla tú mismo.
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-whatsapp text-success me-3 fs-4"></i>
                            <div>
                                <strong>Opción B:</strong><br>
                                Enviarla a nuestro WhatsApp para que nosotros la imprimamos.
                            </div>
                        </li>
                    </ul>
                    <p class="small text-muted text-center mb-0">Selecciona una opción abajo 👇</p>
                </div>
            `,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: '<i class="bi bi-whatsapp"></i> Enviar a WhatsApp',
                    denyButtonText: '<i class="bi bi-file-earmark-pdf"></i> Solo Descargar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#25D366', // Color WhatsApp
                    denyButtonColor: '#343a40',   // Color Oscuro

                    // Lógica de los botones
                    preConfirm: () => {
                        // NUMERO DE TELEFONO CONFIGURADO
                        const telefono = '5212482660871';
                        const mensaje = `Hola SoluxMovil, envío mi nota de entrega con Folio #${folio} para su impresión.`;

                        // Abrir WhatsApp
                        window.open(`https://wa.me/${telefono}?text=${encodeURIComponent(mensaje)}`, '_blank');

                        // Opcional: También descargar el PDF aunque lo manden por whats
                        window.location.href = urlPdf;
                    }
                }).then((result) => {
                    if (result.isDenied) {
                        // Si eligen "Solo Descargar"
                        window.open(urlPdf, '_blank');
                    }
                });
            }
        </script>
    @endsection
