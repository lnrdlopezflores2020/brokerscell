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
    <div class="container py-2">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark border-start border-5 border-primary ps-3">Mi Perfil</h2>
            </div>
        </div>

        <div class="row">
            {{-- ================================================= --}}
            {{-- COLUMNA IZQUIERDA: Tarjeta de Identidad Genérica  --}}
            {{-- ================================================= --}}
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 text-center h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center py-5">

                        {{-- Avatar --}}
                        <div class="position-relative mb-3">
                            <img src="/assets/images/usuario (1).png" alt="Avatar" class="rounded-circle border border-3 border-light shadow-sm" width="120" height="120" style="object-fit: cover; background-color: #f8f9fa;">
                            <span class="position-absolute bottom-0 start-100 translate-middle p-2 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">Activo</span>
                        </span>
                        </div>

                        {{-- Lógica para mostrar el NOMBRE según el rol --}}
                        <h4 class="mb-1">
                            @if(auth()->user()->rol_usuario == 'administrador' && auth()->user()->datosAdmin)
                                {{ auth()->user()->datosAdmin->nombre }} {{ auth()->user()->datosAdmin->apellido }}

                            @elseif(auth()->user()->rol_usuario == 'tecnico' && auth()->user()->datosTecnico)
                                {{-- Ajusta 'nombre' si tu tabla tecnico lo llama diferente --}}
                                {{ auth()->user()->datosTecnico->nombre }} {{ auth()->user()->datosTecnico->apellido }}

                            @elseif(auth()->user()->rol_usuario == 'cliente' && auth()->user()->datosCliente)
                                {{-- Ajusta 'nombre' si tu tabla cliente lo llama diferente --}}
                                {{ auth()->user()->datosCliente->nombre }} {{ auth()->user()->datosCliente->apellido }}

                            @else
                                Usuario del Sistema
                            @endif
                        </h4>

                        {{-- Rol con Badge --}}
                        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2">
                        {{ strtoupper(auth()->user()->rol_usuario) }}
                    </span>

                        {{-- Email (Usando 'emai' como indicaste que se llama en tu BD) --}}
                        <p class="text-muted mb-4">
                            <i class="bi bi-envelope me-2"></i>{{ auth()->user()->emai }}
                        </p>

                        <div class="d-grid gap-2 w-100 px-3 mt-auto">
                            <form action="{{ route('logout') }}" method="POST" class="d-grid">
                                @csrf
                                <button class="btn btn-outline-danger" type="submit">
                                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================= --}}
            {{-- COLUMNA DERECHA: Detalles Específicos por Rol     --}}
            {{-- ================================================= --}}
            {{-- COLUMNA DERECHA: Detalles Específicos por Rol --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h5 class="card-title fw-bold text-primary">
                            <i class="bi bi-person-lines-fill me-2"></i>Información Detallada
                        </h5>
                    </div>
                    <div class="card-body px-4">

                        @switch(auth()->user()->rol_usuario)

                            {{-- CASO 1: ADMINISTRADOR --}}
                            @case('administrador')
                                @if(auth()->user()->datosAdmin)
                                    <div class="row g-3">
                                        <div class="col-sm-4 text-muted fw-medium">ID Admin</div>
                                        <div class="col-sm-8 fw-bold">#{{ auth()->user()->datosAdmin->Id_admin }}</div> <div class="col-12"><hr class="text-muted opacity-25"></div>

                                        <div class="col-sm-4 text-muted fw-medium">correo</div>
                                        <div class="col-sm-8">{{ auth()->user()->emai ?? 'General' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>

                                        <div class="col-sm-4 text-muted fw-medium">Nombre</div>
                                        <div class="col-sm-8">{{ auth()->user()->datosAdmin->nombre ?? 'No registrado' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>

                                        <div class="col-sm-4 text-muted fw-medium">Apellido</div>
                                        <div class="col-sm-8">{{ auth()->user()->datosAdmin->apellido ?? 'General' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>
                                    </div>
                                @else
                                    {{-- MENSAJE DE ERROR SI NO HAY DATOS --}}
                                    <div class="text-center py-5">
                                        <i class="bi bi-exclamation-circle text-warning display-4 mb-3"></i>
                                        <h5 class="text-muted">Perfil Incompleto</h5>
                                        <p class="small">Eres Administrador, pero faltan tus datos en la tabla 'administrador'.</p>
                                    </div>
                                @endif
                                @break

                                {{-- CASO 2: TÉCNICO --}}
                            @case('tecnico')
                                @if(auth()->user()->datosTecnico)
                                    <div class="row g-3">
                                        <div class="col-sm-4 text-muted fw-medium">ID Técnico</div>
                                        <div class="col-sm-8 fw-bold">#{{ auth()->user()->datosTecnico->ID_tec ?? 'N/A' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>

                                        <div class="col-sm-4 text-muted fw-medium">Nombre</div>
                                        {{-- CAMBIA 'especialidad' POR TU COLUMNA REAL --}}
                                        <div class="col-sm-8">{{ auth()->user()->datosTecnico->nombre ?? 'General' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>

                                        <div class="col-sm-4 text-muted fw-medium">Nombre</div>
                                        {{-- CAMBIA 'especialidad' POR TU COLUMNA REAL --}}
                                        <div class="col-sm-8">{{ auth()->user()->datosTecnico->apellido ?? 'General' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>

                                        <div class="col-sm-4 text-muted fw-medium">Nombre</div>
                                        {{-- CAMBIA 'especialidad' POR TU COLUMNA REAL --}}
                                        <div class="col-sm-8">{{ auth()->user()->datosTecnico->tel_tecnico ?? 'General' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>
                                    </div>
                                @else
                                    {{-- MENSAJE DE ERROR SI NO HAY DATOS --}}
                                    <div class="text-center py-5">
                                        <i class="bi bi-exclamation-circle text-warning display-4 mb-3"></i>
                                        <h5 class="text-muted">Perfil Incompleto</h5>
                                        <p class="small">Eres Técnico, pero faltan tus datos en la tabla 'tecnico'.</p>
                                    </div>
                                @endif
                                @break

                                {{-- CASO 3: CLIENTE --}}
                            @case('cliente')
                                @if(auth()->user()->datosCliente)
                                    <div class="row g-3">
                                        <div class="col-sm-4 text-muted fw-medium">No. Cliente</div>
                                        <div class="col-sm-8 fw-bold">#{{ auth()->user()->datosCliente->ID_client ?? 'N/A' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>

                                        <div class="col-sm-4 text-muted fw-medium">Nombre</div>
                                        {{-- CAMBIA 'direccion' POR TU COLUMNA REAL --}}
                                        <div class="col-sm-8">{{ auth()->user()->datosCliente->nombre ?? 'Sin dirección' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>

                                        <div class="col-sm-4 text-muted fw-medium">Apellido</div>
                                        {{-- CAMBIA 'telefono' POR TU COLUMNA REAL --}}
                                        <div class="col-sm-8">{{ auth()->user()->datosCliente->apellido ?? 'Sin teléfono' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>

                                        <div class="col-sm-4 text-muted fw-medium">Teléfono</div>
                                        {{-- CAMBIA 'telefono' POR TU COLUMNA REAL --}}
                                        <div class="col-sm-8">{{ auth()->user()->datosCliente->telefono ?? 'Sin teléfono' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>

                                        <div class="col-sm-4 text-muted fw-medium">Direccion</div>
                                        {{-- CAMBIA 'telefono' POR TU COLUMNA REAL --}}
                                        <div class="col-sm-8">{{ auth()->user()->datosCliente->direccion ?? 'Sin teléfono' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>

                                        <div class="col-sm-4 text-muted fw-medium">Num. Exterior</div>
                                        {{-- CAMBIA 'telefono' POR TU COLUMNA REAL --}}
                                        <div class="col-sm-8">{{ auth()->user()->datosCliente->num_ext ?? 'Sin teléfono' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>

                                        <div class="col-sm-4 text-muted fw-medium">Num. Interior</div>
                                        {{-- CAMBIA 'telefono' POR TU COLUMNA REAL --}}
                                        <div class="col-sm-8">{{ auth()->user()->datosCliente->num_int ?? 'Sin teléfono' }}</div>
                                        <div class="col-12"><hr class="text-muted opacity-25"></div>
                                    </div>
                                @else
                                    {{-- MENSAJE DE ERROR SI NO HAY DATOS --}}
                                    <div class="text-center py-5">
                                        <i class="bi bi-exclamation-circle text-warning display-4 mb-3"></i>
                                        <h5 class="text-muted">Perfil Incompleto</h5>
                                        <p class="small">Eres Cliente, pero faltan tus datos en la tabla 'cliente'.</p>
                                    </div>
                                @endif
                                @break

                                {{-- CASO POR DEFECTO --}}
                            @default
                                <div class="text-center py-5">
                                    <h5 class="text-muted">Rol desconocido</h5>
                                    <p>El rol "{{ auth()->user()->rol_usuario }}" no tiene una vista configurada.</p>
                                </div>

                        @endswitch

                    </div>
                </div>
            </div>

    {{-- Componente pequeño para no repetir código HTML cuando falta el perfil --}}
    {{-- Puedes poner esto al final de tu archivo blade o en un archivo aparte --}}
    @verbatim
        <?php
// Esto es un truco rápido para simular un componente si no quieres crear un archivo nuevo
// Si prefieres, simplemente copia el HTML del "else" en cada caso de arriba.
        ?>
    @endverbatim

    @if(!auth()->user()->datosAdmin && !auth()->user()->datosTecnico && !auth()->user()->datosCliente)
        {{-- Este bloque solo se muestra si fallan las cargas de datos --}}
        <div class="alert alert-warning mt-3">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Tu usuario tiene rol de <strong>{{ auth()->user()->rol_usuario }}</strong>, pero no se encontraron datos en la tabla correspondiente.
        </div>
    @endif
@endsection
