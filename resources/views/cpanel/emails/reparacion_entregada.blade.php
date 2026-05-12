<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #1e293b; padding: 20px; text-align: center; color: white; } /* Azul oscuro corporativo */
        .content { padding: 30px; text-align: center; color: #333; }
        .estado-box { background-color: #f8f9fa; border: 2px solid #1e293b; border-radius: 8px; padding: 15px; margin: 20px 0; font-size: 24px; font-weight: bold; color: #1e293b; }
        .footer { background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; }
        .garantia { text-align: left; background: #e0e7ff; padding: 15px; border-radius: 8px; margin-top: 20px; font-size: 13px; color: #3730a3; border-left: 4px solid #4f46e5; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>¡Gracias por tu preferencia!</h2>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $reparacion->dispositivo->cliente->nombre }}</strong>,</p>
            <p>Este correo es para confirmar que hemos entregado tu dispositivo exitosamente. Esperamos que el servicio haya sido de tu total agrado.</p>
            
            <div class="estado-box">
                EQUIPO ENTREGADO
            </div>

            <p><strong>Folio del servicio:</strong> #{{ str_pad($reparacion->ID_rep, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Dispositivo:</strong> {{ $reparacion->dispositivo->marca }} {{ $reparacion->dispositivo->modelo }}</p>

            <div class="garantia">
                <strong>Recordatorio de Garantía:</strong><br>
                Cuentas con 30 días naturales de garantía sobre la reparación realizada. Te recordamos que esta garantía no cubre daños por humedad, golpes o mal uso posterior a la fecha de hoy.
            </div>
            
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} SoluxMovil. San Baltazar Temaxcalac.<br>
            Si tienes alguna duda, contáctanos al (248) 266-0871.
        </div>
    </div>
</body>
</html>