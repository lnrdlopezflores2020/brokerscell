<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Seguridad</title>
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
        
        /* Efecto hover para el enlace (solo en clientes que lo soporten) */
        .footer-link:hover { color: #0d6efd !important; text-decoration: none !important; }
    </style>
</head>
<body style="background-color: #f4f7f6; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; margin: 0; padding: 0;">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" style="padding: 50px 15px;">

            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.08);">
                
                <tr>
                    <td align="center" bgcolor="#1a1e23" style="padding: 35px 20px;">
                        {{-- 
                            USO CORRECTO DEL LOGO EN LARAVEL
                            $message->embed() adjunta la imagen al correo para que nunca aparezca rota.
                            Asegúrate de que la ruta public_path sea la correcta en tu proyecto.
                        --}}
                        <img src="{{ $message->embed(public_path('assets/images/SOLUXMOVIL.png')) }}" alt="SoluxMovil" style="display: block; width: 180px; max-width: 100%;">
                    </td>
                </tr>

                <tr>
                    <td style="padding: 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #2b303a; font-size: 22px; font-weight: 700; text-align: center; padding-bottom: 15px;">
                                    Autenticación requerida
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #555555; font-size: 15px; line-height: 24px; text-align: center; padding-bottom: 30px;">
                                    Hola,<br>
                                    Para proteger tu cuenta en <strong>BrokersCell</strong>, necesitamos confirmar tu identidad. Ingresa el siguiente código de 6 dígitos en el sistema:
                                </td>
                            </tr>

                            <tr>
                                <td align="center" style="padding-bottom: 35px;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="background-color: #f0f7ff; border-radius: 10px; border: 1px solid #cce3ff;">
                                        <tr>
                                            <td align="center" style="padding: 20px 40px;">
                                                <span style="font-size: 34px; font-weight: 800; color: #0056b3; letter-spacing: 8px; font-family: monospace;">
                                                    {{ $codigo }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="color: #888888; font-size: 13px; text-align: center; line-height: 20px; border-top: 1px solid #eeeeee; padding-top: 25px;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/3064/3064155.png" width="16" style="vertical-align: middle; margin-right: 5px; opacity: 0.6;" alt="Seguridad">
                                    Este código es confidencial y expirará en <strong>10 minutos</strong>. Nunca te pediremos este código por teléfono o WhatsApp.
                                    <br><br>
                                    ¿No intentaste iniciar sesión? <br>Te recomendamos contactar al administrador inmediatamente.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;">
                <tr>
                    <td align="center" style="padding-top: 25px; color: #9a9ea6; font-size: 12px; line-height: 18px;">
                        <p style="margin: 0;">&copy; {{ date('Y') }} SoluxMovil. Todos los derechos reservados.</p>
                        <p style="margin: 8px 0 0 0;">
                            <a href="#" class="footer-link" style="color: #9a9ea6; text-decoration: underline;">Centro de Soporte</a> |
                            <a href="#" class="footer-link" style="color: #9a9ea6; text-decoration: underline;">Aviso de Privacidad</a>
                        </p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>

</body>
</html>