@php
    $layout = 'cpanel/plantilla'; // Plantilla por defecto (ej. para admin)

    switch(auth()->user()->rol_usuario) {
        case 'tecnico':
            $layout = 'cpanel/plantillaTecnicos'; // Ruta a la plantilla de técnico
            break;
    }
@endphp
@extends($layout)
@section('title', 'dispositivos')
@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                {{-- CAMBIO: Icono de dispositivo en lugar de personas --}}
                <h4 class="card-title h1 m-0"><i class="bi bi-pc-display-horizontal me-2"></i>Dispositivos</h4>
                <div>
                    <a class="btn btn-primary" href="{{url('/tecnico/dispositivos/create')}}" role="button">
                        <i class="bi bi-plus-lg"></i> Agregar Dispositivo
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                    <tr>
                        {{-- CAMBIO: Iconos añadidos a los encabezados --}}
                        <th scope="col"><i class="bi bi-hash"></i> ID</th>
                        <th scope="col"><i class="bi bi-laptop"></i> Tipo</th>
                        <th scope="col"><i class="bi bi-tag-fill"></i> Marca</th>
                        <th scope="col"><i class="bi bi-cpu"></i> Modelo</th>
                        <th scope="col" class="text-center" style="width: 150px;"><i class="bi bi-gear-fill"></i> Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $fila)
                        <tr>
                            <td class="fw-bold">
                            <span class="badge bg-secondary">
                                <i class="bi bi-qr-code me-1"></i>{{$fila->ID_tel}}
                            </span>
                            </td>
                            <td> {{$fila->tipo}} </td>
                            <td> <i class="bi bi-patch-check text-muted me-1"></i>{{$fila->marca}} </td>
                            <td> {{$fila->modelo}} </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    {{-- Botón Editar --}}
                                    <a class="btn btn-sm btn-outline-info" href="{{url('/tecnico/dispositivos/'.$fila->ID_tel.'/edit')}}" title="Editar">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>

                                    <form action="{{url('/tecnico/dispositivos/' . $fila->ID_tel) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-outline-danger" type="submit"
                                                onclick="return confirm('¿Confirmas que deseas eliminar el dispositivo? {{$fila->marca}} {{$fila->modelo}}');"
                                                title="Eliminar">
                                            Eliminar <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            {{-- CAMBIO: Icono para estado vacío --}}
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-inbox display-1 mb-3 text-secondary" style="opacity: 0.5;"></i>
                                    <h5>No hay dispositivos registrados</h5>
                                    <p class="small">Comienza agregando uno nuevo con el botón superior.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
