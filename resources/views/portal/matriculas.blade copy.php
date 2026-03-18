@extends('layouts.admin.app')
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
            --dark-gray: #34495E;
            --light-gray: #ECF0F1;
            --white: #ffffff;
            --danger: #E74C3C;
            --warning: #F1C40F; /* Nuevo color para el estado pendiente */
            --success: #27AE60; /* Nuevo color para el estado pagado */
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
        .dashboard-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .card { background: var(--white); padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        .card h4 { margin-top: 0; color: var(--primary-color); }
        .card .value { font-size: 2rem; font-weight: bold; }
        .table-container { background: var(--white); border-radius: 8px; padding: 1.5rem; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.8rem; text-align: left; border-bottom: 1px solid var(--light-gray); vertical-align: middle; }
        th { font-weight: bold; }
        .btn { padding: 0.6rem 1.2rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 0.9rem; margin-right: 5px;}
        .btn-primary { background-color: var(--primary-color); color: var(--white); }
        .btn-secondary { background-color: #7f8c8d; color: var(--white); }
        .btn-danger { background-color: var(--danger); color: var(--white); }
        .btn-confirm { background-color: var(--success); color: var(--white); } /* Botón de confirmar */
        .status-badge { padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.8rem; font-weight: bold; color: var(--white); }
        .status-active { background-color: var(--secondary-color); }
        .status-full { background-color: #E67E22; }
        .status-inactive { background-color: #95A5A6; }
        .status-pending { background-color: var(--warning); } /* Estado pendiente */
        .status-paid { background-color: var(--success); } /* Estado pagado */

        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: 0; top: 0; height: 100%; transform: translateX(-100%); z-index: 1000; }
            .sidebar.open { transform: translateX(0); }
            .menu-toggle { display: block; }
            .form-grid { grid-template-columns: 1fr; }
            .schedule-row { flex-wrap: wrap; }
            .remove-schedule-btn { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Portal Administrador</h3>
            </div>
            <ul class="sidebar-nav">
                <li><a data-view="dashboard" class="nav-link" href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li><a data-view="talleres" class="nav-link">Gestión de Talleres</a></li>
                <li><a data-view="docentes" class="nav-link">Gestión de Docentes</a></li>
                <li><a data-view="alumnos" class="nav-link">Gestión de Alumnos</a></li>
                <li><a data-view="matriculas" class="nav-link active">Matrículas</a></li>
                <li><a data-view="reportes" class="nav-link">Reportes</a></li>
                <li><a data-view="usuarios" class="nav-link">Usuarios del Sistema</a></li>
                <li>
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button type="submit" data-view="cerrarSesion" class="nav-link">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </aside>

        <main class="main-content">
            <nav class="top-nav">
                <button class="menu-toggle" id="menu-toggle">☰</button>
                <div class="user-profile">Hola, Admin General</div>
            </nav>

            <div class="content">
                <div id="matriculas-view">
                    <h1>Gestión de Matrículas</h1>
                    <div class="table-container">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <h3>Matrículas Pendientes de Pago</h3>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID Matrícula</th>
                                    <th>Alumno</th>
                                    <th>Taller</th>
                                    <th>Fecha de Registro</th>
                                    <th>Costo Matrícula</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Aquí se cargarán las matrículas pendientes de pago --}}
                                @foreach ($cronogramaPagosPendientes as $cronPago)
                                    <tr>
                                        <td>{{ $cronPago->matricula->id }}</td>
                                        <td>{{ $cronPago->matricula->alumnos->user->nombres }} {{ $cronPago->matricula->alumnos->user->apellido_paterno }}</td>
                                        <td>{{ $cronPago->matricula->taller->nombre }}</td>
                                        <td>{{ $cronPago->matricula->fecha_matricula}}</td>
                                        <td>S/ {{ number_format($cronPago->matricula->taller->costo_matricula, 2) }}</td>
                                        <td><span class="status-badge status-pending">Pendiente</span></td>
                                        <td>
                                            <form action="matriculas/{{ $cronPago->id }}/confirmar" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT') {{-- O PATCH, según la API --}}
                                                <button type="submit" class="btn btn-confirm">Confirmar Pago</button>
                                            </form>
                                            <button class="btn btn-secondary view-details-btn" data-id="{{ $cronPago->matricula->id }}">Ver Detalles</button>
                                        </td>
                                    </tr>
                                @endforeach
                                {{-- Ejemplo de una matrícula ya pagada (opcional, para demostrar el estado) --}}
                                {{-- <tr>
                                    <td>000003</td>
                                    <td>Ana García</td>
                                    <td>Guitarra para Principiantes</td>
                                    <td>2023-09-01</td>
                                    <td>S/ 80.00</td>
                                    <td><span class="status-badge status-paid">Pagado</span></td>
                                    <td>
                                        <button class="btn btn-secondary view-details-btn" data-id="3">Ver Detalles</button>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="table-container" style="margin-top: 2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <h3>Historial de Matrículas (Pagadas)</h3>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID Matrícula</th>
                                    <th>Alumno</th>
                                    <th>Taller</th>
                                    <th>Fecha de Pago</th>
                                    <th>Costo Matrícula</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Aquí se cargarán las matrículas ya pagadas --}}
                                @foreach ($cronogramaPagosPagados as $cpPagado)
                                    <tr>
                                        <td>{{ $cpPagado->matricula->id }}</td>
                                        <td>{{ $cpPagado->matricula->alumnos->user->nombres }} {{ $cpPagado->matricula->alumnos->user->apellido_paterno }}</td>
                                        <td>{{ $cpPagado->matricula->taller->nombre }}</td>
                                        <td>{{ $cpPagado->matricula->fecha_matricula }}</td> <!--Asumiendo que tienes un campo fecha_pago-->
                                        <td>S/ {{ number_format($cpPagado->matricula->taller->costo_matricula, 2) }}</td>
                                        <td><span class="status-badge status-paid">Pagado</span></td>
                                        <td>
                                            <button class="btn btn-secondary view-details-btn" data-id="{{ $cpPagado->matricula->id }}">Ver Detalles</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Aquí podrías añadir un modal para ver detalles de la matrícula, si lo necesitas --}}
    <div id="viewMatriculaDetailsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detalles de Matrícula <span id="matriculaIdDetail"></span></h2>
                <span class="close-icon">&times;</span>
            </div>
            <div id="matriculaDetailsContent">
                {{-- Aquí se cargarán los detalles de la matrícula vía JavaScript --}}
                <p><strong>Alumno:</strong> <span id="detailAlumno"></span></p>
                <p><strong>Taller:</strong> <span id="detailTaller"></span></p>
                <p><strong>Disciplina:</strong> <span id="detailDisciplina"></span></p>
                <p><strong>Docente:</strong> <span id="detailDocente"></span></p>
                <p><strong>Lugar:</strong> <span id="detailLugar"></span></p>
                <p><strong>Días y Horarios:</strong> <span id="detailHorarios"></span></p>
                <p><strong>Costo Matrícula:</strong> <span id="detailCostoMatricula"></span></p>
                <p><strong>Costo Mensualidad:</strong> <span id="detailCostoMensualidad"></span></p>
                <p><strong>Fecha de Registro:</strong> <span id="detailFechaRegistro"></span></p>
                <p><strong>Estado de Pago:</strong> <span id="detailEstadoPago"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary">Cerrar</button>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            if (menuToggle) {
                menuToggle.addEventListener('click', () => sidebar.classList.toggle('open'));
            }

            function openModal(modal) {
                document.body.classList.add('modal-open');
                modal.style.display = 'flex';
            }

            function closeModal(modal) {
                document.body.classList.remove('modal-open');
                modal.style.display = 'none';
            }

            // Lógica para el modal de detalles de matrícula (si lo implementas)
            const viewMatriculaDetailsModal = document.getElementById('viewMatriculaDetailsModal');

            document.body.addEventListener('click', function(event) {
                if (event.target.classList.contains('view-details-btn')) {
                    const matriculaId = event.target.dataset.id;
                    // Aquí harías una petición AJAX para obtener los detalles de la matrícula
                    // Por ahora, un ejemplo con datos dummy:
                    const dummyMatriculas = {
                        "1": {
                            id: "000001",
                            alumno: "Juan Pérez",
                            taller: "Cerámica Avanzada",
                            disciplina: "Cerámica",
                            docente: "María López",
                            lugar: "Taller Principal",
                            horarios: "Lunes y Miércoles 10:00 - 12:00",
                            costoMatricula: "S/ 100.00",
                            costoMensualidad: "S/ 120.00",
                            fechaRegistro: "2023-09-15",
                            estadoPago: "Pendiente"
                        },
                        "2": {
                            id: "000002",
                            alumno: "Pedro Ramírez",
                            taller: "Dibujo Artístico",
                            disciplina: "Dibujo",
                            docente: "Carlos Vega",
                            lugar: "Aula 3",
                            horarios: "Martes y Jueves 18:00 - 20:00",
                            costoMatricula: "S/ 90.00",
                            costoMensualidad: "S/ 110.00",
                            fechaRegistro: "2023-09-10",
                            estadoPago: "Pendiente"
                        },
                        "3": {
                            id: "000003",
                            alumno: "Ana García",
                            taller: "Guitarra para Principiantes",
                            disciplina: "Música",
                            docente: "Laura Fernández",
                            lugar: "Salón de Música",
                            horarios: "Viernes 16:00 - 18:00",
                            costoMatricula: "S/ 80.00",
                            costoMensualidad: "S/ 100.00",
                            fechaRegistro: "2023-09-01",
                            estadoPago: "Pagado"
                        }
                    };

                    const matricula = dummyMatriculas[matriculaId];
                    if (matricula) {
                        document.getElementById('matriculaIdDetail').textContent = matricula.id;
                        document.getElementById('detailAlumno').textContent = matricula.alumno;
                        document.getElementById('detailTaller').textContent = matricula.taller;
                        document.getElementById('detailDisciplina').textContent = matricula.disciplina;
                        document.getElementById('detailDocente').textContent = matricula.docente;
                        document.getElementById('detailLugar').textContent = matricula.lugar;
                        document.getElementById('detailHorarios').textContent = matricula.horarios;
                        document.getElementById('detailCostoMatricula').textContent = matricula.costoMatricula;
                        document.getElementById('detailCostoMensualidad').textContent = matricula.costoMensualidad;
                        document.getElementById('detailFechaRegistro').textContent = matricula.fechaRegistro;
                        document.getElementById('detailEstadoPago').textContent = matricula.estadoPago;
                        openModal(viewMatriculaDetailsModal);
                    } else {
                        alert('Matrícula no encontrada.');
                    }
                }
            });

            document.querySelectorAll('.modal').forEach(modal => {
                const closeButton = modal.querySelector('.close-icon');
                const cancelButton = modal.querySelector('.modal-footer .btn-secondary'); 
                
                if (closeButton) closeButton.addEventListener('click', () => closeModal(modal));
                if (cancelButton) cancelButton.addEventListener('click', () => closeModal(modal));
                
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) closeModal(modal);
                });
            });
        });
    </script>
</body>
</html>