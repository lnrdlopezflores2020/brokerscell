<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Reparaciones</title>
    <style>
        {{ file_get_contents(public_path('assets/css/Style_reporte.css')) }}
    </style>
</head>
<body>

<<div class="header-container">
    <img src="{{ public_path('assets/images/SOLUXMOVIL.png') }}" class="logo" alt="Logo" style="width: 90px">

    <div class="header-text">
        <h1>Historial de Reparaciones</h1>
        <p>SoluxMovil</p>
        <p>Fecha: {{ date('d/m/Y') }}</p>
    </div>
</div>

<table class="table table-hover table-bordered align-middle">
    <thead class="table-dark">
    <tr>
        <th scope="col"><i class="bi bi-hash"></i> # Orden</th>
        <th scope="col"><i class="bi bi-card-text"></i> Descripción</th>
        <th scope="col"><i class="bi bi-calendar-event"></i> Fecha Inicio</th>
        <th scope="col"><i class="bi bi-calendar-check"></i> Fecha Estimada de Entrega</th>
        <th scope="col"><i class="bi bi-activity"></i> Estado</th>
        <th scope="col"><i class="bi bi-currency-dollar"></i> Costo</th>
    </tr>
    </thead>
    <tbody>
    @forelse($data as $fila)
        <tr>
            <td class="fw-bold"> <span class="badge bg-secondary">{{$fila->ID_rep}} </span></td>
            <td> {{$fila->descripcion}} </td>
            <td> {{$fila->fec_inicio}} </td>
            <td> {{$fila->fec_est_entrega}} </td>
            <td>
                <i class="bi bi-info-circle me-1 text-primary"></i>
                {{$fila->est_reparacion}}
            </td>
            <td class="fw-bold text-success">${{$fila->costo}}</td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-4 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                No hay reparaciones registradas en este momento.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>
