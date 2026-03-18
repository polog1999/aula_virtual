<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; border: 1px solid #eee; border-top: 4px solid #1E8449; }
        .header { padding: 20px; text-align: center; background-color: #f8f9fa; }
        .content { padding: 30px; text-align: center; }
        .code-box { background-color: #f2f4f6; border-radius: 8px; padding: 20px; margin: 20px 0; font-size: 24px; font-weight: bold; letter-spacing: 5px; color: #1E8449; border: 1px dashed #1E8449; }
        .footer { padding: 20px; font-size: 12px; color: #777; text-align: center; background-color: #f8f9fa; }
        .footer a { color: #1E8449; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="" alt="" width="180">
        </div>
        <div class="content">
            <h2>Verifica tu identidad</h2>
            <p>Hola,</p>
            <p>Has solicitado un código de verificación para inscribirte en los <strong></strong>.</p>
            <div class="code-box">
                {{$code}}
            </div>
            <p>Este código expirará en 15 minutos. Si no solicitaste este correo, puedes ignorarlo con seguridad.</p>
        </div>
        <div class="footer">
            <p><strong></strong><br>
          <br>
            <a href=""></a></p>
            <hr style="border: 0; border-top: 1px solid #ddd; margin: 15px 0;">
            <p>Este es un mensaje automático, por favor no respondas a este correo.</p>
        </div>
    </div>
</body>
</html>