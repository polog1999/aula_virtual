<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
</head>

<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #F4F6F6; color: #34495E;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F4F6F6;">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="600"
                    style="border-collapse: collapse; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px;">

                    <tr>
                        <td align="center"
                            style="padding: 30px 0; background-color: #1E8449; border-radius: 8px 8px 0 0;">
                            <img src=""
                                alt="Logo" width="60"
                                style="display: block; margin-bottom: 10px; border: 0;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: bold; letter-spacing: 1px;text-align:center;">
                                CURSOS
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 40px 40px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <h2 style="color: #1E8449; margin: 0 0 20px 0; font-size: 24px;">
                                            Restablece tu Contraseña
                                        </h2>
                                        <p style="font-size: 16px; line-height: 1.5; color: #555555; margin-bottom: 25px;">
                                            Hola. Recibimos una solicitud para restablecer la contraseña de acceso a tu cuenta en nuestro sistema.
                                        </p>
                                        <p style="font-size: 15px; line-height: 1.5; color: #555555;">
                                            Haz clic en el botón de abajo para continuar con el proceso. Ten en cuenta que este enlace expirará en <strong>60 minutos</strong> por razones de seguridad.
                                        </p>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td align="center" style="padding: 30px 0;">
                                        <a href="{{ $actionUrl }}" target="_blank" 
                                           style="background-color: #1E8449; color: #ffffff; padding: 14px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; display: inline-block;">
                                            Restablecer Contraseña ahora
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" style="font-size: 14px; line-height: 1.5; color: #7f8c8d; padding-top: 10px;">
                                        Si no solicitaste este cambio, puedes ignorar este correo de forma segura. Tu cuenta no sufrirá ningún cambio.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px 40px; border-top: 1px solid #eeeeee; background-color: #fafafa;">
                            <p style="margin: 0; font-size: 12px; color: #999999; text-align: center;">
                                Si tienes problemas con el botón, copia y pega la siguiente URL en tu navegador:
                            </p>
                            <p style="margin: 10px 0 0 0; font-size: 11px; color: #1E8449; text-align: center; word-break: break-all;">
                                <a href="{{ $actionUrl }}" style="color: #1E8449; text-decoration: none;">{{ $actionUrl }}</a>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center"
                            style="padding: 20px; font-size: 11px; color: #ffffff; background-color: #34495E; border-radius: 0 0 8px 8px;">
                            <p style="margin: 0;text-align:center;">&copy; {{ date('Y') }}  Todos los derechos reservados.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>