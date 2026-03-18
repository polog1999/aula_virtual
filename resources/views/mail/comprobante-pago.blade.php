<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Comprobante de Pago</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; margin: 0; padding: 0; background-color: #f4f6f6; }
        .container { max-width: 600px; margin: 20px auto; border: 1px solid #eee; border-top: 4px solid #1E8449; background-color: #ffffff; border-radius: 4px; overflow: hidden; }
        .header { padding: 30px; text-align: center; background-color: #f8f9fa; border-bottom: 1px solid #eee; }
        .content { padding: 40px 30px; text-align: center; }
        .icon-box { font-size: 48px; color: #1E8449; margin-bottom: 10px; }
        .title { color: #1E8449; margin: 0 0 20px 0; font-size: 24px; }
        .info-text { font-size: 16px; color: #555; margin-bottom: 20px; }
        .highlight { font-weight: bold; color: #333; }
        
        .footer { padding: 25px; font-size: 12px; color: #777; text-align: center; background-color: #f8f9fa; border-top: 1px solid #eee; }
        .footer a { color: #1E8449; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="" alt="" width="180">
        </div>

        <div class="content">
            <div class="icon-box">📄</div>
            <h2 class="title">Comprobante de Pago Adjunto</h2>
            
            <p class="info-text">
                Hola <span class="highlight">{{ $paymentData['nombre_cliente'] }}</span>,
            </p>
            
            <p class="info-text">
                Adjunto a este correo encontrarás tu comprobante de pago oficial en formato PDF, 
                correspondiente al pedido número <span class="highlight">{{ $paymentData['numero_pedido'] }}</span>.
            </p>
            
            <div style="background-color: #f2f4f6; padding: 15px; border-radius: 8px; display: inline-block; margin-top: 10px;">
                <p style="margin: 0; font-size: 14px; color: #555;">
                    Te recomendamos guardarlo para tus archivos personales.
                </p>
            </div>
        </div>

        <div class="footer">
            <p><strong></strong><br>
            <br>
            <a href=""></a></p>
            <hr style="border: 0; border-top: 1px solid #ddd; margin: 15px 0;">
            <p> &copy; {{ date('Y') }}. Este es un mensaje automático.</p>
        </div>
    </div>
</body>
</html>