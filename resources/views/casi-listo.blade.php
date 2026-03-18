<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
    <title>Confirmación de Pago</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #1E8449;
            --secondary-color: #2ECC71;
            --dark-gray: #34495E;
            --light-gray: #F4F6F6;
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 800px;
            /* Ancho más reducido para centrar el contenido */
            margin: 0 auto;
        }

        /* --- HEADER (COPIA DEL ORIGINAL) --- */
        .main-header {
            background-color: var(--white);
            padding: 1rem 0;
            box-shadow: var(--shadow);
            margin-bottom: 3rem;
            /* Espacio antes del contenido principal */
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

        /* --- CONTENIDO PRINCIPAL --- */
        .confirmation-panel {
            background-color: var(--white);
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: var(--shadow);
            text-align: center;
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
            margin-bottom: 2rem;
        }

        /* Resumen de la Inscripción */
        .summary-box {
            background-color: var(--light-gray);
            border: 1px dashed #ccc;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2.5rem;
            text-align: left;
        }

        .summary-box p {
            margin: 0.5rem 0;
            font-size: 1rem;
        }

        .summary-box strong {
            color: var(--dark-gray);
        }

        /* Pasos a seguir */
        .steps-container {
            text-align: left;
        }

        .step {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .step-number {
            flex-shrink: 0;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: var(--white);
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .step-content h3 {
            margin-top: 0;
            margin-bottom: 0.5rem;
            color: var(--dark-gray);
        }

        .payment-link-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 0.8rem 2.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            margin-top: 0.5rem;
            transition: transform 0.2s ease;
        }

        .payment-link-btn:hover {
            transform: scale(1.05);
        }

        /* Formulario de subida de archivo */
        .upload-form label {
            font-weight: bold;
            display: block;
            margin-bottom: 0.5rem;
        }

        .upload-form input[type="file"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .upload-btn {
            background-color: var(--secondary-color);
            color: var(--dark-gray);
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Footer */
        .main-footer {
            background-color: var(--dark-gray);
            color: var(--white);
            padding: 2rem 0;
            text-align: center;
            margin-top: 3rem;
        }

        /* Contenedor principal para dar orden */
        .pago-container {
            max-width: 500px;
            margin: 20px auto;
            text-align: center;
        }

        /* Contenedor relativo para que el escudo sepa dónde posicionarse */
        .pos-relative {
            position: relative;
            display: inline-block;
            /* Se ajusta al ancho del botón de Niubiz */
            min-width: 200px;
            /* Evita que colapse antes de que cargue el script */
            min-height: 50px;
        }

        /* Estilo del Escudo / Capa de bloqueo */
        #escudoTerminos {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            /* Efecto de desenfoque/opacidad */
            z-index: 999;
            cursor: not-allowed;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px dashed #adb5bd;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        /* Pequeño texto de ayuda dentro del escudo */
        #escudoTerminos span {
            background: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #6c757d;
            font-size: 0.85rem;
            pointer-events: none;
            /* Evita que el texto interfiera con el clic del escudo */
        }

        /* Estilo para la tarjeta de términos (Bootstrap opcional o CSS puro) */
        .card.border-info {

            /* background-color: #f8fdff; */
            border-radius: 8px;
        }

        .form-check-label {
            cursor: pointer;
            font-size: 0.95rem;
            color: #495057;
        }

        /* Estilo para que el enlace a términos destaque */
        .form-check-label a {
            color: #01AC68;
            text-decoration: underline;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .confirmation-panel {
                padding: 1.5rem;
            }

            .confirmation-panel h1 {
                font-size: 1.8rem;
            }

            .step {
                flex-direction: column;
                align-items: center;
                text-align: center;
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
            <h1>¡Ya casi terminamos!</h1>
            <p class="subtitle">Tu solicitud de inscripción ha sido recibida. Sigue los siguientes pasos para
                completarla.</p>

            <div class="summary-box">
                <p><strong>Alumno:</strong>
                    {{ ($inscripcion->tipo_inscripcion == 'minor' ? $inscripcion->ordenApoderado->nombres . ' ' . $inscripcion->ordenApoderado->apellido_paterno : $inscripcion->ordenAlumno->nombres . ' ' . $inscripcion->ordenAlumno->apellido_paterno) ?? '' }}
                    {{ $inscripcion->alumno_apellido_paterno ?? '' }}</p>
                <p><strong>Taller:</strong> {{ $inscripcion->seccion->talleres->disciplina->nombre ?? '' }}
                    ({{ $inscripcion->seccion->nombre ?? '' }}) {{ $inscripcion->seccion->dia_semana }} -
                    {{ $inscripcion->seccion->talleres->frecuencia_vecino }}</p>
                <p><strong>Docente: </strong> {{ $inscripcion->seccion->docentes->user->nombres }}
                    {{ $inscripcion->seccion->docentes->user->apellido_paterno }}</p>
                <p><strong>Monto a Pagar:</strong> <strong style="color: var(--primary-color); font-size: 1.2rem;">S/
                        {{ number_format($monto ?? 0, 2) }}</strong></p>
                <p style="color:red;"><strong>Nota: </strong> Verificar bien el horario antes de pagar.</p>
            </div>

            <div class="steps-container">
                <!-- PASO 1 -->
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Realiza el Pago</h3>
                        <p>Marca el check para aceptar los Terminos y Condiciones y continuar con el pago.</p>

                        {{-- <a href="{{ $enlaceDePago ?? '' }}" target="_blank" class="payment-link-btn">
                            <i class="fa-solid fa-credit-card"></i> Ir a Pagar Ahora
                        </a> --}}
                        {{-- {{dd($inscripcion->toArray());}} --}}


                        <div class="card p-3 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkParaCertificacion"
                                    style="width: 25px; height: 25px;">
                                <label class="form-check-label ms-2" for="checkParaCertificacion">
                                    He leído y acepto los <a href="#">Términos y Condiciones</a>
                                </label>
                            </div>
                            <br>
                        </div>
                        <div id="seccionPagoNiubiz" style="display: none;">
                            <form 
                                action = "{{ route('talleres.procesandoPago', ['monto' => $monto, 'orden' => $inscripcion->numero_orden, 'inscripcionId' => $inscripcion->id]) }}"
                                method='post' id="niubiz-form">


                                @php

                                    $entorno = 'dev';
                                    switch ($entorno) {
                                        case 'dev':
                                            $urljs =
                                                'https://static-content-qas.vnforapps.com/env/sandbox/js/checkout.js';

                                            $merchantId = env('MERCHANT_ID_DEV');
                                            break;
                                        case 'prd':
                                            $urljs = 'https://static-content.vnforapps.com/v2/js/checkout.js';
                                            $merchantId = env('MERCHANT_ID_PROD');

                                            break;
                                    }
                                @endphp


                                @csrf
                                {{-- <input type="hidden" name="acepto_terminos" id="checkOculto" value="1"> --}}

                                <script src="{{ $urljs }}" data-sessiontoken="{{ session('sessionToken') }}"
                                    data-merchantid="{{ $merchantId }}" data-channel="web" data-buttonsize="" data-buttoncolor="#01AC68"
                                    data-merchantlogo="{{ asset('') }}" data-merchantname=""
                                    data-formbuttoncolor="#01AC68" data-showamount="" data-purchasenumber="{{ $inscripcion->numero_orden }}"
                                    data-amount="{{ $monto }}" data-cardholdername="" data-cardholderlastname="" data-cardholderemail=""
                                    data-usertoken="" data-recurrence="" data-frequency="" data-recurrencetype="" data-recurrenceamount=""
                                    data-documenttype="0" data-documentid="" data-beneficiaryid="1112" data-productid="" data-phone=""
                                    data-timeouturl=""></script>




                            </form>
                        </div>
                        @if ($errors->any())
                            <div
                                style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                                <strong>¡Ups! Revisa los siguientes errores:</strong>
                                <ul style="list-style-type: none;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- PASO 2 -->
                        {{-- <div class="step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h3>Envía tu Comprobante</h3>
                                <p>Una vez completado el pago, es <strong>indispensable</strong> que nos envíes el
                                    comprobante
                                    para validar tu vacante.</p> --}}
                        {{-- <form class="upload-form" action="{{ route('comprobante.upload') }}" method="POST"
                            enctype="multipart/form-data"> --}}

                        {{-- <form class="upload-form" action="{{ route('talleres.inscripcion.comprobante') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="pre_inscripcion_id"
                                        value="{{ $inscripcion->id ?? '' }}">
                                    <label for="comprobante">Sube tu comprobante aquí:</label>
                                    <input type="file" id="comprobante" name="comprobante"
                                        accept="image/png, image/jpeg, application/pdf" required>
                                    <button type="submit" class="upload-btn">
                                        <i class="fa-solid fa-upload"></i> Enviar Comprobante
                                    </button>
                                </form>
                                <hr style="margin: 1.5rem 0;">
                                <p style="font-size: 0.9rem; color: #555;">
                                    <strong>Alternativa:</strong> Si tienes problemas, puedes enviar tu comprobante a
                                    <strong></strong> con el asunto "Comprobante -
                                    {{ $inscripcion->alumno_nombres ?? '' }}".
                                </p>
                            </div>
                    </div> --}}
                    </div>
                    {{-- 
                <div
                    style="margin-top: 2rem; background-color: #fffbe6; border: 1px solid #ffe58f; padding: 1rem; border-radius: 8px;">
                    <p><strong>Importante:</strong> Tu vacante no estará 100% confirmada hasta que nuestro equipo valide
                        tu
                        comprobante de pago. Recibirás un correo electrónico de bienvenida una vez que tu matrícula sea
                        activada oficialmente.</p>
                </div> --}}

                </div>
    </main>

    <footer class="main-footer">
        <p>&copy; {{ date('Y') }}</p>
    </footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    </script>
@endif
<script>
    // Supongamos que tu formulario tiene el id "form-pago"
   document.getElementById('niubiz-form').addEventListener('submit', function(e) {

        Swal.fire({
            title: 'Procesando su pago',
            text: 'Estamos verificando las vacantes y autorizando la transacción. Por favor, no cierre ni refresque esta ventana.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading(); // Muestra el círculo de carga animado
            }
        });

        // El formulario sigue su curso normal hacia tu controlador
    });
</script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkVisual = document.getElementById('checkVisual');
        const checkOculto = document.getElementById('checkOculto');
        const formNiubiz = document.getElementById('niubiz-form');
        checkOculto.value = "0";
        formNiubiz.style.opacity = "0.3";
        formNiubiz.style.pointerEvents = "none";

        checkVisual.addEventListener('change', function() {
            if (this.checked) {
                // 1. Sincronizamos el valor para Laravel
                checkOculto.value = "on";

                // 2. Desbloqueamos el botón de Niubiz
                formNiubiz.style.opacity = "1";
                formNiubiz.style.pointerEvents = "auto";
            } else {
                // Bloqueamos todo de nuevo
                checkOculto.value = "";
                formNiubiz.style.opacity = "0.3";
                formNiubiz.style.pointerEvents = "none";
            }
        });
    });
</script> --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkVisual = document.getElementById('checkVisual');
        const inputOculto = document.getElementById('acepto_terminos');
        const elFormulario = document.getElementById('formNiubiz'); // Asegúrate que tu <form> tenga este ID

        checkVisual.addEventListener('change', function() {
            inputOculto.value = this.checked ? "1" : "0";
            console.log("Valor actualizado a: " + inputOculto.value);
        });

        // Seguridad extra: Si el script de Niubiz intenta enviar el form, 
        // nos aseguramos que el valor esté ahí.
        if (elFormulario) {
            elFormulario.addEventListener('submit', function() {
                inputOculto.value = checkVisual.checked ? "1" : "0";
            });
        }
    });
</script> --}}
<script>
    document.getElementById('checkParaCertificacion').addEventListener('change', function() {
        if (this.checked) {
            // CREAR SESIÓN Y MOSTRAR BOTÓN

            fetch("{{ route('terminos.aceptar') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            document.getElementById('seccionPagoNiubiz').style.display = 'block';
            console.log('CON CHECK')
        } else {
            // BORRAR SESIÓN Y OCULTAR BOTÓN

            fetch("{{ route('terminos.borrar') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            document.getElementById('seccionPagoNiubiz').style.display = 'none';
            console.log('SIN CHECK')
        }
    });
</script>


</html>
