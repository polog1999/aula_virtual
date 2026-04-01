<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Rol</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #2596be; /* TU NUEVO COLOR AZUL */
            --primary-color-dark: #1e7a9c;
            --dark-gray: #34495E;
            --light-gray: #f0f4f7; /* Un gris azulado más suave */
            --white: #ffffff;
            --shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
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

        .role-selection-container {
            width: 100%;
            max-width: 800px;
            background-color: var(--white);
            padding: 3rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            animation: fadeIn 0.6s ease-out;
            text-align: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header-logo {
            width: 70px;
            margin-bottom: 1rem;
        }

        .welcome-title {
            margin: 0 0 0.5rem 0;
            font-size: 2rem;
            font-weight: 600;
        }

        .welcome-subtitle {
            margin: 0 auto 2.5rem auto;
            color: #7f8c8d;
            font-size: 1.1rem;
            max-width: 500px;
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .role-card {
            display: block;
            background-color: var(--white);
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 2rem 1.5rem;
            text-decoration: none;
            color: var(--dark-gray);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .role-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(37, 150, 190, 0.15);
            border-color: var(--primary-color);
        }

        .role-card .icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .role-card .title {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0;
        }

        .logout-link {
            margin-top: 2.5rem;
            font-size: 0.9rem;
        }
        .logout-link a {
            color: var(--dark-gray);
            text-decoration: none;
            font-weight: 600;
        }
        .logout-link a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        @media (max-width: 500px) {
            .role-selection-container {
                padding: 2rem 1.5rem;
            }
            .roles-grid {
                grid-template-columns: 1fr;
            }
        }

    </style>
</head>
<body>

    <div class="role-selection-container">
        <img src="" alt="Logo" class="header-logo">
        <h1 class="welcome-title">Bienvenido, {{ Auth::user()->nombres }}</h1>
        <p class="welcome-subtitle">Hemos detectado que tienes varios roles en nuestro sistema. Por favor, selecciona cómo quieres acceder hoy.</p>

        <div class="roles-grid">
            {{-- El backend debe pasar un array de los roles del usuario. Ej: ['ADMIN', 'DOCENTE'] --}}
            @foreach ($roles as $role)
                <a href="{{ route('definir.rol.activo', ['role' => $role]) }}" class="role-card">
                    <div class="icon">
                        @switch($role)
                            @case('admin')
                                <i class="fa-solid fa-user-shield"></i>
                                @break
                            @case('docente')    
                                <i class="fa-solid fa-chalkboard-user"></i>
                                @break
                            @case('alumno')
                                <i class="fa-solid fa-user-graduate"></i>
                                @break
                            {{-- @case('PADRE')
                                <i class="fa-solid fa-users"></i>
                                @break --}}
                            @case('encargado_sede')
                                <i class="fa-solid fa-clipboard-user"></i>
                                @break
                            @default
                                <i class="fa-solid fa-user"></i>
                        @endswitch
                    </div>
                    <h3 class="title">{{-- Aquí puedes mapear el nombre del rol a un texto más amigable --}}
                        @switch($role)
                            @case('admin') Administrador @break
                            @case('docente') Docente @break
                            @case('ALUMNO') Alumno @break
                            @case('PADRE') Apoderado @break
                            @case('encargado_sede') Encargado de Sede @break
                            @default {{ ucfirst(strtolower($role)) }}
                        @endswitch
                    </h3>
                </a>
            @endforeach
        </div>

        <div class="logout-link">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i> No soy yo, cerrar sesión
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

</body>
</html>