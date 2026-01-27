<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Verificación</title>
    <style>
        /* Reseteo básico para clientes de correo */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
    </style>
</head>
<body style="background-color: #f4f6f9; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" style="padding: 40px 10px;">

            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

                <tr>
                    <td align="center" style="padding-bottom: 30px;">
                        <img src="{{ public_path('assets/images/SOLUX.png') }}" alt="Logo Empresa" style="display: block; width: 200px; max-width: 100%; min-width: 100px;">
                    </td>
                </tr>

                <tr>
                    <td bgcolor="#ffffff" style="padding: 40px 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #333333; font-size: 24px; font-weight: bold; text-align: center; padding-bottom: 20px;">
                                    Código de Verificación
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #666666; font-size: 16px; line-height: 24px; text-align: center; padding-bottom: 30px;">
                                    Hola, hemos recibido una solicitud para acceder a tu cuenta. <br>
                                    Usa el siguiente código para completar el inicio de sesión:
                                </td>
                            </tr>

                            <tr>
                                <td align="center" style="padding-bottom: 30px;">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" bgcolor="#f8f9fa" style="border-radius: 8px; border: 2px dashed #0d6efd; padding: 15px 35px;">
                                                    <span style="font-size: 32px; font-weight: bold; color: #0d6efd; letter-spacing: 5px; font-family: 'Courier New', Courier, monospace;">
                                                        {{ $codigo }}
                                                    </span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="color: #999999; font-size: 14px; text-align: center; line-height: 20px;">
                                    Este código expirará en <strong>10 minutos</strong>.<br>
                                    Si no fuiste tú quien solicitó este acceso, puedes ignorar este correo de forma segura.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="padding-top: 30px; color: #999999; font-size: 12px;">
                        <p style="margin: 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
                        <p style="margin: 5px 0 0 0;">
                            <a href="#" style="color: #999999; text-decoration: underline;">Política de Privacidad</a> |
                            <a href="#" style="color: #999999; text-decoration: underline;">Soporte</a>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
