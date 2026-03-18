<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Iniciar Sesión</title>
    <style>
        :root {
            --primary-color: #1E8449;
            --secondary-color: #2ECC71;
            --dark-gray: #34495E;
            --light-gray: #ECF0F1;
            --white: #ffffff;
            --danger: #E74C3C;
            --medium-gray: #bdc3c7;
        }

        /* --- Estilos Base --- */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            /* background-color: var(--light-gray); */
            background: url("{{ asset('/storage/login/fondo_inicio.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            backdrop-filter: blur(7px);
            color: var(--dark-gray);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
            box-sizing: border-box;
        }

        /* --- Contenedor del Login --- */
        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: var(--white);
            padding: 2.5rem 2rem;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- Encabezado del Formulario --- */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header img {
            width: 80px;
            /* Ajusta el tamaño del logo como necesites */
            margin-bottom: 1rem;
        }

        .login-header h1 {
            color: var(--primary-color);
            margin: 0 0 0.5rem 0;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .login-header p {
            margin: 0;
            color: #7f8c8d;
        }

        /* --- Grupos de Formulario --- */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            font-size: 0.9rem;
        }

        /* Contenedor para el ícono y el input */
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 15px;
            color: var(--medium-gray);
            /* El centrado vertical se hereda del flexbox en .input-wrapper */
        }

        .input-wrapper input {
            width: 100%;
            padding: 0.8rem 0.8rem 0.8rem 2.5rem;
            /* Espacio a la izquierda para el ícono */
            border: 1px solid var(--medium-gray);
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 132, 73, 0.2);
        }

        /* --- Botón de Envío --- */
        .btn {
            width: 100%;
            padding: 0.8rem 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: #145A32;
            /* Un tono más oscuro de verde */
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        /* --- Pie de página del formulario --- */
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-header">
            <img src=""
                alt="Logo">
            <h1>Aula virual</h1>
            <p>Bienvenido, por favor inicie sesión.</p>
        </div>
        @if (session('status'))
            <div
                style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                {{-- En español esto dirá: "Su contraseña ha sido restablecida." --}}
                {{ session('status') }}
            </div>
        @endif
        <form id="loginForm" action="{{ route('login') }}" method="POST">
            <!-- CSRF Token si es necesario, ej: <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
            @csrf
            <div class="form-group">
                <label for="username">Email</label>
                <div class="input-wrapper">
                    <span class="input-icon">👤</span>
                    <input type="text" id="username" name="email" placeholder="Ingrese su email" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>
            </div>
            @if ($errors->any())
                <div
                    style="background: #fee2e2; color: #b91c1c; padding: 7px; border-radius: 3px; margin-bottom: 20px; border:2px solid #dda0a0">
                    <ul style="list-style-type: none; padding:0;margin:0;">
                        @foreach ($errors->all() as $error)
                            <li style="font-size: 15px">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Ingresar al Portal</button>
        </form>
        <div class="login-footer">
            <a href="{{ route('index') }}"><i class="fa-solid fa-arrow-left"></i> Volver a Cursos</a>
        </div>
        <div class="login-footer">
            <a href="{{ route('password.request') }}">¿Olvidó su contraseña?</a>
        </div>
    </div>

</body>

</html>
