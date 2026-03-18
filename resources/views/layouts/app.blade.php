<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
    <title>Portal Admin | @yield('vista')</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">

                <h3>Portal @activeRole('admin')
                        Administrador
                        @endactiveRole @activeRole('encargado_sede')
                        Encargado Sede
                    @endactiveRole
                    
                </h3>


            </div>
            <ul class="sidebar-nav">
                @activeRole('admin')
                    {{-- <li><a data-view="dashboard" class="nav-link {{ Route::is('portal.dashboard') ? 'active' : '' }}"
                            href="{{ route('portal.dashboard') }}">Dashboard</a>
                    </li> --}}

                    <li><a data-view="periodos" class="nav-link {{ Route::is('portal.periodos.index') ? 'active' : '' }}"
                            href="{{ route('portal.periodos.index') }}">Gestión de Periodos</a></li>
                    <li><a data-view="deportes" class="nav-link {{ Route::is('portal.cursos.index') ? 'active' : '' }}"
                            href="{{ route('portal.cursos.index') }}">Gestión de Cursos</a></li>
                    <li><a data-view="categorias"
                            class="nav-link {{ Route::is('portal.categorias.index') ? 'active' : '' }}"
                            href="{{ route('portal.categorias.index') }}">Gestión de Categorías</a></li>
                    {{-- <li><a data-view="lugares" class="nav-link {{ Route::is('portal.lugares.index') ? 'active' : '' }}"
                            href="{{ route('portal.lugares.index') }}">Gestión de Sede</a></li> --}}
                    {{-- <li><a data-view="talleres" class="nav-link {{ Route::is('portal.talleres.index') ? 'active' : '' }}"
                            href="{{ route('portal.modulos.index') }}">Gestión de Módulos</a></li> --}}
                    <li><a data-view="secciones" class="nav-link {{ Route::is('portal.secciones.index') ? 'active' : '' }}"
                            href="{{ route('portal.secciones.index') }}">Gestión de Horarios</a></li>
                    <li><a data-view="docentes" class="nav-link {{ Route::is('portal.docentes.index') ? 'active' : '' }}"
                            href="{{ route('portal.docentes.index') }}">Docentes</a></li>
                    <li><a data-view="alumnos" class="nav-link {{ Route::is('portal.alumnos.index') ? 'active' : '' }}"
                            href="{{ route('portal.alumnos.index') }}">Alumnos</a></li>
                    <li><a data-view="matriculas"
                            class="nav-link {{ Route::is('portal.matriculas.index') ? 'active' : '' }}"
                            href="{{ route('portal.matriculas.index') }}">Matriculas</a></li>
                    {{-- <li><a data-view="cronogramaPagos"
                        class="nav-link {{ Route::is('portal.cronogramaPagos.index') ? 'active' : '' }}"
                        href="{{ route('portal.cronogramaPagos.index') }}">Cronograma de Pagos</a></li> --}}
                    {{-- <li><a data-view="pagos" class="nav-link {{ Route::is('portal.pagos.index') ? 'active' : '' }}"
                            href="{{ route('portal.pagos.index') }}">Pagos</a></li> --}}
                    {{-- <li><a data-view="reportes" class="nav-link">Reportes</a></li> --}}
                    <li><a data-view="usuarios" class="nav-link {{ Route::is('portal.users.index') ? 'active' : '' }}"
                            href="{{ route('portal.users.index') }}">Usuarios del Sistema</a></li>
                    {{-- <li><a href="{{ route('portal.perfil.index') }}"
                            class="{{ Route::is('portal.perfil.index') ? 'active' : '' }}">Mi Perfil</a>

                    <li> --}}
                @endactiveRole
                <!-----------------------------ENCARGADO DE SEDE Y ADMINISTRADOR -------------------------------->
                @activeRole('encargado_sede')
                    <li><a href="{{ route('portal.asistencias.index') }}"
                            class=" {{ Route::is('portal.asistencias.index') ? 'active' : '' }}">Asistencia
                            diaria</a></li>
                    <li><a href="{{ route('portal.asistencias.reporte') }}"
                            class=" {{ Route::is('portal.asistencias.reporte') ? 'active' : '' }}">Reporte de
                            Asistencia</a></li>
                    <li><a href="{{ route('portal.asistencias.reportePeriodo') }}"
                            class=" {{ Route::is('portal.asistencias.reportePeriodo') ? 'active' : '' }}">Reporte
                            General</a></li>

                    <li><a href="{{ route('portal.perfil.index') }}"
                            class="{{ Route::is('portal.perfil.index') ? 'active' : '' }}">Mi Perfil</a></li>

                    <li>
                    @endactiveRole
                    <!----------------------------DOCENTE----------------------------------->
                    @activeRole('docente')
                    <li><a href="{{ route('portal.misCursos') }}"
                            class="{{ Route::is('portal.misCursos') ? 'active' : '' }}">Mis Cursos (Docente)</a></li>
                @endactiveRole
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
                {{-- <button class="menu-toggle" id="menu-toggle">
                    ☰
                </button> --}}
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // detiene el envío inmediato del form

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: 'Esta acción eliminará el registro permanentemente.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // si confirma, se envía el formulario
                        }
                    });
                });
            });

        });
    </script>


</body>

</html>
