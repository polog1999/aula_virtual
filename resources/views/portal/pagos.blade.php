@extends('layouts.app')
{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title> --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/cronogramaPagos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/paginacion-buscador.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/matriculas.css') }}">
@endpush
@section('vista', 'Pagos')

@section('content')
    <div class="content">
        <div id="matriculas-view">
            <h1>Pagos</h1>
            <div class="table-container">

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom:1rem;">
                    <h3>Lista de pagos</h3>
                    <a href="{{ route('portal.reportes.pagos') }}" class="btn btn-primary">
                        <i class="fa-solid fa-file-excel"></i> Exportar Pagos a Excel
                    </a>
                </div>
                <form method="GET" action="{{ route('portal.pagos.index') }}" class="search-bar">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar pago..."
                        class="form-control w-25 d-inline">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
                <div style="width: 100%; overflow:auto;">
                    <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Alumno</th>
                            <th>Apoderado</th>
                            <th>N° Contribuyente</th>
                            <th>Taller</th>
                            <th>Monto</th>
                            <th>Método de Pago</th>
                            <th>N° Liquidación</th>
                            <th>Fecha de Pago</th>
                            {{-- <th>Costo Matrícula</th> --}}
                            {{-- <th>Estado</th> --}}
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Aquí se cargarán las matrículas pendientes de pago --}}
                        @foreach ($matriculas as $i => $m)
                            @php
                                $inscripcion = $m->cronogramasPagos()->first()->pago->pagosNiubiz->inscripcion;

                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $m->alumnos?->user->nombres }}
                                    {{ $m->alumnos?->user->apellido_paterno }}</td>
                                <td>{{ $m->alumnos?->padre?->user->fullName ?? '-- Sin Apoderado --'}}</td>
                                <td>{{ $inscripcion->tipo_inscripcion == 'minor' ? $inscripcion->ordenApoderado->numero_contribuyente : $inscripcion->ordenAlumno->numero_contribuyente }}
                                </td>
                                <td>{{ $m->seccion?->talleres->disciplina->nombre }}
                                    ({{ $m->seccion?->nombre }})
                                    {{-- - {{ $m->seccion?->dia_semana }} -
                                    {{ $m->seccion?->docentes->user->nombres }}
                                    {{ $m->seccion?->docentes->user->apellido_paterno }}</td> --}}
                                <td>S/{{ $m->cronogramasPagos()->first()->pago->monto_pagado }}</td>


                                <td>{{ mb_strtoupper($m->cronogramasPagos()->first()->pago->metodo_pago) }}</td>
                                <td>{{ mb_strtoupper($m->cronogramasPagos()->first()->pago->pagosNiubiz->inscripcion->numero_liquidacion) }}
                                </td>

                                {{-- <td>S/ {{ number_format($m->seccion?->talleres->costo_matricula, 2) }}</td> --}}
                                {{-- <td><span class="status-badge status-pending">{{ $m->cronogramasPagos()->first()->pago->estado }}</span></td> --}}
                                <td>{{ $m->fecha_matricula }}</td>
                                <td>
                                    @if ($m->cronogramasPagos()->first()->pago)
                                        @php
                                            $pago = $m->cronogramasPagos()->first()->pago;
                                        $idCifrado = Crypt::encryptString($pago->id); @endphp
                                        <a href="{{ route('pagos.comprobante', $idCifrado) }}" target="_blank"
                                            class="btn btn-primary" style="text-align: center;padding: 0.6rem 0.8rem;">
                                            <i class="fa-solid fa-file-pdf"></i> Ver Comprobante</a>
                                    @else
    
    

                                        <span>(Matrícula manual)</span>
                                    @endif

                                    {{-- <button class="btn btn-primary edit-btn" data-bs-toggle="modal"
                                        data-bs-target="#editTallerModal" data-id="{{ $m->id }}"
                                        data-id-seccion="{{ $m->seccion?->id }}"
                                        data-estado="{{ $m->estado }}">Editar</button> --}}
                                    {{-- <form action="{{ route('portal.matriculas.cancelar', $m) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-danger">Cancelar Matrícula</button>
                                    </form> --}}
                                    {{-- <form class="delete-form" action="{{ route('portal.matriculas.destroy', $m->id) }}"
                                        method="POST" style="display:inline;">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger delete-btn" type="submit">Eliminar</button>
                                    </form> --}}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                </div>
                {{ $matriculas->links() }}
            </div>

        </div>
    </div>
@endsection


{{-- @section('modals')
    <div id="editWorkshopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="editModalTitle">Editar Matricula</h2>
                <span class="close-icon">&times;</span>
            </div>
            <form id="editWorkshopForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editWorkshopId" name="id">
                <div class="form-grid">

                    <div class="form-group"><label for="editTaller">Taller</label><select id="editTaller" name="editTaller"
                            required>
                            <option value="">Seleccionar...</option>
                            @foreach ($secciones as $s)
                                <option value="{{ $s->id }}">{{ $s->talleres->disciplina->nombre }}
                                    ({{ $s->nombre }})
                                    - {{ $s->dia_semana }} - {{ $s->docentes->user->nombres }}
                                    {{ $s->docentes->user->apellido_paterno }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label for="editEstado">Estado</label>
                        <select id="editEstado" name ="editEstado" required>
                            <option value="">Seleccionar...</option>
                            <option value="INACTIVA">Inactiva</option>
                            <option value="ACTIVA">Activa</option>
                            <option value="RETIRADO">Retirado</option>
                            <option value="FINALIZADO">Finalizado</option> --}}
{{-- @foreach ($disciplinas as $disciplina)
                                <option value="{{ $disciplina->id }}">{{ $disciplina->nombre }}</option>
                            @endforeach --}}
{{-- </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Taller</button>
                    </div>
            </form>
        </div>
    </div>
@endsection --}}

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
                // console.log('preisonado');
                if (event.target.classList.contains('edit-btn')) {
                    // console.log('preisonado');
                    const button = event.target;

                    if (editModalTitle) editModalTitle.textContent =
                        `Editar Matricula: ${button.dataset.nombre}`;
                    document.getElementById('editWorkshopId').value = button.dataset.id;
                    document.getElementById('editTaller').value = button.dataset.idSeccion;
                    document.getElementById('editEstado').value = button.dataset.estado;


                    // if (editContainer) editContainer.innerHTML = '';


                    if (editForm) editForm.action = '{{ url('portal/matriculas') }}/' + button.dataset.id;

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

{{-- 
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
                    document.getElementById('detailCostoMatricula').textContent = matricula
                        .costoMatricula;
                    document.getElementById('detailCostoMensualidad').textContent = matricula
                        .costoMensualidad;
                    document.getElementById('detailFechaRegistro').textContent = matricula
                        .fechaRegistro;
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
</script> --}}
{{-- </body>

</html> --}}
