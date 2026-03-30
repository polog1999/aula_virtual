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
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        
        .btn-danger {
            background-color: #e74c3c;
            color: white;
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
                                <span>{{ $curso->nombre }}</span>
                                <form action="{{ route('portal.cursos.destroy', $curso) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este curso? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 2px 6px; font-size: 0.7rem;" onclick="event.stopPropagation();"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Columna Derecha: Módulos y Sesiones del Curso Seleccionado -->
            <div class="table-container">
                @if ($cursoSeleccionado)
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3>Unidades de: {{ $cursoSeleccionado->nombre }}</h3>
                        <div>
                            <button class="btn btn-secondary" id="editCourseBtn"
                                data-id="{{ $cursoSeleccionado->id }}"
                                data-nombre="{{ $cursoSeleccionado->nombre }}"
                                data-descripcion="{{ $cursoSeleccionado->descripcion }}"
                                data-categoria_id="{{ $cursoSeleccionado->categoria_id }}"
                                data-activo="{{ $cursoSeleccionado->activo }}">
                                <i class="fa-solid fa-pencil"></i> Editar Curso
                            </button>
                            <button class="btn btn-primary" id="openCreateModuleModalBtn">
                                <i class="fa-solid fa-plus"></i> Añadir Unidad
                            </button>
                        </div>
                    </div>

                    <div class="module-accordion">
                        @forelse ($cursoSeleccionado->modulos as $modulo)
                            <div class="module open">
                                <div class="module-header">
                                    <h4><i class="fa-solid fa-layer-group"></i> {{ $modulo->nombre }}</h4>
                                    <div>
                                        <button class="btn btn-secondary btn-sm edit-module-btn"
                                            data-modulo-id="{{ $modulo->id }}" data-nombre="{{ $modulo->nombre }}"
                                            data-descripcion="{{ $modulo->descripcion }}" data-orden="{{ $modulo->orden }}"
                                            data-prerequisito_id="{{ $modulo->prerequisito_id }}"
                                            data-disponible_desde="{{ $modulo->disponible_desde ? \Carbon\Carbon::parse($modulo->disponible_desde)->format('Y-m-d') : '' }}"
                                            data-activo="{{ $modulo->activo }}">Editar</button>
                                        <button class="btn btn-primary btn-sm add-session-btn"
                                            data-modulo-id="{{ $modulo->id }}"
                                            data-modulo-nombre="{{$modulo->nombre}}">Añadir Sesión</button>
                                        <form action="{{ route('portal.modulos.destroy', $modulo) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta unidad?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="module-body">
                                    <div class="session-list">
                                        @forelse($modulo->sesiones as $sesion)
                                            <div class="session-item">
                                                <div>
                                                    <i class="{{ $sesion->es_evaluacion ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-book-open' }}"></i>
                                                    <strong>{{ $sesion->titulo }}</strong> - <span>{{ $sesion->descripcion }}</span>
                                                </div>
                                                <div>
                                                    <button class="btn btn-secondary btn-sm">Recursos</button>
                                                    <button class="btn btn-primary btn-sm edit-session-btn"
                                                        data-sesion-id="{{ $sesion->id }}" data-modulo-id="{{ $sesion->modulo_id }}"
                                                        data-titulo="{{ $sesion->titulo }}" data-descripcion="{{ $sesion->descripcion }}"
                                                        data-es_evaluacion="{{ $sesion->es_evaluacion }}" data-activo="{{ $sesion->activo }}">Editar</button>
                                                    <form action="{{ route('portal.sesiones.destroy', $sesion) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta sesión?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        @empty
                                            <p>No hay sesiones en este módulo.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>Este curso aún no tiene unidades. ¡Añade la primera!</p>
                        @endforelse
                    </div>
                @else
                    <h3>Selecciona un Curso</h3>
                    <p>Por favor, selecciona un curso de la lista de la izquierda para ver y gestionar sus unidades y sesiones.</p>
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
            <form id="courseForm" method="POST" action="{{ route('portal.cursos.store') }}" enctype="multipart/form-data">
                @csrf
                <div id="courseMethod"></div>
                <div class="form-grid">
                    <div class="form-group full-width"><label for="courseNombre">Nombre del Curso</label><input type="text" id="courseNombre" name="nombre" required></div>
                    <div class="form-group full-width"><label for="courseDescripcion">Descripción</label><textarea id="courseDescripcion" name="descripcion" rows="4" style="width: 100%; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem;"></textarea></div>
                    <div class="form-group"><label for="courseCategoria">Categoría</label><select id="courseCategoria" name="categoria_id" required><option value="">Seleccionar...</option>@foreach($categorias as $cat)<option value="{{ $cat->id }}">{{ $cat->nombre }}</option>@endforeach</select></div>
                    <div class="form-group"><label for="courseImagen">Imagen</label><input type="file" id="courseImagen" name="imagen" accept="image/*"></div>
                    <div class="form-group"><label for="courseActivo">Estado</label><select id="courseActivo" name="activo" required><option value="1">Activo</option><option value="0">Inactivo</option></select></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary cancel-btn">Cancelar</button><button type="submit" class="btn btn-primary">Guardar Curso</button></div>
            </form>
        </div>
    </div>
    
    <!-- Modal para CREAR/EDITAR Módulo -->
    <div id="moduleModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="moduleModalTitle">Añadir Unidad</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="moduleForm" method="POST">
                @csrf
                <div id="moduleMethod"></div>
                <input type="hidden" name="curso_id" value="{{ $cursoSeleccionado?->id }}">
                <div class="form-grid">
                    <input type="hidden" id="moduleNombre" name="nombre">
                    <div class="form-group full-width"><label for="moduleDescripcion">Descripción de la Unidad</label><textarea id="moduleDescripcion" name="descripcion" rows="3" required style="width: 100%; padding: 0.8rem; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem;"></textarea></div>
                    <div class="form-group"><label for="moduleOrden">Orden</label><input type="number" id="moduleOrden" name="orden" required></div>
                    <div class="form-group"><label for="selectModule">Unidad Requisito (Opcional)</label>
                        <select id="selectModule" name="prerequisito_id">
                            <option value="">Ninguno</option>
                            @if($cursoSeleccionado)
                                @foreach ($cursoSeleccionado->modulos as $modulo)
                                    <option value="{{ $modulo->id }}">{{$modulo->nombre}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group"><label for="disponible_desde">Disponible Desde</label><input type="date" id="disponible_desde" name="disponible_desde" required></div>
                    <div class="form-group"><label for="selectEstadoModulo">Estado</label><select id="selectEstadoModulo" name="activo"><option value="1">Activo</option><option value="0">Inactivo</option></select></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary cancel-btn">Cancelar</button><button type="submit" class="btn btn-primary">Guardar Unidad</button></div>
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
                    <input type="hidden" id="sessionTitulo" name="titulo">
                    <div class="form-group full-width"><label for="sessionDescripcion">Descripción de la Sesión</label><input type="text" id="sessionDescripcion" name="descripcion" required></div>
                    <div class="form-group"><label>¿Es una evaluación?</label>
                        <div style="display:flex; gap: 1rem; align-items:center; margin-top: 0.5rem;">
                            <label><input type="radio" name="es_evaluacion" value="1"> Sí</label>
                            <label><input type="radio" name="es_evaluacion" value="0" checked> No</label>
                        </div>
                    </div>
                    <div class="form-group"><label for="selectEstadoSesion">Estado</label><select id="selectEstadoSesion" name="activo"><option value="1">Activo</option><option value="0">Inactivo</option></select></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary cancel-btn">Cancelar</button><button type="submit" class="btn btn-primary">Guardar Sesión</button></div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function openModal(modal) { if (modal) modal.style.display = 'flex'; }
            function closeModal(modal) { if (modal) modal.style.display = 'none'; }
            document.querySelectorAll('.modal').forEach(modal => {
                modal.querySelector('.close-icon')?.addEventListener('click', () => closeModal(modal));
                modal.querySelector('.cancel-btn')?.addEventListener('click', () => closeModal(modal));
            });

            document.querySelectorAll('.module-header').forEach(header => {
                header.addEventListener('click', (e) => {
                    if (!e.target.closest('button')) { header.parentElement.classList.toggle('open'); }
                });
            });

            // --- Lógica para Cursos ---
            const courseModal = document.getElementById('courseModal');
            const courseForm = document.getElementById('courseForm');
            document.getElementById('openCreateCourseModalBtn')?.addEventListener('click', () => {
                courseForm.reset();
                document.getElementById('courseModalTitle').textContent = 'Crear Nuevo Curso';
                courseForm.action = "{{ route('portal.cursos.store') }}";
                document.getElementById('courseMethod').innerHTML = '';
                openModal(courseModal);
            });
            document.getElementById('editCourseBtn')?.addEventListener('click', function() {
                courseForm.reset();
                document.getElementById('courseModalTitle').textContent = `Editar Curso: ${this.dataset.nombre}`;
                document.getElementById('courseNombre').value = this.dataset.nombre;
                document.getElementById('courseDescripcion').value = this.dataset.descripcion;
                document.getElementById('courseCategoria').value = this.dataset.categoria_id;
                document.getElementById('courseActivo').value = this.dataset.activo;
                courseForm.action = `{{ url('portal/cursos') }}/${this.dataset.id}`;
                document.getElementById('courseMethod').innerHTML = '@method("PUT")';
                openModal(courseModal);
            });

            // --- Lógica para Módulos ---
            const moduleModal = document.getElementById('moduleModal');
            const moduleForm = document.getElementById('moduleForm');
            document.getElementById('openCreateModuleModalBtn')?.addEventListener('click', () => {
                moduleForm.reset();
                document.getElementById('moduleModalTitle').textContent = 'Añadir Nueva Unidad';
                const nextModuleNumber = {{ $cursoSeleccionado ? $cursoSeleccionado->modulos->count() + 1 : 1 }};
                document.getElementById('moduleNombre').value = `Módulo ${nextModuleNumber}`;
                moduleForm.action = "{{ route('portal.modulos.store') }}";
                document.getElementById('moduleMethod').innerHTML = '';
                openModal(moduleModal);
            });
            document.querySelectorAll('.edit-module-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    moduleForm.reset();
                    document.getElementById('moduleModalTitle').textContent = `Editar Unidad: ${this.dataset.nombre}`;
                    document.getElementById('moduleNombre').value = this.dataset.nombre;
                    document.getElementById('moduleDescripcion').value = this.dataset.descripcion;
                    document.getElementById('moduleOrden').value = this.dataset.orden;
                    document.getElementById('selectModule').value = this.dataset.prerequisito_id;
                    document.getElementById('disponible_desde').value = this.dataset.disponible_desde;
                    document.getElementById('selectEstadoModulo').value = this.dataset.activo;
                    moduleForm.action = `{{ url('portal/modulos') }}/${this.dataset.moduloId}`;
                    document.getElementById('moduleMethod').innerHTML = '@method("PUT")';
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
                    const moduloNombre = this.dataset.moduloNombre;
                    const sessionsInModule = this.closest('.module').querySelectorAll('.session-item').length;
                    const nextSessionNumber = sessionsInModule + 1;
                    document.getElementById('sessionModalTitle').textContent = `Añadir Sesión a ${moduloNombre}`;
                    document.getElementById('sessionTitulo').value = `Sesión ${nextSessionNumber}`;
                    document.getElementById('sessionModuleId').value = this.dataset.moduloId;
                    sessionForm.action = "{{ route('portal.sesiones.store') }}";
                    document.getElementById('sessionMethod').innerHTML = '';
                    openModal(sessionModal);
                });
            });
            document.querySelectorAll('.edit-session-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sessionForm.reset();
                    document.getElementById('sessionModalTitle').textContent = `Editar Sesión: ${this.dataset.titulo}`;
                    document.getElementById('sessionTitulo').value = this.dataset.titulo;
                    document.getElementById('sessionDescripcion').value = this.dataset.descripcion;
                    document.getElementById('sessionModuleId').value = this.dataset.moduloId;
                    document.querySelector('input[name="es_evaluacion"][value="${this.dataset.es_evaluacion}"]').checked = true;
                    document.getElementById('selectEstadoSesion').value = this.dataset.activo;
                    sessionForm.action = `{{ url('portal/sesiones') }}/${this.dataset.sesionId}`;
                    document.getElementById('sessionMethod').innerHTML = '@method("PUT")';
                    openModal(sessionModal);
                });
            });
        });
    </script>
@endpush