<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
    <title>Inscripción Confirmada</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* --- TUS ESTILOS ORIGINALES (CON MODIFICACIONES) --- */
        :root {
            --primary-color: #1E8449;
            --secondary-color: #2ECC71;
            --dark-gray: #34495E;
            --light-gray: #F4F6F6;
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --info: #3498DB;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
        }

        .main-header {
            background-color: var(--white);
            padding: 1rem 0;
            box-shadow: var(--shadow);
            margin-bottom: 3rem;
        }

        .main-header .container {
            max-width: 1200px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: var(--primary-color);
        }

        .logo img {
            height: 50px;
        }

        .logo-text h1 {
            font-size: 1.5rem;
            margin: 0;
        }

        .logo-text p {
            font-size: 0.9rem;
            margin: 0;
            color: #7f8c8d;
        }

        .confirmation-panel {
            background-color: var(--white);
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .icon-container {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .icon-container.success {
            color: var(--secondary-color);
        }

        .icon-container.info {
            color: var(--info);
        }

        .confirmation-panel h1 {
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 0.5rem;
            font-size: 2.2rem;
        }

        .confirmation-panel .subtitle {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 2.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .action-button {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 0.8rem 2.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            margin-top: 2rem;
            transition: transform 0.2s ease;
        }

        .action-button:hover {
            transform: scale(1.05);
        }

        .main-footer {
            background-color: var(--dark-gray);
            color: var(--white);
            padding: 2rem 0;
            text-align: center;
            margin-top: 3rem;
        }

        /* --- NUEVOS ESTILOS PARA LOS DETALLES DE TRANSACCIÓN --- */
        .transaction-details {
            text-align: left;
            background-color: var(--light-gray);
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .transaction-details h3 {
            margin-top: 0;
            margin-bottom: 1rem;
            color: var(--dark-gray);
            border-bottom: 1px solid #ccc;
            padding-bottom: 0.5rem;
        }

        .details-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .details-list li {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .details-list li:last-child {
            border-bottom: none;
        }

        .details-list .label {
            font-weight: 600;
            color: #555;
        }

        .details-list .value {
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .confirmation-panel {
                padding: 1.5rem;
            }

            .confirmation-panel h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <header class="main-header">
        <div class="container">
            <a href="/" class="logo">
                <img src=""
                    alt="">
                <div class="logo-text">
                    <h1></h1>
                    <p></p>
                </div>
            </a>
        </div>
    </header>
    <main class="container">
        <div class="confirmation-panel">
            @if (session('pagosNiubiz'))
                @php
                    $pagosNiubiz = session('pagosNiubiz');
                @endphp
                <div class="icon-container success">
                    <i class="fa-solid fa-check-circle"></i>
                </div>
                <h1>¡Pago Confirmado!</h1>
                <p class="subtitle">
                    Hola
                    <strong>{{ $pagosNiubiz->inscripcion->tipo_inscripcion == 'minor' ? $pagosNiubiz->inscripcion->ordenApoderado->nombres . ' ' . $pagosNiubiz->inscripcion->ordenApoderado->apellido_paterno : $pagosNiubiz->inscripcion->ordenAlumno->nombres . ' ' . $pagosNiubiz->inscripcion->ordenAlumno->apellido_paterno }}</strong>,
                    tu pago para el taller
                    <strong>"{{ $pagosNiubiz->cronogramasPagos()->first()->concepto }}"</strong> se ha procesado
                    satisfactoriamente.
                </p>
                <p>Hemos enviado una copia de este resumen a tu correo electrónico, junto con las credenciales de acceso
                    a tu portal.
                    Si no lo encuentras en tu bandeja de entrada en los próximos 2 minutos, por favor revisa tu carpeta
                    de Correos No Deseados (Spam)</p>

                <!-- DETALLES DE LA TRANSACCIÓN -->
                <div class="transaction-details">
                    <h3>Detalles de la Transacción</h3>
                    <ul class="details-list">
                        <li><span class="label">Número de Pedido:</span> <span
                                class="value">{{ $pagosNiubiz['num_orden_niubiz'] }}</span></li>
                        <li><span class="label">Fecha y Hora:</span> <span class="value">{{ now()->format('d/m/Y H:i A') }}</span>
                        </li>
                        {{-- <li><span class="label">Número de Liquidación:</span> <span
                                class="value">{{ $pagosNiubiz->inscripcion->numero_liquidacion }}</span></li> --}}
                        <li><span class="label">N° Operación:</span> <span
                                class="value">{{ $pagosNiubiz['id_unico'] }}</span></li>
                        <li><span class="label">N° Token:</span> <span
                                class="value">{{ $pagosNiubiz['tokenId'] }}</span></li>
                        <li><span class="label">Tipo de Tarjeta:</span> <span
                                class="value">{{ mb_strtoupper($pagosNiubiz['brand']) }}</span></li>
                        <li><span class="label">N° Tarjeta:</span> <span
                                class="value">{{ $pagosNiubiz['tarjeta_enmascarada'] }}</span></li>
                        <li><span class="label">Estado:</span> <span class="value"
                                style="color: var(--primary-color);">{{ $pagosNiubiz['estado'] }}</span></li>
                        <li><span class="label">Moneda:</span> <span class="value">(Soles) PEN</span></li>
                        <li><span class="label">Monto Pagado:</span> <span class="value">S/
                                {{ number_format($pagosNiubiz['monto_pagado'], 2) }}</span></li>
                    </ul>
                </div>

                <p>"Por seguridad, le recomendamos <strong>imprimir o tomar una captura de esta pantalla</strong> como
                    comprobante de su operación."</p>
                <p>Al realizar este pago, usted aceptó nuestros
                    <a href="#" target="_blank" style="color: #01AC68;">Términos y Condiciones</a>.
                </p>

                <a href="{{ route('login') }}" class="action-button">Ir al Portal de Acceso</a>
            @elseif(session('infoMessage'))
                {{-- Tu lógica para mensajes de información (lista de espera, etc.) --}}
            @endif
        </div>
    </main>
    <footer class="main-footer">
        <p>&copy; {{ date('Y') }} </p>
    </footer>
</body>

</html>
