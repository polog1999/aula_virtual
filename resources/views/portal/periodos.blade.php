@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/talleres.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paginacion-buscador.css') }}">
@endpush
@section('vista', 'Categorias')

@section('content')

    <div class="content">
        <div id="dashboard-view">
            <h1>Gestión de Periodos</h1>

            <div class="table-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3>Últimos Periodos creados</h3>
                    {{-- @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif --}}

                    <button class="btn btn-primary" id="openCreateModalBtn">Crear Nuevo Periodo</button>
                </div>
                <form method="GET" action="{{ route('portal.periodos.index') }}" class="search-bar">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar periodo..."
                        class="form-control w-25 d-inline">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>

                <div style="width: 100%;overflow: auto;">
                    <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Año</th>
                            <th>Ciclo</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            {{-- <th>Horario</th> --}}
                            {{-- <th>Docente</th>
                            <th>Vacantes</th>
                            <th>Estado</th> --}}
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($periodos as $i => $periodo)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $periodo->anio }}</td>
                                <td>{{ $periodo->ciclo }}</td>
                                <td>{{$periodo->fecha_inicio->format('d-m-Y')}}</td>
                                <td>{{$periodo->fecha_fin->format('d-m-Y')}}</td>
                                <td>
                                    <button class="btn btn-primary edit-btn" data-bs-toggle="modal"
                                        data-bs-target="#editWorkshopModal" data-id="{{ $periodo->id }}"
                                        data-nombre="{{ $periodo->ciclo }}" data-anio="{{ $periodo->anio }}"
                                        data-fecha-inicio = {{$periodo->fecha_inicio}}
                                        data-fecha-fin = {{$periodo->fecha_fin}}
                                        >Editar</button>
                                    <form class="delete-form" action="{{ route('portal.periodos.destroy', $periodo) }}"
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
                {{ $periodos->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modals')
    <!-- Modal para CREAR Taller -->
    <div id="createWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Crear Nuevo Periodo</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="createWorkshopForm" action="{{ route('portal.periodos.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group"><label for="createAnio">Año</label><input type="number" id="createAnio"
                            name="createAnio" min="1900" max="2100" pattern="[0-9]{4}" required>
                    </div>


                    <div class="form-group"><label for="createNombre">Ciclo</label><input type="text" id="createNombre"
                            name="createNombre" required>
                    </div>
                    <div class="form-group"><label for="createFechaInicio">Fecha de Inicio</label><input type="date"
                            id="createFechaInicio" name="createFechaInicio" required></div>
                    <div class="form-group"><label for="createFechaFin">Fecha de Fin</label><input type="date"
                            id="createFechaFin" name="createFechaFin" required></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Periodo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para EDITAR Taller -->
    <div id="editWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="editModalTitle">Editar Periodo</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="editWorkshopForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editWorkshopId" name="id">
                <div class="form-grid">
                    <div class="form-group"><label for="editAnio">Año</label><input type="number" id="editAnio"
                            name="editAnio" min="1900" max="2100" required></div>
                    <div class="form-group"><label for="editNombre">Ciclo</label><input type="text" id="editNombre"
                            name="editNombre" required></div>
                    <div class="form-group"><label for="editFechaInicio">Fecha de Inicio</label><input type="date"
                            id="editFechaInicio" name="editFechaInicio" required></div>
                    <div class="form-group"><label for="editFechaFin">Fecha de Fin</label><input type="date"
                            id="editFechaFin" name="editFechaFin" required></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Periodo</button>
                    </div>
            </form>
        </div>
    </div>

    <!-- Modal de ALERTA para ELIMINAR Taller -->
    <div id="deleteAlertModal" class="modal">
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
    </div>
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
                        `Editar Periodo: ${button.dataset.nombre}`;
                    document.getElementById('editWorkshopId').value = button.dataset.id;
                    document.getElementById('editNombre').value = button.dataset.nombre;
                    document.getElementById('editAnio').value = button.dataset.anio;
                    document.getElementById('editFechaInicio').value = button.dataset.fechaInicio;
                    document.getElementById('editFechaFin').value = button.dataset.fechaFin;

                    if (editForm) editForm.action = '{{ url('portal/periodos') }}/' + button.dataset.id;

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
