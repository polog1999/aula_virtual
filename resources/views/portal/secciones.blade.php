@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/talleres.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paginacion-buscador.css') }}">
@endpush
@section('vista', 'Gestión de Secciones')

@section('content')

    <div class="content">
        <div id="dashboard-view">
            <h1>Gestión de Secciones</h1>

            <div class="table-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3>Listado de Secciones</h3>
                    <button class="btn btn-primary" id="openCreateModalBtn">Crear Nueva Sección</button>
                </div>
                {{-- <form method="GET" action="{{ route('portal.secciones.index') }}" class="search-bar">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Buscar por sección, taller o docente..." class="form-control w-25 d-inline">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form> --}}

                <div style="width: 100%;overflow:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th>Sección</th>
                                <th>Horario</th>
                                <th>Docente</th>
                                <th>Cant. Vacantes</th>
                                <th>Cant. Matriculados</th>
                                <th>Periodo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($secciones as $seccion)
                                <tr>
                                    <td>{{ $seccion->curso->nombre }}
                                       
                                    </td>
                                    <td>{{ $seccion->nombre }}</td>
                                    <td>{{ $seccion->dia_semana }}</td>
                                    <td>{{ $seccion->docentes ? $seccion->docentes->user->nombres . ' ' . $seccion->docentes->user->apellido_paterno : '' }}
                                    </td>
                                    <td>{{ $seccion->vacantes }}</td>
                                    <td>{{ $seccion->matriculas_activas}}</td>
                                    <td>{{ $seccion->periodo->anio }}-{{ $seccion->periodo->ciclo }}</td>
                                    <td><span
                                            class="status-badge status-{{ $seccion->activo ? 'active' : 'inactive' }}">{{ $seccion->activo ? 'Activo' : 'Inactivo' }}</span>
                                    </td>
                                    <td>
                                        {{-- <button class="btn btn-primary edit-btn" data-id="{{ $seccion->id }}"
                                            data-nombre="{{ $seccion->nombre }}"
                                            data-taller="{{ $seccion->curso->id }}"
                                            data-vacantes="{{ $seccion->vacantes }}"
                                            data-periodo="{{ $seccion->periodo->id }}"
                                            data-activo="{{ $seccion->activo }}"
                                            data-docente="{{ $seccion->docentes ? $seccion->docentes->user_id : '' }}"
                                            {{-- data-lugar="{{ $seccion->lugar_id }}" --}}
                                            {{-- data-fecha-inicio="{{ $seccion->fecha_inicio ? $seccion->fecha_inicio->format('Y-m-d') : '' }}" --}}
                                            {{-- data-fecha-fin="{{ $seccion->fecha_fin ? $seccion->fecha_fin->format('Y-m-d') : '' }}" --}}
                                            {{-- data-horarios='@json($seccion->horarios)'>Editar</button> --}}
                                        <form class="delete-form" action="{{ route('portal.secciones.destroy', $seccion) }}"
                                            method="POST" style="display:inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger delete-btn" type="submit">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                {{ $secciones->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modals')
    <div id="createWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Crear Nueva Sección</h2>
                <span class="close-icon">&times;</span>
            </div>

            <form id="createWorkshopForm" action="{{ route('portal.secciones.store') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div
                        style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <strong>¡Ups! Revisa los siguientes errores:</strong>
                        <ul style="list-style-type: none;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-grid">

                    <div class="form-group"><label for="createPeriodo">Periodo</label>
                        <select id="createPeriodo" name="createPeriodo" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($periodos as $periodo)
                                <option value="{{ $periodo->id }}"
                                    data-inicio="{{ $periodo->fecha_inicio ? $periodo->fecha_inicio->format('Y-m-d') : '' }}"
                                    data-fin="{{ $periodo->fecha_fin ? $periodo->fecha_fin->format('Y-m-d') : '' }}">
                                    {{ $periodo->anio }}-{{ $periodo->ciclo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label for="createTaller">Curso</label>
                        <select id="createTaller" name="createTaller" required>
                            <option value="">Seleccionar...</option>
                           @foreach($cursos as $curso)
                           <option value="{{$curso->id}}">{{$curso->nombre}}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label for="createNombre">Nombre de la Sección</label><input type="text"
                            id="createNombre" name="createNombre" required></div>

                    <div class="form-group"><label for="createTeacher">Docente</label>
                        <select id="createTeacher" name="createDocente" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($docentes as $docente)
                                <option value="{{ $docente->user_id }}">
                                    {{ $docente->user->nombres . ' ' . $docente->user->apellido_paterno }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="form-group"><label for="createLugar">Lugar</label>
                        <select id="createLugar" name="createLugar" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($lugares as $lugar)
                                <option value="{{ $lugar->id }}">{{ $lugar->nombre }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="form-group"><label for="createFechaInicio">Fecha de Inicio</label><input type="date"
                            id="createFechaInicio" name="createFechaInicio" required></div>
                    {{-- <div class="form-group"><label for="createFechaFin">Fecha de Fin</label><input type="date"
                            id="createFechaFin" name="createFechaFin" required></div> --}}

                    <div class="form-group"><label for="createVacancies">Vacantes</label><input type="number"
                            id="createVacancies" name="createVacantes" required min="0"></div>

                    <div class="form-group"><label for="createStatus">Estado</label><select id="createStatus"
                            name="createEstado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select></div>
                </div>
                <div class="form-group form-group-full">
                    <label>Horarios de la Sección</label>
                    <div id="createScheduleContainer" class="schedule-container"></div>
                    <button type="button" id="addCreateScheduleBtn" class="btn btn-secondary"
                        style="margin-top: 1rem;">Agregar Horario</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Sección</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="editModalTitle">Editar Sección</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="editWorkshopForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-grid">

                    <div class="form-group"><label for="editPeriodo">Periodo</label>
                        <select id="editPeriodo" name="editPeriodo" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($periodos as $periodo)
                                <option value="{{ $periodo->id }}"
                                    data-inicio="{{ $periodo->fecha_inicio ? $periodo->fecha_inicio->format('Y-m-d') : '' }}"
                                    data-fin="{{ $periodo->fecha_fin ? $periodo->fecha_fin->format('Y-m-d') : '' }}">
                                    {{ $periodo->anio }}-{{ $periodo->ciclo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label for="editTaller">Curso</label>
                        <select id="editTaller" name ="editTaller" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($cursos as $curso)
                             <option value="{{$curso->id}}">{{$curso->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label for="editNombre">Nombre de la Sección</label><input type="text"
                            id="editNombre" name="editNombre" required></div>

                    <div class="form-group"><label for="editTeacher">Docente</label>
                        <select id="editTeacher" name="editDocente" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($docentes as $docente)
                                <option value="{{ $docente->user_id }}">
                                    {{ $docente->user->nombres . ' ' . $docente->user->apellido_paterno }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="form-group"><label for="editLugar">Lugar</label>
                        <select id="editLugar" name="editLugar" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($lugares as $lugar)
                                <option value="{{ $lugar->id }}">{{ $lugar->nombre }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="form-group"><label for="editFechaInicio">Fecha de Inicio</label><input type="date"
                            id="editFechaInicio" name="editFechaInicio" required></div>
                    {{-- <div class="form-group"><label for="editFechaFin">Fecha de Fin</label><input type="date"
                            id="editFechaFin" name="editFechaFin" required></div> --}}

                    <div class="form-group"><label for="editVacancies">Vacantes</label><input type="number"
                            id="editVacancies" name="editVacantes" required min="0"></div>

                    <div class="form-group"><label for="editStatus">Estado</label><select id="editStatus"
                            name="editEstado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select></div>
                </div>
                <div class="form-group form-group-full">
                    <label>Horarios de la Sección</label>
                    <div id="editScheduleContainer" class="schedule-container"></div>
                    <button type="button" id="addEditScheduleBtn" class="btn btn-secondary"
                        style="margin-top: 1rem;">Agregar Horario</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Sección</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteAlertModal" class="modal">
        <div class="modal-content" style="max-width: 450px;">
            <div class="modal-header">
                <h2 class="warning">Acción no permitida</h2>
                <span class="close-icon">&times;</span>
            </div>
            <div class="modal-body">
                <p>Esta sección no se puede eliminar porque tiene alumnos matriculados.</p>
                <p>Para poder eliminarla, primero debe anular o transferir todas las matrículas asociadas a esta sección.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cancel-btn">Entendido</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ===================================================================
            // INICIO: FUNCIONES DE AYUDA (SIN CAMBIOS)
            // ===================================================================
            function openModal(modal) {
                if (!modal) return;
                document.body.classList.add('modal-open');
                modal.style.display = 'flex';
            }

            function closeModal(modal) {
                if (!modal) return;
                document.body.classList.remove('modal-open');
                modal.style.display = 'none';
            }

            // ... (resto de tus funciones de ayuda y createScheduleRow sin cambios) ...
            const diasSemana = ["LUNES", "MARTES", "MIÉRCOLES", "JUEVES", "VIERNES", "SÁBADO", "DOMINGO"];

            function createScheduleRow(id, dia = '', horaInicio = '', horaFin = '', namePrefix = 'create') {
                const row = document.createElement('div');
                row.className = 'schedule-row';
                if (id) {
                    row.innerHTML += `<input type="hidden" name="idHorario[]" value="${id}">`;
                }
                const diaOptions = diasSemana.map(d =>
                    `<option value="${d}" ${d === dia ? 'selected' : ''}>${d.charAt(0).toUpperCase() + d.slice(1).toLowerCase()}</option>`
                ).join('');
                row.innerHTML += `
                    <div class="form-group"><label>Día</label><select name="${namePrefix}Dias[]" required><option value="">Seleccione...</option>${diaOptions}</select></div>
                    <div class="form-group"><label>Hora Inicio</label><input type="time" name="${namePrefix}HoraInicio[]" value="${horaInicio}" required></div>
                    <div class="form-group"><label>Hora Fin</label><input type="time" name="${namePrefix}HoraFin[]" value="${horaFin}" required></div>
                    <button type="button" class="btn btn-danger remove-schedule-btn">&times;</button>
                `;
                row.querySelector('.remove-schedule-btn').onclick = () => row.remove();
                return row;
            }

            // --- Lógica para el modal de CREAR (SIN CAMBIOS) ---
            const createModal = document.getElementById('createWorkshopModal');
            const createForm = document.getElementById('createWorkshopForm');
            const createContainer = document.getElementById('createScheduleContainer');
            const createPeriodoSelect = document.getElementById('createPeriodo');
            const createFechaInicioInput = document.getElementById('createFechaInicio');
            const createFechaFinInput = document.getElementById('createFechaFin');

            document.getElementById('openCreateModalBtn')?.addEventListener('click', () => {
                createForm?.reset();
                if (createContainer) createContainer.innerHTML = '';
                createContainer?.appendChild(createScheduleRow(null, '', '', '', 'create'));
                openModal(createModal);
            });
            document.getElementById('addCreateScheduleBtn')?.addEventListener('click', () => {
                createContainer?.appendChild(createScheduleRow(null, '', '', '', 'create'));
            });
            createPeriodoSelect?.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (createFechaInicioInput) createFechaInicioInput.value = selectedOption.dataset.inicio ||
                    '';
                if (createFechaFinInput) createFechaFinInput.value = selectedOption.dataset.fin || '';
            });


            // --- Lógica para el modal de EDITAR ---
            const editModal = document.getElementById('editWorkshopModal');
            const editForm = document.getElementById('editWorkshopForm');
            const editContainer = document.getElementById('editScheduleContainer');
            const editPeriodoSelect = document.getElementById('editPeriodo');
            const editFechaInicioInput = document.getElementById('editFechaInicio');
            // const editFechaFinInput = document.getElementById('editFechaFin');

            document.getElementById('addEditScheduleBtn')?.addEventListener('click', () => {
                editContainer?.appendChild(createScheduleRow(null, '', '', '', 'edit'));
            });

            // Listener para cuando el usuario CAMBIA el periodo en el modal de edición
            editPeriodoSelect?.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (editFechaInicioInput) editFechaInicioInput.value = selectedOption.dataset.inicio || '';
                if (editFechaFinInput) editFechaFinInput.value = selectedOption.dataset.fin || '';
            });

            // ===================================================================
            // INICIO: CORRECCIÓN EN EL EVENT LISTENER DE EDICIÓN
            // ===================================================================
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const btnData = this.dataset;

                    document.getElementById('editModalTitle').textContent =
                        `Editar Sección: ${btnData.nombre}`;

                    // --- PASO 1: Llenar todos los campos con los datos del botón ---
                    document.getElementById('editPeriodo').value = btnData.periodo;
                    document.getElementById('editTaller').value = btnData.taller;
                    document.getElementById('editNombre').value = btnData.nombre;
                    document.getElementById('editTeacher').value = btnData.docente;
                    // document.getElementById('editLugar').value = btnData.lugar;
                    document.getElementById('editVacancies').value = btnData.vacantes;
                    document.getElementById('editStatus').value = btnData.activo;

                    // --- PASO 2 (LA CORRECCIÓN): Establecer las fechas ESPECÍFICAS de la sección ---
                    // Esto se hace DESPUÉS de establecer el periodo, para sobrescribir
                    // las fechas por defecto que el evento 'change' del periodo podría haber puesto.
                    document.getElementById('editFechaInicio').value = btnData.fechaInicio;
                    document.getElementById('editFechaFin').value = btnData.fechaFin;

                    // --- PASO 3: Llenar los horarios ---
                    if (editContainer) editContainer.innerHTML = '';
                    try {
                        const arrayHorarios = JSON.parse(btnData.horarios);
                        if (Array.isArray(arrayHorarios) && arrayHorarios.length > 0) {
                            arrayHorarios.forEach(horario => {
                                editContainer.appendChild(createScheduleRow(horario.id,
                                    horario.dia_semana, horario.hora_inicio, horario
                                    .hora_fin, 'edit'));
                            });
                        } else {
                            editContainer.appendChild(createScheduleRow(null, '', '', '', 'edit'));
                        }
                    } catch (e) {
                        console.error("Error al procesar horarios:", e);
                        editContainer.appendChild(createScheduleRow(null, '', '', '', 'edit'));
                    }

                    if (editForm) editForm.action = `{{ url('portal/secciones') }}/${btnData.id}`;

                    openModal(editModal);
                });
            });
            // ===================================================================
            // FIN: CORRECCIÓN
            // ===================================================================


            // --- Lógica de Cierre de Modales (SIN CAMBIOS) ---
            document.querySelectorAll('.modal').forEach(modal => {
                const closeButton = modal.querySelector('.close-icon');
                const cancelButton = modal.querySelector('.cancel-btn');
                const okButton = modal.querySelector('.ok-btn');

                closeButton?.addEventListener('click', () => closeModal(modal));
                cancelButton?.addEventListener('click', () => closeModal(modal));
                okButton?.addEventListener('click', () => closeModal(modal));

                let mouseDownInside = false;
                const content = modal.querySelector('.modal-content');
                content?.addEventListener('mousedown', () => {
                    mouseDownInside = true;
                });
                modal.addEventListener('mouseup', (e) => {
                    if (!mouseDownInside && e.target === modal) {
                        closeModal(modal);
                    }
                    mouseDownInside = false;
                });
            });
        });
    </script>
@endpush
