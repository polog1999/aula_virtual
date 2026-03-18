@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/talleres.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paginacion-buscador.css') }}">
@endpush
@section('vista', 'Sedes')

@section('content')

    <div class="content">
        <div id="dashboard-view">
            <h1>Gestión de sedes</h1>

            <div class="table-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3>Últimos Sedes Creados</h3>
                    {{-- @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif --}}

                    <button class="btn btn-primary" id="openCreateModalBtn">Crear Nueva Sede</button>
                </div>
                <form method="GET" action="{{ route('portal.lugares.index') }}" class="search-bar">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar sede..."
                        class="form-control w-25 d-inline">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>

                <div style="width: 100%;overflow: auto;">
                    <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sede</th>
                            <th>Direccion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lugares as $i => $lugar)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $lugar->nombre }}</td>
                                <td>{{ $lugar->direccion }}</td>
                                {{-- <td>{{$taller->dia_semana}}</td>
                                <td>{{ $taller->docente ? $taller->docente->user->nombres . ' ' . $taller->docente->user->apellido_paterno . ' ' . $taller->docente->user->apellido_materno : '' }}
                                </td>
                                <td>{{ $taller->matriculas_activas_count }}/{{ $taller->vacantes }}</td>
                                <td><span
                                        class="status-badge status-{{ $taller->activo ? 'active' : 'inactive' }}">{{ $taller->activo ? 'Activo' : 'Inactivo' }}</span>
                                </td> --}}
                                <td>
                                    <button class="btn btn-primary edit-btn" data-bs-toggle="modal"
                                        data-bs-target="#editWorkshopModal" data-id="{{ $lugar->id }}"
                                        data-nombre="{{ $lugar->nombre }}"
                                        data-direccion="{{ $lugar->direccion }}"
                                        data-link-maps = "{{$lugar->link_maps}}"
                                        >Editar</button>
                                    <form class="delete-form" action="{{ route('portal.lugares.destroy', $lugar) }}"
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
                {{ $lugares->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modals')
    <!-- Modal para CREAR Taller -->
    <div id="createWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Crear Nueva Sede</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="createWorkshopForm" action="{{ route('portal.lugares.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group"><label for="createNombre">Nombre</label><input type="text" id="createNombre"
                            name="createNombre" required>
                    </div>
                    <div class="form-group"><label for="createDireccion">Direccion</label><input type="text"
                            id="createDireccion" name="createDireccion" required>
                    </div>

                    <div class="form-group"><label for="createLinkMaps">Link del mapa (Google Maps)</label><input
                            type="text" id="createLinkMaps" name="createLinkMaps" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Sede</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para EDITAR Taller -->
    <div id="editWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="editModalTitle">Editar Sede</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="editWorkshopForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editWorkshopId" name="id">
                <div class="form-grid">
                    <div class="form-group"><label for="editNombre">Nombre</label><input type="text" id="editNombre"
                            name="editNombre" required></div>

                    <div class="form-group"><label for="editDireccion">Direccion</label><input type="text"
                            id="editDireccion" name="editDireccion" required></div>

                    <div class="form-group"><label for="editLinkMaps">Link del mapa (Google Maps)</label><input
                            type="text" id="editLinkMaps" name="editLinkMaps" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Sede</button>
                    </div>
            </form>
        </div>
    </div>

    {{-- <!-- Modal de ALERTA para ELIMINAR Taller -->
    <div id="deleteAlertModal" class="modal">
        <div class="modal-content" style="max-width: 450px;">
            <div class="modal-header">
                <h2 class="warning">Acción no permitida</h2>
                <span class="close-icon">&times;</span>
            </div>
            <div class="modal-body">
                <p>Esta sede no se puede eliminar porque tiene una sección asociada.</p>
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
                        `Editar Categoria: ${button.dataset.nombre}`;
                    document.getElementById('editWorkshopId').value = button.dataset.id;
                    document.getElementById('editNombre').value = button.dataset.nombre;
                    document.getElementById('editDireccion').value = button.dataset.direccion;
                    document.getElementById('editLinkMaps').value = button.dataset.linkMaps;
                    //document.getElementById('editDiscipline').value = button.dataset.disciplina;
                    //document.getElementById('editVacancies').value = button.dataset.vacantes;
                    //document.getElementById('editCost').value = button.dataset.costoMatricula;
                    //document.getElementById('editMonthlyFee').value = button.dataset.costoMensualidad;
                    //document.getElementById('editStatus').value = button.dataset.activo;
                    //document.getElementById('editCategory').value = button.dataset.categoria;
                    //document.getElementById('editTeacher').value = button.dataset.docente;
                    //document.getElementById('editLugar').value = button.dataset.lugar;

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

                    if (editForm) editForm.action = '{{ url('portal/lugares') }}/' + button.dataset.id;

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
