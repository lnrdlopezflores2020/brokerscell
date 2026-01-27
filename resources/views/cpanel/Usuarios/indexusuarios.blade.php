@extends('cpanel/plantilla')
@section('title','Usuarios')
@section('content')
    <div class="card shadow-sm border-10">
        <div class="card-body">
            {{-- Encabezado con título y botón alineados --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title h1 m-0"><i class="bi bi-people-fill me-2"></i>Usuarios</h4>
                <div>
                    <a class="btn btn-success me-2" href="{{ route('reportes.excel') }}" target="_blank" role="button">
                        <i class="bi bi-file-earmark-pdf"></i> Reporte Excel
                    </a>
                    <a class="btn btn-primary" href="/admon/usuarios/create" role="button">
                        <i class="bi bi-plus-lg"></i> Agregar usuario
                    </a>
                </div>
            </div>

            {{--
                CAMBIO 1: Agregamos max-height (altura máxima) y overflow-y: auto
                Esto crea la caja con scroll. Puedes cambiar 400px por la altura que desees (ej: 60vh).
            --}}
            <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                <table class="table table-hover table-bordered align-middle">
                    {{--
                        CAMBIO 2: position: sticky y top: 0
                        Esto hace que el encabezado se quede "pegado" arriba al bajar.
                    --}}
                    <thead class="table-dark" style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                        <th scope="col" class="text-center" style="width: 80px;">ID</th>
                        <th scope="col">Email / Correo</th>
                        <th scope="col" class="text-center">Rol</th>
                        <th scope="col" class="text-center" style="width: 150px;">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $fila)
                        <tr>
                            <td class="text-center fw-bold"> {{$fila->ID_usuario}} </td>

                            <td>
                                <a href="mailto:{{$fila->emai}}" class="text-decoration-none text-dark">
                                    <i class="bi bi-envelope me-2 text-muted"></i>{{$fila->emai}}
                                </a>
                            </td>

                            {{-- Badge dinámico para el Rol --}}
                            <td class="text-center">
                                @if(strtolower($fila->rol_usuario) == 'admin' || strtolower($fila->rol_usuario) == 'administrador')
                                    <span class="badge rounded-pill bg-danger">
                                    <i class="bi bi-shield-lock-fill me-1"></i>{{$fila->rol_usuario}}
                                </span>
                                @else
                                    <span class="badge rounded-pill bg-primary">
                                    <i class="bi bi-person-fill me-1"></i>{{$fila->rol_usuario}}
                                </span>
                                @endif
                            </td>

                            {{-- Acciones unificadas --}}
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a class="btn btn-sm btn-outline-info" href="{{url('/admon/usuarios/'.$fila->ID_usuario.'/edit')}}" title="Editar">
                                        Editar <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{url('/admon/usuarios', $fila->ID_usuario)}}" method="post" class="d-inline">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        <button class="btn btn-sm btn-outline-danger" type="submit"
                                                onclick="return confirm('¿Estás seguro de eliminar al usuario {{$fila->emai}}? Esta acción es irreversible.')" title="Eliminar">
                                            Eliminar<i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="bi bi-emoji-frown display-6 d-block mb-2"></i>
                                No hay usuarios registrados en el sistema.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
