@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/talleres.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paginacion-buscador.css') }}">
@endpush
@section('vista', 'Talleres')

@section('content')

    <div class="content">
        <div id="dashboard-view">
            <h1>Gestión de talleres</h1>

            <div class="table-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3>Últimos Talleres Creados</h3>
                    {{-- @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif --}}

                    <button class="btn btn-primary" id="openCreateModalBtn">Crear Nuevo Taller</button>
                </div>
                <form method="GET" action="{{ route('portal.talleres.index') }}" class="search-bar">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar taller..."
                        class="form-control w-25 d-inline">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>

                <div style="width: 100%;overflow: auto;">
                    <table>
                    <thead>
                        <tr>
                            <th>Deporte</th>

                            <th>Tarifa Vecino</th>
                            <th>Tarifa No Vecino</th>
                            <th>Duración</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($talleres as $taller)
                            @php
                                $categoria = $taller->categoria;
                            @endphp
                            <tr>
                                <td>{{ $taller->disciplina->nombre }} -
                                    @if ($categoria->edad_min != null && $categoria->edad_max == null)
                                        De {{ $categoria->edad_min }} años a más
                                    @elseif($categoria->edad_min != null && $categoria->edad_max != null)
                                        De {{ $categoria->edad_min }} a {{ $categoria->edad_max }} años
                                    @elseif($categoria->tiene_discapacidad)
                                        Con discapacidad
                                    @else
                                        Todas las edades
                                    @endif
                                </td>
                                <td> S/{{ $taller->costo_vecino}}</td>
                                <td> S/{{ $taller->costo_no_vecino}}</td>
                                <td>{{$taller->frecuencia_vecino}}</td>
                                {{-- <td>{{$taller->seccion->dia_semana}}</td> --}}
                                {{-- <td>{{ $taller->seccion->docentes ? $taller->seccion->docentes->user->nombres . ' ' . $taller->seccion->docentes->user->apellido_paterno . ' ' . $taller->seccion->docentes->user->apellido_materno : '' }} --}}

                                {{-- <td>{{$taller->seccion->vacantes }}</td> --}}
                                {{-- <td>{{ $taller->matriculas_activas_count }}/{{ $taller->vacantes }}</td> --}}
                                <td><span
                                        class="status-badge status-{{ $taller->activo ? 'active' : 'inactive' }}">{{ $taller->activo ? 'Activo' : 'Inactivo' }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary edit-btn" data-bs-toggle="modal"
                                        data-bs-target="#editTallerModal" data-id="{{ $taller->id }}"
                                        {{-- data-nombre="{{ $taller->nombre }}" --}} data-nombre="{{ $taller->disciplina->nombre }}"
                                        data-disciplina="{{ $taller->disciplina->id }}" {{-- data-vacantes="{{ $taller->seccion->vacantes }}" --}}
                                        {{-- data-costo-matricula="{{ $taller->costo_matricula }}" --}} data-costo-mensualidad="{{ $taller->costo_mensualidad }}"
                                        data-activo="{{ $taller->activo }}"
                                        data-serv-vecino="{{ $taller->grupoCodigoVecino?->grupo }}_{{ $taller->grupoCodigoVecino?->codigo }}"
                                        data-serv-no-vecino="{{ $taller->grupoCodigoNoVecino?->grupo }}_{{ $taller->grupoCodigoNoVecino?->codigo }}"
                                        data-categoria="{{ $taller->categoria ? $taller->categoria->id : '' }}"
                                        {{-- data-docente="{{ $taller->docente ? $taller->docente->user->id : '' }}"
                                        data-lugar="{{ $taller->lugar_id }}" --}} {{-- data-horarios=@json($taller->seccion->horarios) --}}>Editar</button>
                                    <form class="delete-form" action="{{ route('portal.talleres.delete', $taller->id) }}"
                                        method="POST" style="display:inline;">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger delete-btn" type="submit"
                                            data-matriculas="{{ $taller->matriculas_activas_count }}">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                {{ $talleres->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modals')
    <!-- Modal para CREAR Taller -->
    <div id="createWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Crear Nuevo Taller</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="createWorkshopForm" action="{{ route('portal.talleres.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    {{-- <div class="form-group"><label for="createNombre">Nombre</label><input type="text" id="createNombre"
                            name="createNombre" required></div> --}}
                    <div class="form-group"><label for="createDiscipline">Deporte</label>
                        <select id="createDiscipline" name="createDisciplina" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($disciplinas as $disciplina)
                                <option value="{{ $disciplina->id }}">{{ $disciplina->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label for="createCategory">Categoría</label>
                        <select id="createCategory" name="createCategoria" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">
                                    @if ($categoria->edad_min != null && $categoria->edad_max == null)
                                        De {{ $categoria->edad_min }} años a más
                                    @elseif($categoria->edad_min != null && $categoria->edad_max != null)
                                        De {{ $categoria->edad_min }} a {{ $categoria->edad_max }} años de
                                    @elseif($categoria->tiene_discapacidad)
                                        Para personas con discapacidad
                                    @else
                                        Todas las edades
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group"><label for="createCostoVecino">Servicio (Vecino)</label><select
                            id="createCostoVecino" name="createCostoVecino" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($tusnesVecino as $tusne)
                                <option value="{{ $tusne->congrupo }}_{{ $tusne->concodigo }}">{{ $tusne->condescrip }}
                                </option>
                            @endforeach

                        </select></div>
                    <div class="form-group"><label for="createCostoNoVecino">Servicio (No vecino)</label><select
                            id="createCostoNoVecino" name="createCostoNoVecino" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($tusnesNoVecino as $tusne)
                                <option value="{{ $tusne->congrupo }}_{{ $tusne->concodigo }}">{{ $tusne->condescrip }}
                                </option>
                            @endforeach

                        </select></div>
                    {{-- <div class="form-group"><label for="createMonthlyFee">Mensualidad (S/)</label><input type="number"
                            step="0.01" id="createMonthlyFee" name="createMensualidad" min="0" required></div> --}}
                    <div class="form-group"><label for="createStatus">Estado</label><select id="createStatus"
                            name="createEstado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select></div>
                </div>
                {{-- <div class="form-group form-group-full">
                    <label>Horarios del Taller</label>
                    <div id="createScheduleContainer" class="schedule-container"></div>
                    <button type="button" id="addCreateScheduleBtn" class="btn btn-secondary"
                        style="margin-top: 1rem;">Agregar Horario</button>
                </div> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Taller</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para EDITAR Taller -->
    <div id="editWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="editModalTitle">Editar Taller</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="editWorkshopForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editWorkshopId" name="id">
                <div class="form-grid">
                    {{-- <div class="form-group"><label for="editNombre">Nombre</label><input type="text" id="editNombre"
                            name="editNombre" required></div> --}}
                    <div class="form-group"><label for="editDiscipline">Deporte</label>
                        <select id="editDiscipline" name ="editDisciplina" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($disciplinas as $disciplina)
                                <option value="{{ $disciplina->id }}">{{ $disciplina->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label for="editCategory">Categoría</label><select id="editCategory"
                            name="editCategoria" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">
                                    @if ($categoria->edad_min != null && $categoria->edad_max == null)
                                        De {{ $categoria->edad_min }} años a más
                                    @elseif($categoria->edad_min != null && $categoria->edad_max != null)
                                        De {{ $categoria->edad_min }} a {{ $categoria->edad_max }} años de
                                    @elseif($categoria->tiene_discapacidad)
                                        Para personas con discapacidad
                                    @else
                                        Todas las edades
                                    @endif
                                </option>
                            @endforeach
                        </select></div>

                    {{-- <div class="form-group"><label for="editTeacher">Docente</label>
                        <select id="editTeacher" name="editDocente" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($docentes as $docente)
                                <option value="{{ $docente->user->id }}">
                                    {{ $docente->user->nombres . ' ' . $docente->user->apellido_paterno . ' ' . $docente->user->apellido_materno }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label for="editLugar">Lugar</label>
                        <select id="editLugar" name="editLugar" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($lugares as $lugar)
                                <option value="{{ $lugar->id }}">{{ $lugar->nombre }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    {{-- <div class="form-group"><label for="editVacancies">Vacantes</label><input type="number"
                            id="editVacancies" name="editVacantes" required min="0"></div> --}}
                    {{-- <div class="form-group"><label for="editCost">Costo Matrícula (S/)</label><input type="number"
                            step="0.01" id="editCost" name="editMatricula" required min="0"></div> --}}
                    {{-- <div class="form-group"><label for="editMonthlyFee">Mensualidad (S/)</label><input type="number"
                            step="0.01" id="editMonthlyFee" name="editMensualidad" min="0"></div> --}}
                    <div class="form-group"><label for="editCostoVecino">Servicio (Vecino)</label><select
                            id="editCostoVecino" name="editCostoVecino" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($tusnesVecino as $tusne)
                                <option value="{{ $tusne->congrupo }}_{{ $tusne->concodigo }}">{{ $tusne->condescrip }}
                                </option>
                            @endforeach

                        </select></div>
                    <div class="form-group"><label for="editCostoNoVecino">Servicio (No Vecino)</label><select
                            id="editCostoNoVecino" name="editCostoNoVecino" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($tusnesNoVecino as $tusne)
                                <option value="{{ $tusne->congrupo }}_{{ $tusne->concodigo }}">{{ $tusne->condescrip }}
                                </option>
                            @endforeach
                        </select></div>
                    <div class="form-group"><label for="editStatus">Estado</label><select id="editStatus"
                            name="editEstado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select></div>
                </div>
                {{-- <div class="form-group form-group-full">
                    <label>Horarios del Taller</label>
                    <div id="editScheduleContainer" class="schedule-container"></div>
                    <button type="button" id="addEditScheduleBtn" class="btn btn-secondary"
                        style="margin-top: 1rem;">Agregar Horario</button>
                </div> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Taller</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de ALERTA para ELIMINAR Taller -->
    {{-- <div id="deleteAlertModal" class="modal">
        <div class="modal-content" style="max-width: 450px;">
            <div class="modal-header">
                <h2 class="warning">Acción no permitida</h2>
                <span class="close-icon">&times;</span>
            </div>
            <div class="modal-body">
                <p>Este taller no se puede eliminar porque tiene alumnos matriculados.</p>
                <p>Para poder eliminarlo, primero debe anular o transferir todas las matrículas asociadas a este taller.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary ok-btn">Entendido</button>
            </div>
        </div>
    </div> --}}
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // const menuToggle = document.getElementById('menu-toggle');
            // const sidebar = document.getElementById('sidebar');
            // if (menuToggle) {
            //     menuToggle.addEventListener('click', () => sidebar.classList.toggle('open'));
            // }

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

            const diasSemana = ["LUNES", "MARTES", "MIÉRCOLES", "JUEVES", "VIERNES", "SÁBADO", "DOMINGO"];

            function createScheduleRow(id, dia = '', horaInicio = '', horaFin = '', namePrefix = 'create') {
                const row = document.createElement('div');
                row.className = 'schedule-row';

                if (id !== null && id !== undefined && id !== '') {
                    const idForm = document.createElement('input');
                    idForm.type = 'hidden';
                    idForm.name = 'idHorario[]';
                    idForm.value = id;
                    row.appendChild(idForm);
                }

                const diaFormGroup = document.createElement('div');
                diaFormGroup.className = 'form-group';
                diaFormGroup.innerHTML =
                    `<label>Día</label><select name="${namePrefix}Dias[]" required><option value="">Seleccione día...</option>${diasSemana.map(d => `<option value="${d}">${d.charAt(0).toUpperCase() + d.slice(1).toLowerCase()}</option>`).join('')}</select>`;

                const inicioFormGroup = document.createElement('div');
                inicioFormGroup.className = 'form-group';
                inicioFormGroup.innerHTML =
                    `<label>Hora Inicio</label><input type="time" name="${namePrefix}HoraInicio[]" required>`;

                const finFormGroup = document.createElement('div');
                finFormGroup.className = 'form-group';
                finFormGroup.innerHTML =
                    `<label>Hora Fin</label><input type="time" name="${namePrefix}HoraFin[]" required>`;

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger remove-schedule-btn';
                removeBtn.innerHTML = '&times;';
                removeBtn.onclick = () => row.remove();

                row.appendChild(diaFormGroup);
                row.appendChild(inicioFormGroup);
                row.appendChild(finFormGroup);
                row.appendChild(removeBtn);

                if (dia) diaFormGroup.querySelector('select').value = dia;
                if (horaInicio) inicioFormGroup.querySelector('input').value = horaInicio;
                if (horaFin) finFormGroup.querySelector('input').value = horaFin;

                return row;
            }

            const createContainer = document.getElementById('createScheduleContainer');
            document.getElementById('addCreateScheduleBtn')?.addEventListener('click', () => {
                createContainer.appendChild(createScheduleRow(null, '', '', '', 'create'));
            });

            const editContainer = document.getElementById('editScheduleContainer');
            document.getElementById('addEditScheduleBtn')?.addEventListener('click', () => {
                editContainer.appendChild(createScheduleRow(null, '', '', '', 'edit'));
            });

            const createModal = document.getElementById('createWorkshopModal');
            const createForm = document.getElementById('createWorkshopForm');
            document.getElementById('openCreateModalBtn')?.addEventListener('click', () => {
                createForm?.reset();
                if (createContainer) createContainer.innerHTML = '';
                createContainer?.appendChild(createScheduleRow(null, '', '', '', 'create'));
                openModal(createModal);
            });

            const editModal = document.getElementById('editWorkshopModal');
            const editForm = document.getElementById('editWorkshopForm');
            const editModalTitle = document.getElementById('editModalTitle');


            document.body.addEventListener('click', function(event) {
                if (event.target.classList.contains('edit-btn')) {
                    const button = event.target;

                    if (editModalTitle) editModalTitle.textContent =
                        `Editar Taller: ${button.dataset.nombre}`;
                    document.getElementById('editWorkshopId').value = button.dataset.id;
                    // document.getElementById('editNombre').value = button.dataset.nombre;
                    document.getElementById('editDiscipline').value = button.dataset.disciplina;
                    // console.log(button.dataset.servNoVecino);
                    document.getElementById('editCostoVecino').value = button.dataset.servVecino;
                    document.getElementById('editCostoNoVecino').value = button.dataset.servNoVecino;
                    // document.getElementById('editVacancies').value = button.dataset.vacantes;
                    //document.getElementById('editCost').value = button.dataset.costoMatricula;
                    // document.getElementById('editMonthlyFee').value = button.dataset.costoMensualidad;
                    document.getElementById('editStatus').value = button.dataset.activo;
                    document.getElementById('editCategory').value = button.dataset.categoria;
                    // document.getElementById('editTeacher').value = button.dataset.docente;
                    // document.getElementById('editLugar').value = button.dataset.lugar;

                    if (editContainer) editContainer.innerHTML = '';
                    try {
                        const arrayHorarios = JSON.parse(button.dataset.horarios);
                        if (Array.isArray(arrayHorarios) && arrayHorarios.length > 0) {
                            arrayHorarios.forEach(horario => {
                                editContainer?.appendChild(createScheduleRow(horario.id, horario
                                    .dia_semana, horario.hora_inicio, horario.hora_fin,
                                    'edit'));
                            });
                        } else {
                            editContainer?.appendChild(createScheduleRow(null, '', '', '', 'edit'));
                        }
                    } catch (e) {
                        editContainer?.appendChild(createScheduleRow(null, '', '', '', 'edit'));
                    }

                    if (editForm) editForm.action = '{{ url('portal/talleres') }}/' + button.dataset.id;

                    openModal(editModal);
                }

                if (event.target.classList.contains('delete-btn')) {
                    const deleteButton = event.target;
                    const matriculasCount = parseInt(deleteButton.dataset.matriculas, 10);

                    if (matriculasCount > 0) {
                        event.preventDefault();
                        const alertModal = document.getElementById('deleteAlertModal');
                        openModal(alertModal);
                    }
                }
            });

            document.querySelectorAll('.modal').forEach(modal => {
                const closeButton = modal.querySelector('.close-icon');
                const cancelButton = modal.querySelector('.cancel-btn');
                const okButton = modal.querySelector('.ok-btn');

                closeButton?.addEventListener('click', () => closeModal(modal));
                cancelButton?.addEventListener('click', () => closeModal(modal));
                okButton?.addEventListener('click', () => closeModal(modal));

                // modal.addEventListener('click', (e) => {
                //     if (e.target === modal) closeModal(modal);
                // });
                let mouseDownInside = false;

                document.querySelectorAll('.modal').forEach(modal => {
                    const content = modal.querySelector('.modal-content');

                    content.addEventListener('mousedown', () => {
                        mouseDownInside = true;
                    });

                    modal.addEventListener('mouseup', (e) => {
                        // Solo cierra si el clic comenzó y terminó fuera del modal
                        if (!mouseDownInside && e.target === modal) {
                            closeModal(modal);
                        }
                        mouseDownInside = false;
                    });
                });
            });
        });
    </script>
@endpush
