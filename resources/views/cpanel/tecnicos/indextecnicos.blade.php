@extends('cpanel/plantilla')
@section('title', 'tecnicos')
@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title h1 m-0"><i class="bi bi-people-fill me-2"></i>Técnicos</h4>
                <div>
                    <a class="btn btn-primary" href="/admon/tecnicos/create" role="button">
                        <i class="bi bi-plus-lg"></i> Agregar Técnico
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col"># Técnico</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col" class="text-center" style="width: 150px;">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $fila)
                        <tr>
                            <td class="fw-bold"> <span class="badge bg-secondary">{{$fila->ID_tec}} </span></td>
                            <td> {{$fila->nombre}} </td>
                            <td> {{$fila->apellido}} </td>
                            <td> {{$fila->tel_tecnico}} </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    {{-- Botón Editar --}}
                                    <a class="btn btn-sm btn-outline-info" href="{{url('/admon/tecnicos/'.$fila->ID_tec.'/edit')}}" title="Editar">
                                        Editar <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Botón Eliminar --}}
                                    <form action="{{url('/admon/tecnicos', $fila->ID_tec)}}" method="post" class="d-inline">
                                        @csrf
                                        {{method_field('DELETE')}}
                                        <button class="btn btn-sm btn-outline-danger" type="submit"
                                                onclick="return confirm('¿Estás seguro de eliminar al tecnico {{$fila->nombre}} {{$fila->apellido}}? Esta acción no se puede deshacer.')" title="Eliminar">
                                            Eliminar<i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                No hay técnicos registrados en este momento.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
