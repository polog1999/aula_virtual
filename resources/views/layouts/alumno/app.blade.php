<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
    <title>Portal Alumno | @yield('title') </title>
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    

    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Portal Alumno</h3>
            </div>
            <ul class="sidebar-nav">
                <li><a href="{{ route('alumno.horarios.index') }}"
                        class="{{ Route::is('alumno.horarios.index') ? 'active' : '' }}">Mi Horario</a></li>
                <li><a href="{{ route('alumno.asistencias.index') }}"
                        class="{{ Route::is('alumno.asistencias.index') ? 'active' : '' }}">Mi Asistencia</a></li>
                <li><a href="{{ route('alumno.pagos.index') }}"
                        class="{{ Route::is('alumno.pagos.index') ? 'active' : '' }}">Mis Pagos</a></li>
                <li><a href="{{ route('alumno.perfil.index') }}"
                        class="{{ Route::is('alumno.perfil.index') ? 'active' : '' }}">Mi Perfil</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </aside>
        <main class="main-content">
            <nav class="top-nav">
                <div class="user-profile">Hola, {{ Auth::user()->nombres . ' ' . Auth::user()->apellido_paterno }}
                </div>
                {{-- <button class="menu-toggle" id="menu-toggle">☰</button> --}}
                <button id="menu-toggle" class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                
            </nav>
            @yield('content')
        </main>
    </div>
    @yield('modals')
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')

</body>

</html>
