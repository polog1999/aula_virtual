<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
    <title>Portal Encargado de Sede | @yield('vista')</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Portal Asistencia</h3>
            </div>
            <ul class="sidebar-nav">
                {{-- <li><a href="#">Dashboard</a></li> --}}
                <li><a href="{{ route('encargadoSede.asistencias.index') }}"
                        class=" {{ Route::is('encargadoSede.asistencias.index') ? 'active' : '' }}">Asistencia
                        diaria</a></li>
                <li><a href="{{ route('encargadoSede.asistencias.reporte') }}"
                        class=" {{ Route::is('encargadoSede.asistencias.reporte') ? 'active' : '' }}">Reporte de
                        Asistencia</a></li>
                <li><a href="{{ route('encargadoSede.asistencias.reportePeriodo') }}"
                        class=" {{ Route::is('encargadoSede.asistencias.reportePeriodo') ? 'active' : '' }}">Reporte General</a></li>
                {{-- <li><a href="#">Reportes</a></li>
                <li><a href="#">Gestión de Talleres</a></li>
                <li><a href="#">Gestión de Usuarios</a></li>
                <li><a href="#">Mi Perfil</a></li> --}}
                <li><a href="{{ route('encargadoSede.perfil.index') }}"
                        class="{{ Route::is('encargadoSede.perfil.index') ? 'active' : '' }}">Mi Perfil</a></li>
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
                <div class="user-profile">Hola, {{ Auth::user()->nombres }}</div>
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

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
            });
        </script>
    @endif
    @if (isset($info))
        @if ($info)
            <script>
                Swal.fire({
                    icon: 'info',
                    title: 'Información',
                    text: @json($info),
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
    @endif




</body>

</html>
