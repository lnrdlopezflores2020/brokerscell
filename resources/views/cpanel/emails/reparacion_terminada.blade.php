<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #198754; padding: 20px; text-align: center; color: white; } /* Verde éxito */
        .content { padding: 30px; text-align: center; color: #333; }
        .estado-box { background-color: #f8f9fa; border: 2px dashed #198754; border-radius: 8px; padding: 15px; margin: 20px 0; font-size: 24px; font-weight: bold; color: #198754; }
        .footer { background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; }
        .datos { text-align: left; background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 20px; }
        .btn-nota { display: inline-block; background-color: #1e293b; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; margin-top: 15px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>¡Tu equipo está listo!</h2>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $reparacion->dispositivo->cliente->nombre }}</strong>,</p>
            <p>Nos alegra informarte que hemos terminado de reparar tu dispositivo. Ya puedes pasar a nuestras instalaciones para recogerlo.</p>
            
            <div class="estado-box">
                REPARACIÓN TERMINADA
            </div>

            <div class="datos">
                <p><strong>Folio:</strong> #{{ str_pad($reparacion->ID_rep, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Equipo:</strong> {{ $reparacion->dispositivo->marca }} {{ $reparacion->dispositivo->modelo }}</p>
                <p><strong>Total a pagar:</strong> ${{ number_format($reparacion->costo, 2) }}</p>
            </div>
            
            <p style="margin-top: 20px; font-size: 14px; color: #666;">
                Por favor, recuerda traer tu <strong>Nota de Entrega</strong> o enviarla a nuestro WhatsApp para agilizar la entrega.
            </p>
            <a href="{{ route('cliente.nota_entrega', $reparacion->ID_rep) }}" class="btn-nota" target="_blank">Descargar Nota de Entrega</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} SoluxMovil. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>