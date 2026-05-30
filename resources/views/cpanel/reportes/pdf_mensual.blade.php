<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 12px; }
        
        .header { width: 100%; display: table; margin-bottom: 20px; }
        .header-logo { width: 30%; display: table-cell; vertical-align: middle; }
        .header-info { width: 70%; display: table-cell; text-align: right; vertical-align: middle; }
        
        .logo { max-width: 150px; height: auto; }
        
        /* Modificado al morado de Brokerscell */
        .title-box { background: #6f42c1; color: white; padding: 10px; text-align: center; border-radius: 5px; margin-bottom: 20px; font-weight: bold; letter-spacing: 1px;}
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        /* Bordes y texto en morado */
        th { background-color: #f8f9fa; color: #6f42c1; padding: 12px; text-align: left; border-bottom: 2px solid #6f42c1; text-transform: uppercase; font-size: 11px; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        tr:nth-child(even) { background-color: #fcfcfc; }
        
        /* Caja de totales con fondo morado muy claro */
        .total-box { margin-top: 25px; padding: 15px; background: #f4f0fa; border-left: 5px solid #6f42c1; text-align: right; }
        .total-amount { font-size: 20px; font-weight: bold; color: #6f42c1; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-logo">
            {{-- Ruta actualizada al logo de Brokerscell --}}
            <img src="{{ public_path('assets/images/brokerscell.jpeg') }}" class="logo" alt="Logo Brokerscell">
        </div>
        <div class="header-info">
            <h2 style="margin:0; color: #6f42c1;">Brokerscell</h2>
            <p style="margin:2px 0; color: #555;">Taller de Reparación Especializado</p>
            <p style="margin:2px 0;"><strong>Periodo:</strong> {{ $mes }}/{{ $anio }}</p>
        </div>
    </div>

    <div class="title-box">
        REPORTE MENSUAL DE REPARACIONES
    </div>

    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse($reparaciones as $rep)
                <tr>
                    <td style="font-weight:bold; color: #444;">#{{ str_pad($rep->ID_rep, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $rep->descripcion }}</td>
                    <td><span style="padding: 3px 8px; border-radius: 10px; background: #eee; font-size: 10px;">{{ $rep->est_reparacion }}</span></td>
                    <td style="text-align: right;">${{ number_format($rep->costo, 2) }}</td>
                </tr>
                @php $total += $rep->costo; @endphp
            @empty
                <tr><td colspan="4" style="text-align:center; padding: 20px; color: #777;">No hay reparaciones en este periodo.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-box">
        Total Recaudado en el Periodo: <span class="total-amount">${{ number_format($total, 2) }}</span>
    </div>

    <div class="footer">
        Este documento es un reporte generado automáticamente por Brokerscell | Fecha de impresión: {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>