<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
    <title>Portal Admin | @yield('vista')</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @livewireStyles
</head>

<body>
    <div class="container-fluid">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Portal
                    @activeRole('admin')
                        Administrador
                    @endactiveRole
                    @activeRole('encargado_sede')
                        Encargado Sede
                    @endactiveRole
                </h3>
            </div>
            <ul class="sidebar-nav">
                @activeRole('admin')
                    <li><a class="nav-link {{ Route::is('portal.periodos.index') ? 'active' : '' }}"
                            href="{{ route('portal.periodos.index') }}">Gestión de Periodos</a></li>
                    <li><a class="nav-link {{ Route::is('portal.cursos.index') ? 'active' : '' }}"
                            href="{{ route('portal.cursos.index') }}">Gestión de Cursos</a></li>
                    <li><a class="nav-link {{ Route::is('portal.categorias.index') ? 'active' : '' }}"
                            href="{{ route('portal.categorias.index') }}">Gestión de Categorías</a></li>
                    <li><a class="nav-link {{ Route::is('portal.secciones.index') ? 'active' : '' }}"
                            href="{{ route('portal.secciones.index') }}">Gestión de Horarios</a></li>
                    <li><a class="nav-link {{ Route::is('portal.docentes.index') ? 'active' : '' }}"
                            href="{{ route('portal.docentes.index') }}">Docentes</a></li>
                    <li><a class="nav-link {{ Route::is('portal.alumnos.index') ? 'active' : '' }}"
                            href="{{ route('portal.alumnos.index') }}">Alumnos</a></li>
                    <li><a class="nav-link {{ Route::is('portal.matriculas.index') ? 'active' : '' }}"
                            href="{{ route('portal.matriculas.index') }}">Matriculas</a></li>
                    <li><a class="nav-link {{ Route::is('portal.users.index') ? 'active' : '' }}"
                            href="{{ route('portal.users.index') }}">Usuarios del Sistema</a></li>
                @endactiveRole

                @activeRole('encargado_sede')
                    <li><a href="{{ route('portal.asistencias.index') }}"
                            class="{{ Route::is('portal.asistencias.index') ? 'active' : '' }}">Asistencia diaria</a></li>
                    <li><a href="{{ route('portal.asistencias.reporte') }}"
                            class="{{ Route::is('portal.asistencias.reporte') ? 'active' : '' }}">Reporte General</a></li>
                    <li><a href="{{ route('portal.asistencias.reporteMensual') }}"
                            class="{{ Route::is('portal.asistencias.reporteMensual') ? 'active' : '' }}">Reporte de
                            Asistencia</a></li>
                    <li><a href="{{ route('portal.perfil.index') }}"
                            class="{{ Route::is('portal.perfil.index') ? 'active' : '' }}">Mi Perfil</a></li>
                @endactiveRole

                @activeRole('docente')
                    <li><a href="{{ route('portal.misCursos') }}"
                            class="{{ Route::is('portal.misCursos') ? 'active' : '' }}">Mis Cursos (Docente)</a></li>
                @endactiveRole

                @activeRole('alumno')
                    <li><a href="{{ route('portal.horarios.index') }}"
                            class="{{ Route::is('portal.horarios.index') ? 'active' : '' }}">Horario</a></li>
                @endactiveRole


                @activeRole('admin|docente|encargado_sede|alumno')
                    <li><a href="{{ route('portal.perfil.index') }}"
                            class="{{ Route::is('portal.perfil.index') ? 'active' : '' }}">Mi Perfil</a></li>
                @endactiveRole
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        style="width: 100%; text-align: left; background: none; border: none; padding: 10px 20px; color: white; cursor: pointer;">Cerrar
                        sesión</button>
                </form>
                </li>
            </ul>
        </aside>

        <main class="main-content">
            <nav class="top-nav">
                <div class="user-profile">Hola, {{ Auth::user()->nombres }}</div>
                <button id="menu-toggle" class="hamburger">
                    <span></span><span></span><span></span>
                </button>
            </nav>

            {{ $slot }}

        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts

    <script>
        // Función universal de confirmación para Livewire
        function confirmarAccion(metodo, id, titulo) {
            Swal.fire({
                title: titulo,
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-5 py-3 font-bold',
                    cancelButton: 'rounded-xl px-5 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(metodo, {
                        id: id
                    });
                }
            });
        }

        // Listener para notificaciones de SweetAlert desde Livewire
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal', (event) => {
                const data = event[0];
                Swal.fire({
                    icon: data.icon || 'success',
                    title: data.title || 'Mensaje',
                    text: data.text || '',
                    confirmButtonColor: '#4f46e5',
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                });
            });
        });
    </script>
</body>

</html>
