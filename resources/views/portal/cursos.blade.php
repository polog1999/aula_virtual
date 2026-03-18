@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paginacion-buscador.css') }}">
    <style>
        /* ESTILOS ADICIONALES PARA EL CONSTRUCTOR DE CURSOS */
        .constructor-container {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
            align-items: flex-start;
        }

        .course-list-panel {
            position: sticky;
            top: 100px;
        }

        .course-list {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 70vh;
            overflow-y: auto;
        }

        .course-list-item a {
            display: block;
            padding: 0.8rem 1rem;
            text-decoration: none;
            color: var(--dark-gray);
            border-left: 4px solid transparent;
            transition: all 0.2s ease;
        }

        .course-list-item a:hover {
            background-color: #f0f0f0;
        }

        .course-list-item a.active {
            background-color: var(--light-green);
            border-left-color: var(--primary-color);
            font-weight: bold;
        }

        .module-accordion .module {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .module-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .module-header h4 {
            margin: 0;
        }

        .module-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-in-out;
        }

        .module.open .module-body {
            max-height: 2000px;
            /* Valor alto */
        }

        .session-list {
            padding: 1rem 1.5rem;
        }

        .session-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--light-gray);
        }

        .session-item:last-child {
            border-bottom: none;
        }

        .session-item i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        .btn-sm {
            padding: 0.3rem 0.8rem;
            font-size: 0.8rem;
        }

        @media (max-width: 992px) {
            .constructor-container {
                grid-template-columns: 1fr;
            }

            .course-list-panel {
                position: static;
                top: auto;
            }
        }
    </style>
@endpush
@section('vista', 'Constructor de Cursos')

@section('content')
    <div class="content">
        <h1>Constructor de Cursos</h1>
        <div class="constructor-container">
            <!-- Columna Izquierda: Lista de Cursos -->
            <div class="table-container course-list-panel">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3>Cursos</h3>
                    <button class="btn btn-primary btn-sm" id="openCreateCourseModalBtn">
                        <i class="fa-solid fa-plus"></i> Nuevo
                    </button>
                </div>
                <ul class="course-list">
                    @foreach ($cursos as $curso)
                        <li class="course-list-item">
                            <a href="{{ route('portal.cursos.index', ['curso_id' => $curso->id]) }}"
                                class="{{ request('curso_id') == $curso->id ? 'active' : '' }}">
                                {{ $curso->nombre }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Columna Derecha: Módulos y Sesiones del Curso Seleccionado -->
            <div class="table-container">
                @if ($cursoSeleccionado)
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3>Módulos de: {{ $cursoSeleccionado->nombre }}</h3>
                        <button class="btn btn-primary" id="openCreateModuleModalBtn">
                            <i class="fa-solid fa-plus"></i> Añadir Módulo
                        </button>
                    </div>

                    <div class="module-accordion">
                        @forelse ($cursoSeleccionado->modulos as $modulo)
                            <div class="module open">
                                <div class="module-header">
                                    <h4><i class="fa-solid fa-layer-group"></i> {{ $modulo->nombre }}</h4>
                                    <div>
                                        <button class="btn btn-secondary btn-sm edit-module-btn"
                                            data-modulo-id="{{ $modulo->id }}" data-nombre="{{ $modulo->nombre }}"
                                            data-descripcion="{{ $modulo->descripcion }}">Editar</button>
                                        <button class="btn btn-primary btn-sm add-session-btn"
                                            data-modulo-id="{{ $modulo->id }}">Añadir Sesión</button>
                                    </div>
                                </div>
                                <div class="module-body">
                                    <div class="session-list">
                                        @forelse($modulo->sesiones as $sesion)
                                            <div class="session-item">
                                                <div>
                                                    <i
                                                        class="{{ $sesion->es_evaluacion ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-book-open' }}"></i>
                                                    <strong>{{ $sesion->descripcion }}</strong>
                                                    {{-- ({{ \Carbon\Carbon::parse($sesion->fecha)->format('d/m/Y') }}) --}}
                                                </div>
                                                <div>
                                                    {{-- <button class="btn btn-secondary btn-sm">Recursos</button> --}}
                                                    <button class="btn btn-primary btn-sm">Editar</button>
                                                </div>
                                            </div>
                                        @empty
                                            <p>No hay sesiones en este módulo.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>Este curso aún no tiene módulos. ¡Añade el primero!</p>
                        @endforelse
                    </div>
                @else
                    <h3>Selecciona un Curso</h3>
                    <p>Por favor, selecciona un curso de la lista de la izquierda para ver y gestionar sus módulos y
                        sesiones.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Modal para CREAR/EDITAR Curso -->
    <div id="courseModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="courseModalTitle">Crear Nuevo Curso</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="courseForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="courseMethod"></div>
                <div class="form-grid">
                    <div class="form-group full-width"><label for="courseNombre">Nombre del Curso</label><input
                            type="text" id="courseNombre" name="nombre" required></div>
                    <div class="form-group full-width"><label for="courseDescripcion">Descripción</label>
                        <textarea id="courseDescripcion" name="descripcion" rows="4"
                            style="width: 100%; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem;"></textarea>
                    </div>
                    <div class="form-group"><label for="courseCategoria">Categoría</label><select id="courseCategoria"
                            name="categoria_id" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                            @endforeach
                        </select></div>
                    <div class="form-group"><label for="courseImagen">Imagen</label><input type="file" id="courseImagen"
                            name="imagen" accept="image/*"></div>
                    <div class="form-group"><label for="courseActivo">Estado</label><select id="courseActivo" name="activo"
                            required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select></div>
                </div>
                <div class="modal-footer"><button type="button"
                        class="btn btn-secondary cancel-btn">Cancelar</button><button type="submit"
                        class="btn btn-primary">Guardar Curso</button></div>
            </form>
        </div>
    </div>

    <!-- Modal para CREAR/EDITAR Módulo -->
    <div id="moduleModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="moduleModalTitle">Añadir Módulo</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="moduleForm" method="POST">
                @csrf
                <div id="moduleMethod"></div>
                <input type="hidden" name="curso_id" value="{{ $cursoSeleccionado?->id }}">
                <div class="form-grid">
                    <div class="form-group full-width"><label for="moduleNombre">Nombre del Módulo</label><input
                            type="text" id="moduleNombre" name="nombre" required></div>
                    <div class="form-group full-width"><label for="moduleDescripcion">Descripción</label>
                        <textarea id="moduleDescripcion" name="descripcion" rows="3"
                            style="width: 100%; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem;"></textarea>
                    </div>
                    <div class="form-group full-width"><label for="moduleOrden">Orden</label><input type="number"
                            id="moduleOrden" name="orden" required></div>
                    <div class="form-group full-width"><label for="selectModule">Modulo Requisito</label>
                        <select id="selectModule" name="selectModule">
                            <option value="">Seleccionar Módulo</option>
                            @forelse ($modulos as $modulo)
                                <option value="{{ $modulo->id }}">{{$modulo->nombre}}</option>
                            @empty
                            No hay modulos
                            @endforelse
                        </select>

                    </div>
                    <div class="form-group full-width"><label for="disponible_desde">Disponible Desde</label><input
                            type="date" id="disponible_desde" name="disponible_desde" required></div>
                    <div class="form-group full-width"><label for="selectEstado">Estado</label>
                        <select id="selectEstado" name="activo">
                            <option value="1">ACTIVO</option>
                            <option value="1">INACTIVO</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer"><button type="button"
                        class="btn btn-secondary cancel-btn">Cancelar</button><button type="submit"
                        class="btn btn-primary">Guardar Módulo</button></div>
            </form>
        </div>
    </div>

    <!-- Modal para CREAR/EDITAR Sesión -->
    <div id="sessionModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="sessionModalTitle">Añadir Sesión</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="sessionForm" method="POST">
                @csrf
                <div id="sessionMethod"></div>
                <input type="hidden" id="sessionModuleId" name="modulo_id">
                <div class="form-grid">
                     <div class="form-group full-width"><label for="sessionTitulo">Título</label><input
                            type="text" id="sessionTitulo" name="titulo" required></div>
                    <div class="form-group full-width"><label for="sessionDescripcion">Descripción</label><input
                            type="text" id="sessionDescripcion" name="descripcion" required></div>
                    {{-- <div class="form-group"><label for="sessionFecha">Fecha</label><input type="date"
                            id="sessionFecha" name="fecha" required></div> --}}
                    {{-- <div class="form-group"><label for="sessionLink">Link Reunión (Zoom, Meet)</label><input
                            type="url" id="sessionLink" name="link_reunion"></div> --}}
                    <div class="form-group"><label>¿Es una evaluación?</label>
                        <div style="display:flex; gap: 1rem; align-items:center; margin-top: 0.5rem;">
                            <label><input type="radio" name="es_evaluacion" value="1"> Sí</label>
                            <label><input type="radio" name="es_evaluacion" value="0" checked> No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group full-width"><label for="selectEstado">Estado</label>
                    <select id="selectEstado" name="activo">
                        <option value="1">ACTIVO</option>
                        <option value="1">INACTIVO</option>
                    </select>
                </div>
                <div class="modal-footer"><button type="button"
                        class="btn btn-secondary cancel-btn">Cancelar</button><button type="submit"
                        class="btn btn-primary">Guardar Sesión</button></div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function openModal(modal) {
                if (modal) modal.style.display = 'flex';
            }

            function closeModal(modal) {
                if (modal) modal.style.display = 'none';
            }
            document.querySelectorAll('.modal').forEach(modal => {
                modal.querySelector('.close-icon')?.addEventListener('click', () => closeModal(modal));
                modal.querySelector('.cancel-btn')?.addEventListener('click', () => closeModal(modal));
            });

            // Lógica del Acordeón
            document.querySelectorAll('.module-header').forEach(header => {
                header.addEventListener('click', () => {
                    header.parentElement.classList.toggle('open');
                });
            });

            // --- Lógica para Cursos ---
            const courseModal = document.getElementById('courseModal');
            const courseForm = document.getElementById('courseForm');
            document.getElementById('openCreateCourseModalBtn')?.addEventListener('click', () => {
                courseForm.reset();
                document.getElementById('courseModalTitle').textContent = 'Crear Nuevo Curso';
                courseForm.action = "{{ route('portal.cursos.store') }}"; // Asume esta ruta
                document.getElementById('courseMethod').innerHTML = '';
                openModal(courseModal);
            });
            // (Necesitarías una lógica similar para editar cursos)

            // --- Lógica para Módulos ---
            const moduleModal = document.getElementById('moduleModal');
            const moduleForm = document.getElementById('moduleForm');
            document.getElementById('openCreateModuleModalBtn')?.addEventListener('click', () => {
                moduleForm.reset();
                document.getElementById('moduleModalTitle').textContent = 'Añadir Nuevo Módulo';
                moduleForm.action = "{{ route('portal.modulos.store') }}"; // Asume esta ruta
                document.getElementById('moduleMethod').innerHTML = '';
                openModal(moduleModal);
            });
            document.querySelectorAll('.edit-module-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation(); // Evita que el acordeón se cierre
                    moduleForm.reset();
                    document.getElementById('moduleModalTitle').textContent =
                        `Editar Módulo: ${this.dataset.nombre}`;
                    document.getElementById('moduleNombre').value = this.dataset.nombre;
                    document.getElementById('moduleDescripcion').value = this.dataset.descripcion;
                    moduleForm.action =
                        `{{ url('admin/modulos') }}/${this.dataset.moduloId}`; // Asume esta ruta
                    document.getElementById('moduleMethod').innerHTML = '@method('PUT')';
                    openModal(moduleModal);
                });
            });

            // --- Lógica para Sesiones ---
            const sessionModal = document.getElementById('sessionModal');
            const sessionForm = document.getElementById('sessionForm');
            document.querySelectorAll('.add-session-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sessionForm.reset();
                    document.getElementById('sessionModalTitle').textContent =
                        'Añadir Nueva Sesión';
                    document.getElementById('sessionModuleId').value = this.dataset.moduloId;
                    sessionForm.action = "{{ route('portal.sesiones.store') }}"; // Asume esta ruta
                    document.getElementById('sessionMethod').innerHTML = '';
                    openModal(sessionModal);
                });
            });
            // (Necesitarías lógica para editar sesiones)
        });
    </script>
@endpush
