<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f5; padding: 20px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background-color: #0d6efd; color: #ffffff; text-align: center; padding: 20px; }
        .content { padding: 30px; line-height: 1.6; }
        .footer { background-color: #e2e8f0; text-align: center; padding: 15px; font-size: 12px; color: #6c757d; }
        .btn { display: inline-block; padding: 10px 20px; margin-top: 20px; background-color: #0d6efd; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>¡Bienvenido a SoluxMovil!</h2>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $nombreCliente }}</strong>,</p>
            <p>Tu cuenta como cliente ha sido registrada exitosamente en nuestro sistema. A partir de ahora, podrás gestionar y dar seguimiento a las reparaciones de tus dispositivos de manera transparente y segura.</p>
            
            <h3 style="color: #0d6efd;">Instrucciones para tu servicio:</h3>
            <ul>
                <li><strong>Ingreso:</strong> Al dejar tu equipo en sucursal, te generaremos un número de <b>Folio</b>.</li>
                <li><strong>Seguimiento:</strong> Ingresa a nuestro portal con tu cuenta para ver en tiempo real si tu equipo está <i>En Revisión</i>, <i>En Reparación</i> o <i>Terminado</i>.</li>
                <li><strong>Entrega:</strong> Para recoger tu dispositivo reparado, es estrictamente necesario presentar una identificación oficial, tu nota de ingreso generada, y tu nota de entrega.</li>
            </ul>

            <p>Si tienes dudas sobre costos, puedes utilizar nuestro asistente virtual en la plataforma.</p>
            
            <center>
                <a href="{{ url('/') }}" class="btn">Ir a mi Panel</a>
            </center>
        </div>
        <div class="footer">
            <p>Av. Benito Juárez #11, San Baltazar Temaxcalac.</p>
            <p>Brokerscell &copy; {{ date('Y') }}. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>