<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
    <title>Pago Rechazado</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #1E8449;
            --secondary-color: #2ECC71;
            --dark-gray: #34495E;
            --light-gray: #F4F6F6;
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --danger: #E74C3C;
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
        .logo img { height: 50px; }
        .logo-text h1 { font-size: 1.5rem; margin: 0; }
        .logo-text p { font-size: 0.9rem; margin: 0; color: #7f8c8d; }
        .confirmation-panel {
            background-color: var(--white);
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: var(--shadow);
            text-align: center;
            border-top: 5px solid var(--danger); /* Borde superior rojo */
        }
        .icon-container {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: var(--danger); /* Ícono en color de peligro */
        }
        .confirmation-panel h1 {
            color: var(--danger); /* Título en color de peligro */
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
            margin-top: 1rem;
            transition: transform 0.2s ease;
        }
        .action-button:hover { transform: scale(1.05); }
        .secondary-link {
            display: block;
            margin-top: 1.5rem;
            color: var(--dark-gray);
            font-size: 0.9rem;
            text-decoration: none;
        }
        .secondary-link:hover { text-decoration: underline; }

        /* Estilos para la tabla de detalles del error */
        .transaction-details {
            text-align: left;
            background-color: var(--light-gray);
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .details-list { list-style: none; padding: 0; margin: 0; }
        .details-list li {
            display: flex;
            justify-content: space-between;
            padding: 0.6rem 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .details-list li:last-child { border-bottom: none; }
        .details-list .label { font-weight: 600; color: #555; }
        .details-list .value { font-weight: bold; }
        .details-list .value.error-description { color: var(--danger); }

        .main-footer {
            background-color: var(--dark-gray);
            color: var(--white);
            padding: 2rem 0;
            text-align: center;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .confirmation-panel { padding: 1.5rem; }
            .confirmation-panel h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <a href="/" class="logo">
                <img src="" alt="Logo">
                <div class="logo-text">
                    <h1></h1>
                    <p></p>
                </div>
            </a>
        </div>
    </header>
    <main class="container">
        <div class="confirmation-panel">
            <div class="icon-container">
                <i class="fa-solid fa-times-circle"></i>
            </div>
            <h1>Pago Rechazado</h1>
            <p class="subtitle">
                Lo sentimos, tu pago no pudo ser procesado. <strong>No se ha realizado ningún cargo a tu tarjeta.</strong>
            </p>

            <div class="transaction-details">
                <ul class="details-list">
                    <li><span class="label">Número de Pedido:</span> <span class="value">{{ $paymentData['numero_pedido'] ?? 'No disponible' }}</span></li>
                    <li><span class="label">Fecha y Hora:</span> <span class="value">{{ now()->format('d/m/Y H:i A') }}</span></li>
                    <li>
                        <span class="label">Motivo del Rechazo:</span> 
                        <span class="value error-description">{{ $paymentData['descripcion_denegacion'] ?? 'La transacción fue denegada por el banco emisor.' }}</span>
                    </li>
                </ul>
            </div>

            <p>Puedes volver a intentarlo. Por favor, verifica los datos de tu tarjeta antes de continuar.</p>
            
            {{-- Este enlace debería llevar de vuelta a la página de pago para esa pre-inscripción --}}
            <a href="{{ route('talleres.casi-listo', ['token' => $paymentData['token_inscripcion']]) }}" class="action-button">
                <i class="fa-solid fa-redo"></i> Intentar Pagar de Nuevo
            </a>

            <a href="{{ route('index') }}" class="secondary-link">O elegir otro taller</a>
        </div>
    </main>
    <footer class="main-footer">
        <p>&copy; {{ date('Y') }} </p>
    </footer>
</body>
</html>