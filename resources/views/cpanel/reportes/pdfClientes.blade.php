<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Clientes</title>
    <style>
        {{ file_get_contents(public_path('assets/css/Style_reporte.css')) }}
    </style>
</head>
<body>

<<div class="header-container">
    <img src="{{ public_path('assets/images/SOLUXMOVIL.png') }}" class="logo" alt="Logo" style="width: 90px">

    <div class="header-text">
        <h1>Reporte de Clientes</h1>
        <p>SoluxMovil</p>
        <p>Fecha: {{ date('d/m/Y') }}</p>
    </div>
</div>

<table>
    <thead>
    <tr>
        <th style="width: 5%">ID</th>
        <th>Nombre Completo</th>
        <th>Teléfono</th>
        <th>Dirección</th>
        <th class="text-center"># Ext</th>
        <th class="text-center"># Int</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $fila)
        <tr>
            <td class="text-center">{{ $fila->ID_client }}</td>
            <td>{{ $fila->nombre }} {{ $fila->apellido }}</td>
            <td>{{ $fila->telefono }}</td>
            <td>{{ $fila->direccion }}</td>
            <td class="text-center">{{ $fila->num_ext }}</td>
            <td class="text-center">{{ $fila->num_int ?? '-' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
