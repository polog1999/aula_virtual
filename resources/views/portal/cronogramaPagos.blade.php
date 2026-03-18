@extends('layouts.app')
{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title> --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/cronogramaPagos.css') }}">
    <link rel="stylesheet" href="{{asset('css/paginacion-buscador.css')}}">
@endpush
@section('vista','Cronograma de Pagos')

@section('content')
    <div class="content">
        <div id="matriculas-view">
            <h1>Cronograma de Pagos</h1>
            <div class="table-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3>Pendientes de Pago</h3>
                </div>
                <form method="GET" action="{{ route('portal.cronogramaPagos.index') }}" class="search-bar">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar matricula..."
                        class="form-control w-25 d-inline">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>ID Matrícula</th>
                            <th>Alumno</th>
                            <th>Taller</th>
                            <th>Fecha de Registro</th>
                            <th>Costo Mensualidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Aquí se cargarán las matrículas pendientes de pago --}}
                        @foreach ($cronogramaPagosPendientes as $cronPago)
                            <tr>
                                <td>{{ $cronPago->matricula?->id}}</td>
                                <td>{{ $cronPago->matricula?->alumnos->user->nombres }}
                                    {{ $cronPago->matricula?->alumnos->user->apellido_paterno }}</td>
                                <td>{{ $cronPago->matricula?->seccion->talleres->disciplina->nombre }}</td>
                                <td>{{ $cronPago->matricula?->fecha_matricula }}</td>
                                <td>S/ {{ number_format($cronPago->matricula?->seccion->talleres->costo_mensualidad, 2) }}</td>
                                <td><span class="status-badge status-pending">Pendiente</span></td>
                                <td>
                                    <form action="cronogramaPagos/{{ $cronPago->id }}/confirmar" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PUT') {{-- O PATCH, según la API --}}
                                        <button type="submit" class="btn btn-confirm">Confirmar Pago</button>
                                    </form>
                                    <button class="btn btn-secondary view-details-btn"
                                        data-id="{{ $cronPago->matricula?->id }}">Ver Detalles</button>
                                </td>
                            </tr>
                        @endforeach
                       
                    </tbody>
                </table>
                {{$cronogramaPagosPendientes->appends(['pagados_page' => request('pagados_page')  ])->links()}}
            </div>

            <div class="table-container" style="margin-top: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3>Pagadas</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID Matrícula</th>
                            <th>Alumno</th>
                            <th>Taller</th>
                            <th>Fecha de Pago</th>
                            <th>Costo Mensualidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Aquí se cargarán las matrículas ya pagadas --}}
                        @foreach ($cronogramaPagosPagados as $cpPagado)
                            <tr>
                                <td>{{ $cpPagado->matricula->id }}</td>
                                <td>{{ $cpPagado->matricula->alumnos?->user->nombres }}
                                    {{ $cpPagado->matricula->alumnos?->user->apellido_paterno }}</td>
                                <td>{{ $cpPagado->matricula->seccion->talleres->disciplina->nombre }}</td>
                                <td>{{ $cpPagado->matricula->fecha_matricula }}</td>
                                
                                <td>S/ {{ number_format($cpPagado->matricula->seccion->talleres->costo_mensualidad, 2) }}</td>
                                <td><span class="status-badge status-paid">Pagado</span></td>
                                <td>
                                    <button class="btn btn-primary edit-btn" data-bs-toggle="modal"
                                        >Editar</button>
                                    <button class="btn btn-secondary view-details-btn"
                                        data-id="{{ $cpPagado->matricula->id }}">Ver Detalles</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$cronogramaPagosPagados->appends(['pendientes_page' => request('pendientes_page')  ]
                )->links()}}
            </div>
        </div>
    </div>
@endsection
{{-- </main>
    </div> --}}

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
</body>

</html>
