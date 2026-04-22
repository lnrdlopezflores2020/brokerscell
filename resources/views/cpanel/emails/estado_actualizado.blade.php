<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #1e293b; padding: 20px; text-align: center; color: white; }
        .content { padding: 30px; text-align: center; }
        .estado-box { background-color: #f8f9fa; border: 2px dashed #0d6efd; border-radius: 8px; padding: 15px; margin: 20px 0; font-size: 24px; font-weight: bold; color: #0d6efd; }
        .footer { background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; }
        .datos { text-align: left; background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Actualización de Servicio</h2>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $reparacion->dispositivo->cliente->nombre }}</strong>,</p>
            <p>Te informamos que tu equipo ha cambiado de estado en nuestro taller.</p>
            
            <div class="estado-box">
                {{ strtoupper($reparacion->est_reparacion) }}
            </div>

            <div class="datos">
                <p><strong>Folio:</strong> #{{ str_pad($reparacion->ID_rep, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Equipo:</strong> {{ $reparacion->dispositivo->marca }} {{ $reparacion->dispositivo->modelo }}</p>
                <p><strong>Costo Total:</strong> ${{ number_format($reparacion->costo, 2) }}</p>
            </div>
            
            <p style="margin-top: 20px; font-size: 14px; color: #666;">
                Puedes revisar más detalles ingresando a tu panel de cliente en nuestro sistema.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} SoluxMovil. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>