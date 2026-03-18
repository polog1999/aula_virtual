<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
            box-sizing: border-box;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            /* Un poco más ancho para más campos */
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

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header img {
            width: 80px;
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 15px;
            color: var(--medium-gray);
        }

        .input-wrapper input {
            width: 100%;
            padding: 0.8rem 0.8rem 0.8rem 2.5rem;
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

        .input-wrapper input[readonly] {
            background-color: #f0f0f0;
            cursor: not-allowed;
        }

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
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

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

        /* Estilo para mensajes de error */
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 0.8rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 1.2rem;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-header">
            <img src="
                alt="Logo ">
            <h1>Restablecer Contraseña</h1>
            <p>Por favor, ingresa email</p>
        </div>

        {{-- Mostrar errores de validación si existen --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('status'))
            <div
                style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                {{ session('status') }}
            </div>
        @endif

        <form id="resetPasswordForm" action="{{ route('password.email') }}" method="POST">
            @csrf

            {{-- Campo oculto para el token de reseteo, Laravel lo necesita --}}
            {{-- <input type="hidden" name="token" value="{{ $request->route('token') }}"> --}}

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fa-solid fa-at"></i></span>
                    {{-- El email viene de la URL y no debe ser editable --}}
                    <input type="email" id="email" name="email" value="" placeholder="Ingrese su email"
                        required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <div class="login-footer">
            <a href="{{ route('login') }}">
                <i class="fa-solid fa-arrow-left"></i> Volver a Iniciar Sesión
            </a>
        </div>
    </div>

</body>

</html>
