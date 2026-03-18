@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paginacion-buscador.css') }}">
@endpush
@section('vista', 'Usuarios')

@section('content')
    <div class="content">
        <div id="dashboard-view">
            <h1>Gestión de usuarios</h1>

            <div class="table-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3>Lista de usuarios</h3>
                    <button class="btn btn-primary" id="openCreateModalBtn">Crear Nuevo Usuario</button>
                </div>

                <form method="GET" action="{{ route('portal.users.index') }}" class="search-bar">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar usuario..."
                        class="form-control w-25 d-inline">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>

                <div style="width:100%; overflow: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Email</th>
                                <th>Tipo Documento</th>
                                <th>Número de documento</th>
                                <th>Estado</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->nombres . ' ' . $user->apellido_paterno . ' ' . $user->apellido_materno }}
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->tipo_documento }}</td>
                                    <td>{{ $user->numero_documento }}</td>
                                    <td>{{ $user->activo ? 'Activo' : 'Inactivo' }}</td>
                                    <td>{{ $user->role }}</td>

                                    <td style="white-space: nowrap;">
                                        <button class="btn btn-primary edit-btn" data-id="{{ $user->id }}"
                                            data-roles={{ $user->getRoleNames() }}>Editar</button>

                                        <form class="delete-form" action="{{ route('portal.users.destroy', $user->id) }}"
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
    <!-- Modal para CREAR Usuario -->
    <div id="createWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Crear Nuevo Usuario</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="createWorkshopForm" action="{{ route('portal.users.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group"><label for="createNombre">Nombre</label><input type="text" id="createNombre"
                            name="createNombre" required></div>
                    <div class="form-group"><label for="createApPaterno">Apellido Paterno</label><input type="text"
                            id="createApPaterno" name="createApPaterno"></div>
                    <div class="form-group"><label for="createApMaterno">Apellido Materno</label><input type="text"
                            id="createApMaterno" name="createApMaterno"></div>
                    <div class="form-group"><label for="createTipo">Tipo de documento</label><select id="createTipo"
                            name="createTipo" required>
                            <option value="">Seleccionar...</option>
                            <option value="DNI">DNI</option>
                            <option value="CE">CE</option>
                        </select></div>
                    <div class="form-group"><label for="createDocumento">Numero de documento</label><input type="text"
                            id="createDocumento" name="createDocumento" required pattern="[0-9]{8}" maxlength="8"></div>
                    <div class="form-group"><label for="createEmail">Email</label><input type="email" id="createEmail"
                            name="createEmail" required></div>

                    {{-- CAMBIO: Añadido Checkboxes para Roles --}}
                    <div class="form-group full-width">
                        <label>Roles</label>
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            @foreach($all_roles as $role)
                            <label style="font-weight: normal;"><input type="checkbox" name="roles[]" value="{{$role->name}}">
                                {{$role->name}}</label>
                            @endforeach
                            {{-- <label style="font-weight: normal;"><input type="checkbox" name="roles[]" value="ADMIN">
                                Administrador</label>
                            <label style="font-weight: normal;"><input type="checkbox" name="roles[]" value="DOCENTE">
                                Docente</label>
                            <label style="font-weight: normal;"><input type="checkbox" name="roles[]" value="ALUMNO">
                                Alumno</label> --}}
                            {{-- Agrega más roles si es necesario --}}
                        </div>
                    </div>

                    <div class="form-group"><label for="createEstado">Estado</label><select id="createEstado"
                            name="createEstado" required>
                            <option value="">Seleccionar...</option>
                            <option value="1" selected>Activo</option>
                            <option value="0">Inactivo</option>
                        </select></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para EDITAR Usuario -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="editModalTitle">Editar Usuario</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="editWorkshopForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div class="form-group"><label for="editNombre">Nombre</label><input type="text" id="editNombre"
                            name="editNombre" required></div>
                    <div class="form-group"><label for="editApPaterno">Apellido Paterno</label><input type="text"
                            id="editApPaterno" name="editApPaterno"></div>
                    <div class="form-group"><label for="editApMaterno">Apellido Materno</label><input type="text"
                            id="editApMaterno" name="editApMaterno"></div>
                    <div class="form-group"><label for="editTipo">Tipo de documento</label><select id="editTipo"
                            name="editTipo" required>
                            <option value="">Seleccionar...</option>
                            <option value="DNI">DNI</option>
                            <option value="CE">CE</option>
                        </select></div>
                    <div class="form-group"><label for="editDocumento">Número de documento</label><input type="text"
                            id="editDocumento" name="editDocumento" required pattern="[0-9]{8}" maxlength="8"></div>
                    <div class="form-group"><label for="editEmail">Email</label><input type="email" id="editEmail"
                            name="editEmail" required></div>

                    {{-- CAMBIO: Añadido Checkboxes para Roles en Edición --}}
                    <div class="form-group full-width">
                        <label>Roles</label>
                        <div id="edit-roles-container" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            {{-- <label style="font-weight: normal;"><input type="checkbox" name="roles[]" value="admin">
                                Administrador</label>
                            <label style="font-weight: normal;"><input type="checkbox" name="roles[]" value="docente">
                                Docente</label>
                            <label style="font-weight: normal;"><input type="checkbox" name="roles[]" value="alumno">
                                Alumno</label>
                                @foreach($all_roles as $role) --}}
                                @foreach($all_roles as $role)
                            <label style="font-weight: normal;"><input type="checkbox" name="roles[]" value="{{$role->name}}">
                                {{$role->name}}</label>
                            @endforeach
                            {{-- Agrega más roles si es necesario --}}
                        </div>
                    </div>

                    <div class="form-group"><label for="editEstado">Estado</label><select id="editEstado"
                            name="editEstado" required>
                            <option value="">Seleccionar...</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
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

            const editModal = document.getElementById('editUserModal');
            const editForm = document.getElementById('editWorkshopForm');
            const createModal = document.getElementById('createWorkshopModal');

            $(document).on('click', '#openCreateModalBtn', function() {
                openModal(createModal);
            });

            $(document).on('click', '.edit-btn', function() {
                let userId = $(this).data('id');
                let userRoles = $(this).data('roles');


                $.get("{{ url('portal/usuarios') }}/" + userId + "/edit", function(data) {
                    $('#editNombre').val(data.nombres);
                    $('#editApPaterno').val(data.apellido_paterno);
                    $('#editApMaterno').val(data.apellido_materno);
                    $('#editTipo').val(data.tipo_documento);
                    $('#editDocumento').val(data.numero_documento);
                    $('#editEmail').val(data.email);
                    $('#editEstado').val(data.activo);

                    // 1. Limpiar todos los checkboxes primero
                    $('#edit-roles-container input[type="checkbox"]').prop('checked', false);

                    // 2. Marcar los que el usuario tiene
                    userRoles.forEach(role => {
                        $(`#edit-roles-container input[value="${role}"]`).prop('checked', true);
                    });

                    // 3. Ajustar el action del form
                    // $('#editUserForm').attr('action', `/admin/usuarios/${userId}`);
                    // --- INICIO: NUEVA LÓGICA PARA MARCAR CHECKBOXES ---
                    // 1. Desmarcar todos los checkboxes primero
                    // $('#edit-roles-container input[type="checkbox"]').prop('checked', false);

                    // 2. data.roles debe ser un array de los roles del usuario, ej: ['ADMIN', 'DOCENTE']
                    // if (data.roles && Array.isArray(data.roles)) {
                    //     data.roles.forEach(function(role) {
                    //         // 3. Marcar el checkbox cuyo valor coincida con el rol
                    //         $(`#edit-roles-container input[value="${role}"]`).prop(
                    //             'checked', true);
                    //     });
                    // } else if (data.role) { // Fallback por si solo viene un rol como string
                    //     $(`#edit-roles-container input[value="${data.role}"]`).prop('checked',
                    //     true);
                    // }
                    // --- FIN: NUEVA LÓGICA ---

                    if (editForm) editForm.action = '{{ url('portal/usuarios') }}/' + userId;

                    openModal(editModal);
                });
            });

            document.querySelectorAll('.modal').forEach(modal => {
                const closeButton = modal.querySelector('.close-icon');
                const cancelButton = modal.querySelector('.cancel-btn');
                closeButton?.addEventListener('click', () => closeModal(modal));
                cancelButton?.addEventListener('click', () => closeModal(modal));

                let mouseDownInside = false;
                const content = modal.querySelector('.modal-content');
                content.addEventListener('mousedown', () => {
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
