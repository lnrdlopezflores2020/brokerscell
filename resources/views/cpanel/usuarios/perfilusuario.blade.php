@php
    $layout = 'cpanel/plantilla'; // Plantilla por defecto (ej. para admin)

    switch(auth()->user()->rol_usuario) {
        case 'cliente':
            $layout = 'cpanel/plantillaClientes'; // Ruta a la plantilla de cliente
            break;
        case 'tecnico':
            $layout = 'cpanel/plantillaTecnicos'; // Ruta a la plantilla de técnico
            break;
    }
@endphp

@extends($layout)
@section('title', 'perfil')
@section('content')
    {{-- Usamos la misma estructura de tarjeta principal que tus otras pantallas --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            
            {{-- 1. ENCABEZADO (Fila superior) --}}
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-dark border-start border-5 border-primary ps-3 mb-1">Mi Perfil</h2>
                    <p class="text-muted ms-3 mb-0">Gestiona tu información personal y credenciales de acceso.</p>
                </div>
            </div>

            {{-- 2. CONTENIDO DEL PERFIL (Cuadrícula) --}}
            <div class="row g-4">
                
                {{-- COLUMNA IZQUIERDA: Tarjeta de Identidad --}}
                <div class="col-lg-4">
                    <div class="card border border-light bg-light h-100 rounded-4 text-center">
                        <div class="card-body d-flex flex-column align-items-center py-4">
                            
                            {{-- Avatar --}}
                            <div class="position-relative mb-3">
                                <img src="/assets/images/usuario (1).png" alt="Avatar" class="rounded-circle border border-4 border-white shadow-sm bg-white" width="120" height="120" style="object-fit: cover;">
                                <span class="position-absolute bottom-0 start-100 translate-middle p-2 bg-success border border-2 border-white rounded-circle" title="En línea">
                                    <span class="visually-hidden">Activo</span>
                                </span>
                            </div>

                            {{-- Lógica para mostrar el NOMBRE principal --}}
                            <h4 class="fw-bold mb-1">
                                @if(auth()->user()->rol_usuario == 'administrador' && auth()->user()->datosAdmin)
                                    {{ auth()->user()->datosAdmin->nombre }} {{ auth()->user()->datosAdmin->apellido }}
                                @elseif(auth()->user()->rol_usuario == 'tecnico' && auth()->user()->datosTecnico)
                                    {{ auth()->user()->datosTecnico->nombre }} {{ auth()->user()->datosTecnico->apellido }}
                                @elseif(auth()->user()->rol_usuario == 'cliente' && auth()->user()->datosCliente)
                                    {{ auth()->user()->datosCliente->nombre }} {{ auth()->user()->datosCliente->apellido }}
                                @else
                                    {{ auth()->user()->name ?? 'Usuario del Sistema' }}
                                @endif
                            </h4>

                            {{-- Rol con Badge --}}
                            <span class="badge rounded-pill bg-primary mt-2 mb-3 px-4 py-2 text-uppercase">
                                <i class="bi bi-shield-check me-1"></i> {{ auth()->user()->rol_usuario }}
                            </span>

                            {{-- Email (Añadido text-break para evitar que un correo largo deforme la tarjeta) --}}
                            <p class="text-muted mb-4 px-2 text-break w-100">
                                <i class="bi bi-envelope-at me-2 text-primary"></i>{{ auth()->user()->emai }}
                            </p>

                            <div class="w-100 mt-auto px-3">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-outline-danger w-100 fw-medium rounded-3" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- COLUMNA DERECHA: Detalles Específicos por Rol --}}
                <div class="col-lg-8">
                    <div class="card border border-light h-100 rounded-4 shadow-sm">
                        <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                            <h5 class="card-title fw-bold text-dark m-0">
                                <i class="bi bi-person-vcard text-primary me-2"></i>Información Detallada
                            </h5>
                        </div>
                        
                        <div class="card-body p-0">
                            @switch(auth()->user()->rol_usuario)

                                {{-- CASO 1: ADMINISTRADOR --}}
                                @case('administrador')
                                    @if(auth()->user()->datosAdmin)
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                                <span class="text-muted fw-medium"><i class="bi bi-hash me-2"></i>ID Admin</span>
                                                <span class="fw-bold">#{{ auth()->user()->datosAdmin->Id_admin }}</span>
                                            </li>
                                            <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                                <span class="text-muted fw-medium"><i class="bi bi-person me-2"></i>Nombre</span>
                                                <span class="fw-medium text-dark">{{ auth()->user()->datosAdmin->nombre ?? 'No registrado' }}</span>
                                            </li>
                                            <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                                <span class="text-muted fw-medium"><i class="bi bi-person-badge me-2"></i>Apellido</span>
                                                <span class="fw-medium text-dark">{{ auth()->user()->datosAdmin->apellido ?? 'No registrado' }}</span>
                                            </li>
                                        </ul>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-person-x text-warning display-1 mb-3 opacity-50"></i>
                                            <h5 class="fw-bold text-dark">Perfil Incompleto</h5>
                                            <p class="text-muted">Faltan tus datos personales en los registros administrativos.</p>
                                        </div>
                                    @endif
                                    @break

                                {{-- CASO 2: TÉCNICO --}}
                                @case('tecnico')
                                    @if(auth()->user()->datosTecnico)
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                                <span class="text-muted fw-medium"><i class="bi bi-wrench-adjustable me-2"></i>ID Técnico</span>
                                                <span class="fw-bold text-primary">#{{ auth()->user()->datosTecnico->ID_tec }}</span>
                                            </li>
                                            <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                                <span class="text-muted fw-medium"><i class="bi bi-person me-2"></i>Nombre</span>
                                                <span class="fw-medium text-dark">{{ auth()->user()->datosTecnico->nombre }}</span>
                                            </li>
                                            <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                                <span class="text-muted fw-medium"><i class="bi bi-person-badge me-2"></i>Apellido</span>
                                                <span class="fw-medium text-dark">{{ auth()->user()->datosTecnico->apellido }}</span>
                                            </li>
                                            <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                                <span class="text-muted fw-medium"><i class="bi bi-telephone me-2"></i>Teléfono</span>
                                                <span class="fw-medium text-dark">{{ auth()->user()->datosTecnico->tel_tecnico ?? 'No registrado' }}</span>
                                            </li>
                                        </ul>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-tools text-warning display-1 mb-3 opacity-50"></i>
                                            <h5 class="fw-bold text-dark">Perfil Incompleto</h5>
                                            <p class="text-muted">Faltan tus datos en los registros técnicos.</p>
                                        </div>
                                    @endif
                                    @break

                                {{-- CASO 3: CLIENTE --}}
                                @case('cliente')
                                    @if(auth()->user()->datosCliente)
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                                <span class="text-muted fw-medium"><i class="bi bi-person-bounding-box me-2"></i>No. Cliente</span>
                                                <span class="fw-bold text-primary">#{{ auth()->user()->datosCliente->ID_client }}</span>
                                            </li>
                                            <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                                <span class="text-muted fw-medium"><i class="bi bi-person me-2"></i>Nombre Completo</span>
                                                <span class="fw-medium text-dark">{{ auth()->user()->datosCliente->nombre }} {{ auth()->user()->datosCliente->apellido }}</span>
                                            </li>
                                            <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                                <span class="text-muted fw-medium"><i class="bi bi-telephone me-2"></i>Teléfono</span>
                                                <span class="fw-medium text-dark">{{ auth()->user()->datosCliente->telefono ?? 'No registrado' }}</span>
                                            </li>
                                            <li class="list-group-item px-4 py-3 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                                                <span class="text-muted fw-medium mb-2 mb-sm-0"><i class="bi bi-geo-alt me-2"></i>Dirección</span>
                                                <span class="fw-medium text-dark text-sm-end">
                                                    {{ auth()->user()->datosCliente->direccion }}<br>
                                                    <small class="text-muted">Ext: {{ auth()->user()->datosCliente->num_ext }} | Int: {{ auth()->user()->datosCliente->num_int ?? 'S/N' }}</small>
                                                </span>
                                            </li>
                                        </ul>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-house-exclamation text-warning display-1 mb-3 opacity-50"></i>
                                            <h5 class="fw-bold text-dark">Perfil Incompleto</h5>
                                            <p class="text-muted">No se encontró tu información de contacto en el sistema.</p>
                                        </div>
                                    @endif
                                    @break

                                {{-- CASO POR DEFECTO --}}
                                @default
                                    <div class="text-center py-5">
                                        <i class="bi bi-question-circle text-secondary display-1 mb-3 opacity-50"></i>
                                        <h5 class="fw-bold text-dark">Rol desconocido</h5>
                                        <p class="text-muted">El rol "{{ auth()->user()->rol_usuario }}" no tiene una vista detallada configurada.</p>
                                    </div>
                            @endswitch
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection