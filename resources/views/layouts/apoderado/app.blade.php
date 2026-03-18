<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
    <title>Portal Familiar | @yield('title') </title>
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Portal Apoderado</h3>
            </div>
            <ul class="sidebar-nav">
                <li><a href="{{ route('apoderado.hijos.index') }}"
                        class="{{ Route::is('apoderado.hijos.index') ? 'active' : '' }}">Mis Hijos</a></li>
                @if (auth()->user()->alumno)
                    <li><a href="{{ route('apoderado.horarios.index') }}"
                            class="{{ Route::is('apoderado.horarios.index') ? 'active' : '' }}">Mi horario</a></li>
                @endif

                <li><a href="{{ route('apoderado.asistencias.index') }}"
                        class="{{ Route::is('apoderado.asistencias.index') ? 'active' : '' }}">Asistencias</a></li>
                <li><a href="{{ route('apoderado.pagos.index') }}"
                        class="{{ Route::is('apoderado.pagos.index') ? 'active' : '' }}">Pagos</a></li>
                {{-- <li><a href="#">Inscripciones</a></li> --}}
                <li><a href="{{ route('apoderado.perfil.index') }}"
                        class="{{ Route::is('apoderado.perfil.index') ? 'active' : '' }}">Mi Perfil</a></li>
                <li>
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
                <div class="user-profile">Hola, {{ Auth::user()->nombres . ' ' . Auth::user()->apellido_paterno }}</div>
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
