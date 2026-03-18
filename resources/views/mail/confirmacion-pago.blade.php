<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pago</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f6f6;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            border: 1px solid #eee;
            border-top: 4px solid #1E8449;
            background-color: #ffffff;
            border-radius: 4px;
            overflow: hidden;
        }

        .header {
            padding: 30px;
            text-align: center;
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
        }

        .content {
            padding: 40px 30px;
        }

        .status-icon {
            font-size: 48px;
            color: #2ECC71;
            margin-bottom: 10px;
        }

        .title {
            color: #1E8449;
            margin: 0 0 20px 0;
            font-size: 24px;
            text-align: center;
        }

        /* Tabla de detalles estilo caja de código */
        .details-box {
            background-color: #f2f4f6;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            border: 1px solid #e1e4e8;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .details-table td {
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .details-table td:last-child {
            text-align: right;
            font-weight: bold;
        }

        .details-table tr:last-child td {
            border-bottom: none;
        }

        .monto-total {
            color: #1E8449;
            font-size: 18px;
        }

        /* Sección de credenciales */
        .credentials-box {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            border: 1px dashed #1E8449;
        }

        .btn-portal {
            display: inline-block;
            background-color: #1E8449;
            color: #ffffff !important;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 15px;
        }

        .footer {
            padding: 25px;
            font-size: 12px;
            color: #777;
            text-align: center;
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
        }

        .footer a {
            color: #1E8449;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src=""
                alt="" width="180">
        </div>

        <div class="content">
            <div style="text-align: center;">
                <div class="status-icon">✔</div>
                <h2 class="title">¡Pago Confirmado!</h2>
                <p style="font-size: 16px;">
                    Hola
                    <strong>{{ $pagoNiubiz->inscripcion->tipo_inscripcion == 'minor' ? $pagoNiubiz->inscripcion->ordenApoderado->nombres.' '.$pagoNiubiz->inscripcion->ordenApoderado->apellido_paterno : $pagoNiubiz->inscripcion->ordenAlumno->nombres.' '.$pagoNiubiz->inscripcion->ordenAlumno->apellido_paterno }}</strong>,
                    tu pago para el taller <strong>"{{ $pagoNiubiz->cronogramasPagos()->first()->concepto }}"</strong>
                    se ha procesado satisfactoriamente.
                </p>
            </div>

            <div class="details-box">
                <h3
                    style="margin-top: 0; font-size: 16px; color: #34495E; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                    Resumen de la Transacción</h3>
                <table class="details-table">
                    <tr>
                        <td>Número de Pedido</td>
                        <td>{{ $pagoNiubiz['num_orden_niubiz'] }}</td>
                    </tr>
                    <tr>
                        <td>Fecha y Hora</td>
                        <td>{{ now()->format('d/m/Y H:i A') }}</td>
                    </tr>
                    {{-- <tr>
                        <td>N° Liquidación</td>
                        <td>{{ $pagoNiubiz->inscripcion->numero_liquidacion }}</td>
                    </tr> --}}
                    <tr>
                        <td>N° Operación</td>
                        <td>{{ $pagoNiubiz['id_unico'] }}</td>
                    </tr>

                    <tr>
                        <td>N° Token:</td>
                        <td>{{ $pagoNiubiz['tokenId'] }}</td>
                    </tr>
                    
                    <tr>
                        <td>Tarjeta</td>
                        <td>{{ mb_strtoupper($pagoNiubiz['brand']) }} ({{ $pagoNiubiz['tarjeta_enmascarada'] }})</td>
                    </tr>
                    <tr>
                        <td>Estado</td>
                        <td style="color: #1E8449;">{{ $pagoNiubiz['estado'] }}</td>
                    </tr>
                    <tr>
                        <td>Moneda</td>
                        <td>(Soles) PEN</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; padding-top: 15px;">Monto Total</td>
                        <td class="monto-total" style="padding-top: 15px;">S/
                            {{ number_format($pagoNiubiz['monto_pagado'], 2) }}</td>
                    </tr>
                </table>
            </div>
            <p>"Por seguridad, le recomendamos <strong>imprimir o tomar una captura de esta pantalla</strong> como
                comprobante de su operación."</p>
            <p>Al realizar este pago, usted aceptó nuestros
                <a href="#" target="_blank" style="color: #01AC68;">Términos y Condiciones</a>.
            </p>

            @if (isset($credentials))
                <div class="credentials-box">
                    <h3 style="color: #1E8449; margin-top: 0;">Acceso a tu Portal</h3>
                    <p style="font-size: 14px; margin-bottom: 10px;">Hemos creado una cuenta para ti. Usa estas
                        credenciales para gestionar tus inscripciones:</p>
                    <p style="margin: 5px 0; font-size: 14px;"><strong>Usuario:</strong> {{ $credentials['email'] }}
                    </p>
                    <p style="margin: 5px 0; font-size: 14px;"><strong>Contraseña Temporal:</strong>
                        {{ $credentials['password'] }}</p>

                    <div style="text-align: center;">
                        <a href="{{ route('login') }}" class="btn-portal">Ir al Portal de Acceso</a>
                    </div>
                </div>
            @endif
        </div>

        <div class="footer">
            <p><strong></strong><br>
              <br>
                <a href=""></a>
            </p>
            <hr style="border: 0; border-top: 1px solid #ddd; margin: 15px 0;">
            <p> &copy; {{ date('Y') }}. Este es un mensaje automático.</p>
        </div>
    </div>
</body>

</html>
