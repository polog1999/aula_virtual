<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <style>
        :root {
            --primary-color: #1E8449;
            --secondary-color: #2ECC71;
            --light-green: #D5F5E3;
            --dark-gray: #34495E;
            --light-gray: #ECF0F1;
            --white: #ffffff;
            --danger: #E74C3C;
        }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; margin: 0; background-color: var(--light-gray); color: var(--dark-gray); }
        body.modal-open { overflow: hidden; }
        .container-fluid { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: var(--dark-gray); color: var(--white); display: flex; flex-direction: column; transition: transform 0.3s ease; }
        .sidebar-header { padding: 1.5rem; text-align: center; background-color: rgba(0,0,0,0.2); }
        .sidebar-header h3 { margin: 0; font-size: 1.2rem; }
        .sidebar-nav { flex-grow: 1; list-style: none; padding: 0; margin: 0; }
        .sidebar-nav a { display: block; padding: 1rem 1.5rem; color: var(--light-gray); text-decoration: none; transition: background-color 0.2s ease; border-left: 4px solid transparent; cursor: pointer; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background-color: var(--primary-color); color: var(--white); border-left-color: var(--secondary-color); }
        .main-content { flex-grow: 1; display: flex; flex-direction: column; }
        .top-nav { background: var(--white); padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .menu-toggle { display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; }
        .user-profile { font-weight: bold; }
        .content { padding: 2rem; }
        
        /* Contenedores de Vistas */
        .view-container { display: none; }
        .view-container.active { display: block; }
        
        .dashboard-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .card { background: var(--white); padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        .card h4 { margin-top: 0; color: var(--primary-color); }
        .card .value { font-size: 2rem; font-weight: bold; }
        .card .description { color: #7f8c8d; }
        .table-container { background: var(--white); border-radius: 8px; padding: 1.5rem; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        .table-container h3, .table-container h1 { margin-top: 0; }
        .table-controls { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
        .table-controls input { padding: 0.6rem; border: 1px solid #ddd; border-radius: 5px; width: 300px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.8rem; text-align: left; border-bottom: 1px solid var(--light-gray); vertical-align: middle; }
        th { font-weight: bold; }
        .btn { padding: 0.6rem 1.2rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 0.9rem; margin-right: 5px;}
        .btn-primary { background-color: var(--primary-color); color: var(--white); }
        .btn-secondary { background-color: #7f8c8d; color: var(--white); }
        .btn-danger { background-color: var(--danger); color: var(--white); }
        .status-badge { padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.8rem; font-weight: bold; color: var(--white); }
        .status-active, .status-paid { background-color: var(--secondary-color); }
        .status-full, .status-pending { background-color: #E67E22; }
        .status-inactive, .status-retired, .status-cancelled { background-color: #95A5A6; }
        .profile-pic { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px; }

        /* Estilos del Modal */
        .modal {
            display: none; position: fixed; z-index: 1001; left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
            display: none; justify-content: center; align-items: flex-start;
            padding: 2rem 1rem;
        }
        .modal-content {
            background-color: var(--white); padding: 2rem; border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3); width: 90%; max-width: 600px;
            animation: fadeIn 0.3s; max-height: 88vh; overflow-y: auto;
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .modal-header h2 { margin: 0; color: var(--primary-color); }
        .close-icon { font-size: 2rem; color: #aaa; cursor: pointer; font-weight: bold; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group.full-width { grid-column: 1 / -1; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .form-group input[type="file"] { padding: 0.5rem; background-color: var(--light-gray); }
        .select-with-add { display: flex; align-items: center; gap: 10px; }
        .select-with-add select { flex-grow: 1; }
        #imagePreview { display: none; max-width: 150px; margin-top: 1rem; border-radius: 8px; border: 1px solid #ddd; padding: 5px; }
        .modal-footer { text-align: right; margin-top: 2rem; }
        @keyframes fadeIn { from {opacity: 0; transform: translateY(-20px);} to {opacity: 1; transform: translateY(0);} }

        @media (max-width: 768px) {
            .sidebar { position: fixed; left: 0; top: 0; height: 100%; transform: translateX(-100%); z-index: 1000; }
            .sidebar.open { transform: translateX(0); }
            .menu-toggle { display: block; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3></h3>
                <p>Admin Panel</p>
            </div>
            <ul class="sidebar-nav">
                <li><a data-view="dashboard" class="nav-link active" href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li><a data-view="talleres" class="nav-link">Gestión de Talleres</a></li>
                <li><a data-view="docentes" class="nav-link">Gestión de Docentes</a></li>
                <li><a data-view="alumnos" class="nav-link">Gestión de Alumnos</a></li>
                <li><a data-view="matriculas" class="nav-link">Matrículas</a></li>
                <li><a data-view="reportes" class="nav-link">Reportes</a></li>
                <li><a data-view="usuarios" class="nav-link">Usuarios del Sistema</a></li>
                <li><a>Cerrar Sesión</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <nav class="top-nav">
                <button class="menu-toggle" id="menu-toggle">☰</button>
                <div class="user-profile">Hola, Admin General</div>
            </nav>
            <div class="content">

                <!-- VISTA DASHBOARD -->
                <div id="dashboard-view" class="view-container active">
                    <h1>Dashboard Principal</h1>
                    <div class="dashboard-cards">
                        <div class="card"><h4>Alumnos Inscritos</h4><div class="value">452</div><div class="description">Total de alumnos activos</div></div>
                        <div class="card"><h4>Talleres Activos</h4><div class="value">25</div><div class="description">Oferta académica actual</div></div>
                        <div class="card"><h4>Docentes</h4><div class="value">18</div><div class="description">Personal docente registrado</div></div>
                        <div class="card"><h4>Ingresos del Mes</h4><div class="value">S/ 12,500</div><div class="description">Recaudado en Setiembre</div></div>
                    </div>
                    <div class="table-container">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <h3>Últimos Talleres Creados</h3>
                            <button class="btn btn-primary create-workshop-btn">Crear Nuevo Taller</button>
                        </div>
                        <table>
                            <thead><tr><th>Taller</th><th>Docente</th><th>Vacantes</th><th>Estado</th><th>Acciones</th></tr></thead>
                            <tbody>
                                @foreach ($talleres as $taller)
                                    
                                    <tr><td>{{$taller->disciplina->nombre}}</td><td>Carlos Pérez</td><td>{{$taller->matriculas_activas_count}}/{{$taller->vacantes}}</td><td><span class="status-badge status-active">Activo</span></td><td><button class="btn btn-primary edit-btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td></tr>

                                @endforeach
                                {{-- <tr><td>Fútbol Sub-10</td><td>Carlos Pérez</td><td>15/20</td><td><span class="status-badge status-active">Activo</span></td><td><button class="btn btn-primary edit-btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td></tr> --}}
                                {{-- <tr><td>Fútbol Sub-10</td><td>Carlos Pérez</td><td>15/20</td><td><span class="status-badge status-active">Activo</span></td><td><button class="btn btn-primary edit-btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td></tr>
                                <tr><td>Voley Femenino</td><td>Ana García</td><td>20/20</td><td><span class="status-badge status-full">Lleno</span></td><td><button class="btn btn-primary edit-btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td></tr>
                                <tr><td>Ajedrez Básico</td><td>Roberto Solis</td><td>8/15</td><td><span class="status-badge status-active">Activo</span></td><td><button class="btn btn-primary edit-btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td></tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>

           

                
            </div>
        </main>
    </div>

    <!-- Modal ÚNICO para Crear/Editar Taller (reutilizable) -->
    <div id="workshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Crear Nuevo Taller</h2>
                <span class="close-icon modal-close-trigger">&times;</span>
            </div>
            <form id="workshopForm">
                <div class="form-grid">
                    <div class="form-group"><label for="category">Categoría</label><div class="select-with-add"><select id="category" required><option value="">Seleccionar...</option></select><button type="button" class="btn btn-primary" id="addCategoryBtn">+</button></div></div>
                    <div class="form-group"><label for="discipline">Disciplina Deportiva</label><div class="select-with-add"><select id="discipline" required><option value="">Seleccionar...</option></select><button type="button" class="btn btn-primary" id="addDisciplineBtn">+</button></div></div>
                    <div class="form-group"><label for="teacher">Docente Asignado</label><div class="select-with-add"><select id="teacher" required><option value="">Seleccionar...</option></select><button type="button" class="btn btn-primary" id="addTeacherBtn">+</button></div></div>
                    <div class="form-group"><label for="vacancies">Vacantes</label><input type="number" id="vacancies" required min="0"></div>
                    <div class="form-group"><label for="cost">Costo de Matrícula (S/)</label><input type="number" step="0.01" id="cost" required min="0"></div>
                    <div class="form-group"><label for="monthlyFee">Costo de Mensualidad (S/)</label><input type="number" step="0.01" id="monthlyFee" min="0"></div>
                    <div class="form-group"><label for="status">Estado</label><select id="status" required><option value="activo">Activo</option><option value="inactivo">Inactivo</option></select></div>
                    <div class="form-group full-width">
                        <label for="workshopImage">Imagen del Taller</label>
                        <input type="file" id="workshopImage" accept="image/png, image/jpeg, image/webp">
                        <img id="imagePreview" src="" alt="Vista previa de la imagen">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal-close-trigger">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Taller</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // // --- LÓGICA DE NAVEGACIÓN POR VISTAS (PESTAÑAS) ---
            // const navLinks = document.querySelectorAll('.nav-link');
            // const views = document.querySelectorAll('.view-container');

            // navLinks.forEach(link => {
            //     link.addEventListener('click', () => {
            //         const targetViewId = link.getAttribute('data-view');
            //         if (!targetViewId) return; // Si no tiene data-view, no hace nada

            //         // Ocultar todas las vistas y quitar la clase 'active' de los links
            //         views.forEach(view => view.classList.remove('active'));
            //         navLinks.forEach(nav => nav.classList.remove('active'));

            //         // Mostrar la vista correcta y marcar el link como activo
            //         document.getElementById(`${targetViewId}-view`).classList.add('active');
            //         link.classList.add('active');
            //     });
            // });

            // --- LÓGICA DE LA BARRA LATERAL (SIDEBAR) ---
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            menuToggle.addEventListener('click', () => sidebar.classList.toggle('open'));

            // --- DATOS SIMULADOS (COMPARTIDOS) ---
            let availableCategories = ['Deportes de Equipo', 'Deportes Individuales', 'Deportes Mentales'];
            let availableDisciplines = ['Fútbol', 'Voley', 'Ajedrez', 'Karate'];
            let availableTeachers = ['Carlos Pérez', 'Ana García', 'Roberto Solis', 'Luis Mendoza'];

            // --- ELEMENTOS DEL DOM (COMPARTIDOS) ---
            const categorySelect = document.getElementById('category');
            const disciplineSelect = document.getElementById('discipline');
            const teacherSelect = document.getElementById('teacher');
            const workshopImageInput = document.getElementById('workshopImage');
            const imagePreview = document.getElementById('imagePreview');

            function populateSelect(select, options, placeholder) {
                select.innerHTML = `<option value="">${placeholder}</option>`;
                options.forEach(opt => select.add(new Option(opt, opt)));
            }
            
            function updateAllSelects() {
                populateSelect(categorySelect, availableCategories, 'Seleccionar...');
                populateSelect(disciplineSelect, availableDisciplines, 'Seleccionar...');
                populateSelect(teacherSelect, availableTeachers, 'Seleccionar...');
            }
            updateAllSelects();

            function addNewOption(select, dataArray, type) {
                const name = prompt(`Introduce el nombre del nuevo/a ${type}:`);
                if (name && name.trim()) {
                    const trimmed = name.trim();
                    if (!dataArray.includes(trimmed)) {
                        dataArray.push(trimmed);
                        populateSelect(select, dataArray, 'Seleccionar...');
                        select.value = trimmed;
                        alert(`${type.charAt(0).toUpperCase() + type.slice(1)} '${trimmed}' añadido.`);
                    } else {
                        alert(`El/La ${type} '${trimmed}' ya existe.`);
                        select.value = trimmed;
                    }
                }
            }

            document.getElementById('addCategoryBtn').addEventListener('click', () => addNewOption(categorySelect, availableCategories, 'categoría'));
            document.getElementById('addDisciplineBtn').addEventListener('click', () => addNewOption(disciplineSelect, availableDisciplines, 'disciplina'));
            document.getElementById('addTeacherBtn').addEventListener('click', () => addNewOption(teacherSelect, availableTeachers, 'docente'));

            // --- LÓGICA DEL MODAL (COMPARTIDA) ---
            const modal = document.getElementById('workshopModal');
            const modalTitle = document.getElementById('modalTitle');
            const workshopForm = document.getElementById('workshopForm');
            const createBtns = document.querySelectorAll('.create-workshop-btn');
            const closeTriggers = document.querySelectorAll('.modal-close-trigger');

            const resetImagePreview = () => {
                workshopImageInput.value = '';
                imagePreview.src = '';
                imagePreview.style.display = 'none';
            };

            const openModal = () => {
                document.body.classList.add('modal-open');
                modal.style.display = 'flex';
            };
            const closeModal = () => {
                document.body.classList.remove('modal-open');
                modal.style.display = 'none';
                workshopForm.reset();
                resetImagePreview();
            };

            createBtns.forEach(btn => btn.addEventListener('click', () => {
                modalTitle.textContent = 'Crear Nuevo Taller';
                openModal();
            }));

            // Delegación de eventos para los botones de editar, ya que pueden estar en vistas ocultas
            document.body.addEventListener('click', function(event) {
                if (event.target.classList.contains('edit-btn')) {
                    const row = event.target.closest('tr');
                    const workshopName = row.cells[0].textContent.trim();
                    const teacherName = row.cells[1].textContent.trim();
                    // Lógica para manejar tablas con o sin columna de costo
                    const hasCostColumn = row.cells.length > 4 && !isNaN(parseFloat(row.cells[3].textContent));
                    const vacancies = hasCostColumn ? row.cells[2].textContent.trim() : row.cells[2].textContent.trim();
                    const cost = hasCostColumn ? row.cells[3].textContent.trim() : '0.00';
                    const statusText = hasCostColumn ? row.cells[4].textContent.trim() : row.cells[3].textContent.trim();

                    modalTitle.textContent = `Editar Taller: ${workshopName}`;
                    const disciplineGuess = workshopName.split(' ')[0];
                    if(availableDisciplines.includes(disciplineGuess)) disciplineSelect.value = disciplineGuess;
                    
                    teacherSelect.value = teacherName;
                    document.getElementById('vacancies').value = vacancies.split('/')[1];
                    document.getElementById('cost').value = cost;
                    document.getElementById('status').value = statusText.toLowerCase();
                    
                    imagePreview.src = `https://via.placeholder.com/150x100.png?text=Imagen+Actual`;
                    imagePreview.style.display = 'block';

                    openModal();
                }
            });

            workshopImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(this.files[0]);
                } else {
                    resetImagePreview();
                }
            });

            closeTriggers.forEach(trigger => trigger.addEventListener('click', closeModal));
            window.addEventListener('click', (e) => (e.target == modal) && closeModal());

            workshopForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const imageFile = workshopImageInput.files[0] ? `(y el archivo ${workshopImageInput.files[0].name})` : '(sin nueva imagen)';
                alert(`Taller guardado (simulación) ${imageFile}.`);
                closeModal();
            });
        });
    </script>
</body>
</html>