<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Página en Mantenimiento - </title> --}}
    <title>@yield('title', 'Ocurrió un error')</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f6f6; /* Fondo gris claro */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Ocupa toda la altura de la ventana */
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #1E8449; /* Borde superior verde */
        }
        .container {
            max-width: 100%;
            width: 50%;
            padding: 80px;
            background-color: #ffffff;
            border-radius: 12px;
            
        }
        .logo {
            margin-bottom: 25px;
        }
        .logo img {
            
            max-width: 180px; /* Tamaño del logo */
            height: auto;
        }
        .illustration {
            margin: 30px 0;
            display: flex;
            justify-content: center;
        }
        .illustration img {
            
            min-width: 250px;
            width: 50%; /* Tamaño de la imagen ilustrativa */
            height: auto;
            opacity: 0.85; /* Un poco de transparencia */
        }
        h1 {
            color: #1E8449; /* Título en verde institucional */
            font-size: 32px;
            margin-bottom: 15px;
        }
        p {
            font-size: 17px;
            margin-bottom: 20px;
        }
        .contact-info {
            font-size: 14px;
            color: #666666;
            margin-top: 30px;
            border-top: 1px solid #eeeeee;
            padding-top: 20px;
        }
        .contact-info a {
            color: #1E8449;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="" alt="">
        </div>

        <div class="illustration">
            <img src="@yield('img')" alt="Enchufe desconectado">
            </div>

        <h1>@yield('code')</h1>
        <h2></h2>
        <p>
            @yield('message')
            
        </p>
        

        <div class="contact-info">
            {{-- <p>
                Si tienes alguna pregunta urgente, contáctanos:<br>
                <a href=""></a> | <a href="tel:+5112345678">(01) 234-5678</a>
            </p> --}}
            <p>&copy; {{ date('Y') }} . Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>