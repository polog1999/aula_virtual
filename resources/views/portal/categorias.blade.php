@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/talleres.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paginacion-buscador.css') }}">
@endpush
@section('vista', 'Categorías')

@section('content')
    <div class="content">
        <div id="dashboard-view">
            <h1>Gestión de Categorías</h1>

            <div class="table-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3>Listado de Categorías</h3>
                    <button class="btn btn-primary" id="openCreateModalBtn">Crear Nueva Categoría</button>
                </div>
                <form method="GET" action="{{ route('portal.categorias.index') }}" class="search-bar">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar categoría..."
                        class="form-control w-25 d-inline">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
                
                <div style="width: 100%;overflow: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Descripción de la Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorias as $i => $categoria)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        {{$categoria->nombre}}
                                    </td>
                                    <td>
                                        <button class="btn btn-primary edit-btn" data-id="{{ $categoria->id }}"
                                            data-nombre={{$categoria->nombre}}>
                                            {{-- data-edad-min="{{ $categoria->edad_min }}"
                                            data-edad-max="{{ $categoria->edad_max }}"
                                            data-discapacidad="{{ $categoria->tiene_discapacidad ? '1' : '0' }}"> --}}
                                            Editar
                                        </button>
                                        <form class="delete-form"
                                            action="{{ route('portal.categorias.destroy', $categoria) }}" method="POST"
                                            style="display:inline;">
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
                {{ $categorias->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Modal para CREAR Categoría -->
    <div id="createWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Crear Nueva Categoría</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="createWorkshopForm" action="{{ route('portal.categorias.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    {{-- <div class="form-group full-width" style="border-bottom: 1px solid #eee; padding-bottom: 1rem;">
                        <label>Tipo de Categoría</label>
                        <div style="display: flex; gap: 2rem;">
                            <label><input type="radio" name="tipo_categoria" value="edad" checked> Por Rango de
                                Edad</label> --}}
                            {{-- <label><input type="radio" name="tipo_categoria" value="discapacidad"> Para
                                Discapacidad</label>
                            <label><input type="radio" name="tipo_categoria" value="todas_edades"> Todas las
                                edades</label> --}}
                        {{-- </div>
                    </div> --}}

                    <div id="create-edad-fields">
                        <div class="form-group">
                            <label for="createNombre">Nombre</label>
                            <input type="text" id="createNombre" name="createNombre" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="createEdadMinima">Edad Mínima</label>
                            <input type="number" id="createEdadMinima" name="createEdadMinima" min="1"
                                max="99" required>
                        </div>
                        <div class="form-group">
                            <label for="createEdadMaxima">Edad Máxima (Opcional)</label>
                            <input type="number" id="createEdadMaxima" name="createEdadMaxima" min="1"
                                max="99">
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Categoría</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para EDITAR Categoría -->
    <div id="editWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="editModalTitle">Editar Categoría</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="editWorkshopForm" method="POST">
                @csrf
                @method('PUT')
                {{-- <div class="form-grid">
                    <div class="form-group full-width" style="border-bottom: 1px solid #eee; padding-bottom: 1rem;">
                        <label>Tipo de Categoría</label>
                        <div style="display: flex; gap: 2rem;">
                            <label><input type="radio" name="edit_tipo_categoria" value="edad" checked> Por Rango de
                                Edad</label> --}}
                            {{-- <label><input type="radio" name="edit_tipo_categoria" value="discapacidad"> Para
                                Discapacidad</label>
                            <label><input type="radio" name="edit_tipo_categoria" value="todas_edades"> Todas las
                                edades</label> --}}

                        {{-- </div>
                    </div> --}}

                    <div id="edit-edad-fields">
                        <div class="form-group">
                            <label for="editNombre">Nombre</label>
                            <input type="text" id="editNombre" name="editNombre"
                                required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="editEdadMinima">Edad Mínima</label>
                            <input type="number" id="editEdadMinima" name="editEdadMinima" min="1" max="99"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="editEdadMaxima">Edad Máxima (Opcional)</label>
                            <input type="number" id="editEdadMaxima" name="editEdadMaxima" min="1" max="99">
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- FUNCIONES GLOBALES DE MODAL (SIN CAMBIOS) ---
            function openModal(modal) {
                if (modal) modal.style.display = 'flex';
            }

            function closeModal(modal) {
                if (modal) modal.style.display = 'none';
            }

            // --- LÓGICA PARA EL MODAL DE CREACIÓN ---
            const createModal = document.getElementById('createWorkshopModal');
            const createForm = document.getElementById('createWorkshopForm');
            const createEdadFields = document.getElementById('create-edad-fields');

            document.getElementById('openCreateModalBtn')?.addEventListener('click', () => {
                createForm?.reset();
                createEdadFields.style.display = 'grid'; // Estado por defecto
                openModal(createModal);
            });

            createForm.querySelectorAll('input[name="tipo_categoria"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'edad') {
                        createEdadFields.style.display = 'grid';
                        createEdadFields.querySelectorAll('input').forEach(input => input.disabled =
                            false);
                    } else { // discapacidad
                        createEdadFields.style.display = 'none';
                        createEdadFields.querySelectorAll('input').forEach(input => input.disabled =
                            true);
                    }
                });
            });

            // --- LÓGICA PARA EL MODAL DE EDICIÓN ---
            const editModal = document.getElementById('editWorkshopModal');
            const editForm = document.getElementById('editWorkshopForm');
            const editModalTitle = document.getElementById('editModalTitle');
            const editEdadFields = document.getElementById('edit-edad-fields');

            editForm.querySelectorAll('input[name="edit_tipo_categoria"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'edad') {
                        editEdadFields.style.display = 'grid';
                        editEdadFields.querySelectorAll('input').forEach(input => input.disabled =
                            false);
                    } else { // discapacidad
                        editEdadFields.style.display = 'none';
                        editEdadFields.querySelectorAll('input').forEach(input => input.disabled =
                            true);
                    }
                });
            });

            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nombre = this.dataset.nombre;
                    // const edadMin = this.dataset.edadMin;
                    // const edadMax = this.dataset.edadMax;
                    // const esDiscapacidad = this.dataset.discapacidad === '1';

                    editModalTitle.textContent = `Editar Categoría #${id}`;

                    // if (esDiscapacidad) {
                    //     editForm.querySelector('input[value="discapacidad"]').checked = true;
                    //     editEdadFields.style.display = 'none';
                    //     editEdadFields.querySelectorAll('input').forEach(input => input.disabled =
                    //         true);
                    // } else {
                    //     editForm.querySelector('input[value="edad"]').checked = true;
                    //     editEdadFields.style.display = 'grid';
                    //     editEdadFields.querySelectorAll('input').forEach(input => input.disabled =
                    //         false);
                    // }

                    // document.getElementById('editEdadMinima').value = edadMin;
                    // document.getElementById('editEdadMaxima').value = edadMax;
                    document.getElementById('editNombre').value = nombre;

                    if (editForm) editForm.action = `{{ url('portal/categorias') }}/${id}`;

                    openModal(editModal);
                });
            });

            // --- LÓGICA PARA CERRAR TODOS LOS MODALES (SIN CAMBIOS) ---
            document.querySelectorAll('.modal').forEach(modal => {
                const closeButton = modal.querySelector('.close-icon');
                const cancelButton = modal.querySelector('.cancel-btn');
                closeButton?.addEventListener('click', () => closeModal(modal));
                cancelButton?.addEventListener('click', () => closeModal(modal));
                // ... (resto de tu lógica de cierre)
            });
        });
    </script>
@endpush
</body>

</html>
