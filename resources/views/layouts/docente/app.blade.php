<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Docente</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Portal Docente</h3>
            </div>
            <ul class="sidebar-nav">
                <li><a href="{{ route('docente.talleres') }}"
                        class="{{ Route::is('docente.talleres') ? 'active' : '' }}">Mis Talleres (Docente)</a></li>
                @if (auth()->user()->padre)
                    <li><a href="{{ route('docente.hijos.index') }}"
                            class="{{ Route::is('docente.hijos.index') ? 'active' : '' }}">Hijos
                            (Alumno)</a></li>
                @endif
                @if (auth()->user()->padre || auth()->user()->alumno)
                    <li><a href="{{ route('docente.pagos.index') }}"
                            class="{{ Route::is('docente.pagos.index') ? 'active' : '' }}">Pagos (Alumno)</a></li>
                @endif
                @if (auth()->user()->alumno)
                    <li><a href="{{ route('docente.horarios.index') }}"
                            class="{{ Route::is('docente.horarios.index') ? 'active' : '' }}">Mi Horario (Alumno)</a></li>
                @endif
                @if (auth()->user()->padre || auth()->user()->alumno)
                    <li><a href="{{ route('docente.asistencias.index') }}"
                            class="{{ Route::is('docente.asistencias.index') ? 'active' : '' }}">Asistencias
                            (Alumno)</a></li>
                @endif

                {{-- <li><a href="#">Registro de Notas</a></li> --}}
                {{-- <li><a href="#">Registro de Asistencia</a></li> --}}
                {{-- <li><a href="#">Mis Pagos</a></li> --}}
                {{-- <li><a href="#">Mi Perfil</a></li> --}}
                <li><a href="{{ route('docente.perfil.index') }}"
                        class="{{ Route::is('docente.perfil.index') ? 'active' : '' }}">Mi Perfil</a></li>
                <li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" data-view="cerrarSesion">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </aside>
        <main class="main-content">
            <nav class="top-nav">

                <div class="user-profile">Hola, {{ Auth::user()->nombres . ' ' . Auth::user()->apellido_paterno }}
                </div>
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
