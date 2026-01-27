@php
    // 1. Limpiamos el rol para evitar errores de espacios
    $rol = strtolower(trim(auth()->user()->rol_usuario));

    // 2. Lógica EXPLICITA:
    // Si la base de datos dice que eres administrador, OBLIGAMOS a usar 'admon'
    // sin importar lo que diga la URL.
    if ($rol === 'administrador') {
        $layout = 'cpanel/plantilla';
        $url_prefix = 'admon';
    } else {
        // Para cualquier otro caso (tecnico), usamos la ruta de técnico
        $layout = 'cpanel/plantillaTecnicos';
        $url_prefix = 'tecnico';
    }
@endphp

@extends($layout)
@section('title','clientes')
@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title h1 m-0"><i class="bi bi-people-fill me-2"></i>Clientes</h4>
                <div>
                    {{-- Botón PDF: Solo para admin --}}
                    @if(auth()->user()->rol_usuario === 'administrador')
                        <a class="btn btn-success me-2" href="{{url('admon/reportes/pdfClientes')}}" target="_blank" role="button">
                            <i class="bi bi-file-earmark-pdf"></i> Reporte PDF
                        </a>
                        <a class="btn btn-success me-2" href="{{ route('reportes.excel') }}" target="_blank">
                            <i class="bi bi-file-earmark-excel"></i> Reporte Excel
                        </a>

                    @endif

                    {{-- CORRECCIÓN 1: Botón Agregar dinámico --}}
                    {{-- Genera: /tecnico/clientes/create O /admon/clientes/create --}}
                    <a class="btn btn-primary" href="{{ url($url_prefix . '/clientes/create') }}" role="button">
                        <i class="bi bi-plus-lg"></i> Agregar Cliente
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col"># Cliente</th>
                        <th scope="col"><i class="bi bi-person-badge-fill"></i> Usuario Asociado</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Num. Ext</th>
                        <th scope="col">Num. Int</th>
                        <th scope="col" class="text-center" style="width: 150px;">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $fila)
                        <tr>
                            <td class="fw-bold"> <span class="badge bg-secondary">{{$fila->ID_client}} </span></td>
                            <td>
                                @if($fila->usuario)
                                    <span class="text-primary fw-bold">{{ $fila->usuario->name }}</span>
                                    <br>
                                    <small class="text-muted">{{ $fila->usuario->emai }}</small>
                                @else
                                    <span class="badge bg-light text-dark border">Sin usuario</span>
                                @endif
                            </td>
                            <td> {{$fila->nombre}} </td>
                            <td> {{$fila->apellido}} </td>
                            <td> {{$fila->telefono}} </td>
                            <td> {{$fila->direccion}} </td>
                            <td> {{$fila->num_ext}} </td>
                            <td> {{$fila->num_int}} </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">

                                    {{-- CORRECCIÓN 2: Botón Editar dinámico --}}
                                    {{-- Antes tenías '/admon/...', ahora usa la variable $url_prefix --}}
                                    <a class="btn btn-sm btn-outline-info"
                                       href="{{ url($url_prefix . '/clientes/' . $fila->ID_client . '/edit') }}"
                                       title="Editar">
                                        Editar <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- CORRECCIÓN 3: Formulario Eliminar --}}
                                    {{-- Corregido el error de sintaxis: se usa punto (.) para concatenar, no comas (,) --}}
                                    <form action="{{url($url_prefix . '/clientes/' . $fila->ID_client) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-outline-danger" type="submit"
                                                onclick="return confirm('¿Confirmas que deseas eliminar al cliente? {{$fila->nombre}} {{$fila->apellido}}');"
                                                title="Eliminar">
                                            Eliminar <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                No hay clientes registrados en este momento.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Tu script de SweetAlert se mantiene igual...
        @if(session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
        @endif
    </script>
@endsection
