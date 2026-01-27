<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entrega de Equipo #{{ $reparacion->ID_rep }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; margin: 2cm; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #28a745; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 20px; font-weight: bold; color: #28a745; text-transform: uppercase; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px; border-bottom: 1px solid #eee; }
        .label { font-weight: bold; width: 120px; }
        .box { background: #f9f9f9; padding: 15px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 20px; }
        .signature { margin-top: 50px; text-align: center; }
        .line { border-top: 1px solid #000; width: 60%; margin: 0 auto; padding-top: 5px; }
    </style>
</head>
<body>

<div class="header">
    <div class="title">SOLUXMOVIL</div>
    <small>Nota de Entrega y Conformidad</small>
    <div style="margin-top: 10px; font-size: 14px;">FOLIO: <strong>#{{ str_pad($reparacion->ID_rep, 6, '0', STR_PAD_LEFT) }}</strong></div>
</div>

<p style="text-align: right;">Fecha de Entrega: {{ date('d/m/Y') }}</p>

<div class="box">
    <strong>Detalles del Equipo Entregado:</strong>
    <table class="info-table">
        <tr>
            <td class="label">Cliente:</td>
            <td>{{ $reparacion->dispositivo->cliente->nombre }} {{ $reparacion->dispositivo->cliente->apellido }}</td>
        </tr>
        <tr>
            <td class="label">Dispositivo:</td>
            <td>{{ $reparacion->dispositivo->marca }} {{ $reparacion->dispositivo->modelo }}</td>
        </tr>
        <tr>
            <td class="label">Reparación:</td>
            <td>{{ $reparacion->descripcion }}</td>
        </tr>
        <tr>
            <td class="label">Costo Total:</td>
            <td style="font-size: 14px; font-weight: bold;">${{ number_format($reparacion->costo, 2) }}</td>
        </tr>
    </table>
</div>

<p style="text-align: justify; line-height: 1.6;">
    Por medio de la presente, el cliente manifiesta recibir el equipo arriba descrito a su entera satisfacción, habiendo verificado su correcto funcionamiento.
    <br><br>
    Se otorga una garantía de <strong>30 días</strong> sobre la reparación realizada (NO aplica en cambios de display), la cual no cubre daños por humedad, golpes o mal uso posterior a esta fecha.
</p>

<div class="signature">
    <div class="line">Firma de Conformidad del Cliente</div>
    <small>{{ $reparacion->dispositivo->cliente->nombre }} {{ $reparacion->dispositivo->cliente->apellido }}</small>
</div>

<div style="text-align: center; margin-top: 30px; color: #777; font-size: 10px;">
    Gracias por su preferencia - www.soluxmovil.com
</div>

</body>
</html>
