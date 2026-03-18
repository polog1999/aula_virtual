<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago</title>
    <style>
        @page {
            size: A6;
            margin: 0.7cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 8.5pt; /* Ligeramente más pequeño para que quepa más contenido */
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #333;
            padding-bottom: 8px; /* Reducido */
        }
        .logo {
            width: 65px; /* Ligeramente más pequeño */
            height: auto;
            margin-bottom: 5px;
        }
        .header h1 {
            margin: 0;
            font-size: 10pt;
        }
        .header p {
            margin: 1px 0 0 0;
            font-size: 7.5pt;
        }
        .section {
            margin-top: 10px; /* Reducido */
        }
        .section-title {
            font-weight: bold;
            font-size: 10pt;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            margin-bottom: 6px; /* Reducido */
        }
        .details-table td {
            padding: 3px 0; /* Reducido */
        }
        .details-table .label {
            font-weight: bold;
            width: 40%;
        }
        .total-table {
            margin-top: 15px;
            width: 100%;
        }
        .total-table td {
            padding: 6px;
            border: 1px solid #333;
        }
        .total-table .total-label {
            font-weight: bold;
        }
        .total-table .total-amount {
            font-weight: bold;
            font-size: 11pt;
            text-align: right;
        }
        
        /* =============================================== */
        /* --- CLASE CLAVE PARA EVITAR CORTES DE PÁGINA --- */
        /* =============================================== */
        /* .no-break {
            page-break-inside: avoid;
        } */
        /* =============================================== */

        .footer {
            text-align: center;
            font-size: 7pt;
            color: #777;
            margin-top: 20px; /* Espacio antes del footer */
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- ENCABEZADO -->
        <div class="header">
            <img src="{{ public_path('') }}" alt="Logo" class="logo">
            <h1>COMPROBANTE DE PAGO</h1>
            <p></p>
            <p>CURSOS</p>
        </div>

        <!-- DETALLES DE LA TRANSACCIÓN (Resumen) -->
        <div class="section">
            <table class="details-table">
                <tr>
                    <td class="label">N° PEDIDO:</td>
                    <td>{{ $paymentData['numero_pedido'] }}</td>
                </tr>
                <tr>
                    <td class="label">N° LIQUIDACIÓN:</td>
                    <td>{{ $paymentData['numero_liquidacion'] }}</td>
                </tr>
                <tr>
                    <td class="label">N° OPERACIÓN:</td>
                    <td>{{ $paymentData['numero_operacion'] }}</td>
                </tr>
                <tr>
                    <td class="label">FECHA Y HORA:</td>
                    <td>{{ $paymentData['fecha_pedido'] }}</td>
                </tr>
            </table>
        </div>

        <!-- DATOS DEL CLIENTE -->
        <div class="section">
            <p class="section-title">PAGADO POR</p>
            <table class="details-table">
                <tr>
                    <td class="label">NOMBRE:</td>
                    <td>{{ mb_strtoupper($paymentData['nombre_cliente']) }}</td>
                </tr>
                <tr>
                    <td class="label">DNI:</td>
                    <td>{{ $paymentData['dni_cliente'] }}</td>
                </tr><tr>
                <td class="label">N° CONTRIBUYENTE:</td>
                    <td>{{ $paymentData['numero_contribuyente'] }}</td>
                </tr>
            </table>
        </div>

        <!-- DETALLE DEL SERVICIO -->
        <div class="section">
            <p class="section-title">DETALLE</p>
            <table class="details-table">
                <tr>
                    <td class="label">CONCEPTO:</td>
                    <td>{{ mb_strtoupper($paymentData['concepto']) }}</td>
                </tr>
                {{-- <tr>
                    <td class="label">Grupo - Código :</td>
                    <td>{{ mb_strtoupper($paymentData['grupo_codigo']) }}</td>
                </tr> --}}
                <tr>
                    <td class="label">ALUMNO:</td>
                    <td>{{ mb_strtoupper($paymentData['nombre_alumno']) }}</td>
                </tr>
                <tr>
                    <td class="label">TIPO DE TARJETA:</td>
                    <td>{{ mb_strtoupper($paymentData['tipo_tarjeta']) }} ({{ $paymentData['numero_tarjeta'] }})</td>
                </tr>
                <tr>
                    <td class="label">N° TOKEN:</td>
                    <td>{{ mb_strtoupper($paymentData['numero_token']) ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <!-- TOTALES -->
        <table class="total-table ">
            <tr>
                <td class="total-label">TOTAL PAGADO</td>
                <td class="total-amount">S/ {{ number_format($paymentData['monto_pagado'], 2) }}</td>
            </tr>
        </table>

        <!-- PIE DE PÁGINA -->
        {{-- <div class="footer">
            <p>¡Gracias por tu pago!</p>
        </div> --}}
    </div>
</body>

</html>
