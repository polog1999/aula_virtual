@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/docentes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paginacion-buscador.css') }}">
@endpush
@section('vista', 'Docentes')

@section('content')
    <div class="content">
        <div id="dashboard-view">
            <h1>Gestión de docentes</h1>
            <div class="table-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3>Últimos docentes modificados</h3>
                    {{-- @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif --}}
                    {{-- <button class="btn btn-primary" id="openCreateModalBtn">Crear Nuevo Taller</button> --}}
                </div>
                <form method="GET" action="{{ route('portal.docentes.index') }}" class="search-bar">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar docente..."
                        class="form-control w-25 d-inline">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
                <div style="width: 100%;overflow: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Docente</th>
                                <th>Talleres</th>
                                {{-- <th>Vacantes</th>
                            <th>Estado</th> --}}
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>

                                    <td>{{ $user->nombres . ' ' . $user->apellido_paterno . ' ' . $user->apellido_materno }}
                                    </td>
                                    {{-- <td>{{ $user->docente->especialidad }} --}}
                                    <td>
                                        {{-- <td>{{$user->docente->taller}} --}}

                                        @if ($user->docente != null)
                                            @foreach ($user->docente->secciones as $i => $s)
                                                {{-- {{ $s->talleres->disciplina->nombre }} ({{$s->talleres->categoria->nombre}}){{ $loop->last ? '' : ' | ' }} --}}
                                                {{-- {{ $s->talleres->disciplina->nombre }}
                                                ({{ $s->nombre }}) --}}
                                                {{ $s->curso->nombre }} -
                                                {{ $s->nombre }}
                                                @php
                                                    $categoria = $s->curso->categoria;
                                                @endphp
                                              
                                                
                                            {{ $loop->last ? '' : ' | ' }}
                                        @endforeach
                            @endif

                            </td>

                            <td style="white-space: nowrap;">
                                <button class="btn btn-primary edit-btn" data-bs-toggle="modal"
                                    data-bs-target="#editTallerModal" data-id="{{ $user->id }}"
                                    data-nombre="{{ $user->nombres }}"
                                    data-apellido-paterno="{{ $user->apellido_paterno }}"
                                    data-apellido-materno="{{ $user->apellido_materno }}"
                                    data-tipo-documento ="{{ $user->tipo_documento }}"
                                    data-numero-documento = "{{ $user->numero_documento }}">Editar</button>

                                <form class="delete-form" action="{{ route('portal.docentes.destroy', $user->id) }}"
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

                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Modal para EDITAR Docente -->
    <div id="editWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="editModalTitle">Editar Docente</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="editWorkshopForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editDocenteId" name="editDocenteid">
                <div class="form-grid">
                    <div class="form-group"><label for="editNombre">Nombre</label><input type="text" id="editNombre"
                            name="editNombre" required></div>
                    <div class="form-group"><label for="editApPaterno">Apellido Paterno</label><input type="text"
                            id="editApPaterno" name="editApPaterno" required></div>
                    <div class="form-group"><label for="editApMaterno">Apellido Materno</label><input type="text"
                            id="editApMaterno" name="editApMaterno" required></div>
                    <div class="form-group"><label for="editTipo">Tipo de documento</label><select id="editTipo"
                            name="editTipo" required>
                            <option value="">Seleccionar...</option>
                            <option value="DNI">DNI</option>
                            <option value="CE">CE</option>

                            {{-- @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach --}}
                        </select></div>
                    <div class="form-group"><label for="editDocumento">Número de documento</label><input type="text"
                            id="editDocumento" name="editDocumento" required></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Taller</button>
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


            const editModal = document.getElementById('editWorkshopModal');
            const editForm = document.getElementById('editWorkshopForm');
            const editModalTitle = document.getElementById('editModalTitle');

            document.body.addEventListener('click', function(event) {
                if (event.target.classList.contains('edit-btn')) {
                    const button = event.target;

                    // if (editModalTitle) editModalTitle.textContent =
                    //     `Editar Taller: ${button.dataset.nombre}`;
                    document.getElementById('editDocenteId').value = button.dataset.id;
                    document.getElementById('editNombre').value = button.dataset.nombre;
                    document.getElementById('editApPaterno').value = button.dataset.apellidoPaterno;
                    document.getElementById('editApMaterno').value = button.dataset.apellidoMaterno;
                    document.getElementById('editTipo').value = button.dataset.tipoDocumento;
                    document.getElementById('editDocumento').value = button.dataset.numeroDocumento;


                    if (editForm) editForm.action = '{{ url('portal/docentes') }}/' + button.dataset.id;

                    openModal(editModal);
                }

                // if (event.target.classList.contains('delete-btn')) {
                //     const deleteButton = event.target;
                //     const matriculasCount = parseInt(deleteButton.dataset.matriculas, 10);

                //     if (matriculasCount > 0) {
                //         event.preventDefault();
                //         const alertModal = document.getElementById('deleteAlertModal');
                //         openModal(alertModal);
                //     }
                // }
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
