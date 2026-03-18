@extends('layouts.docente.app')
@section('title', 'Mis hijos')
@push('styles')
<style>
    /* --- TUS ESTILOS CSS GENERALES Y BASE (SIN CAMBIOS) --- */
    :root {
        --primary-color: #1E8449;
        --secondary-color: #2ECC71;
        --light-green: #D5F5E3;
        --dark-gray: #34495E;
        --light-gray: #ECF0F1;
        --white: #ffffff;
        --warning: #F39C12;
        --danger: #E74C3C;
        --info: #3498DB;
    }

   
    .content {
        padding: 2rem;
    }

    .main-panel {
        background: var(--white);
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .main-panel h3 {
        margin-top: 0;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .btn {
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        font-weight: bold;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: var(--white);
    }

    /* --- NUEVOS ESTILOS PARA LA VISTA "MIS HIJOS" --- */
    .student-card {
        background-color: var(--white);
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .student-card-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 1rem 1.5rem;
    }

    .student-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
    }

    .student-info h4 {
        margin: 0;
        font-size: 1.3rem;
    }

    .student-info p {
        margin: 0;
        color: #6c757d;
    }

    .student-card-body {
        padding: 1.5rem;
    }

    .tabs {
        display: flex;
        border-bottom: 2px solid var(--light-gray);
        margin-bottom: 1.5rem;
    }

    .tab-link {
        padding: 0.8rem 1.5rem;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        color: #6c757d;
        position: relative;
    }

    .tab-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: transparent;
        transition: background-color 0.3s;
    }

    .tab-link.active {
        color: var(--primary-color);
    }

    .tab-link.active::after {
        background-color: var(--primary-color);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
        animation: fadeIn 0.5s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
    }

    .info-table th,
    .info-table td {
        padding: 0.8rem;
        text-align: left;
        border-bottom: 1px solid var(--light-gray);
    }

    .info-table th {
        font-weight: 600;
    }

    .info-table tbody tr:last-child td {
        border-bottom: none;
    }

    @media (max-width: 768px) {
        .content {
            padding: 1.5rem 1rem;
        }

        .student-card-header {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="content">
    <h1>Seguimiento de Alumnos</h1>

    {{-- Bucle principal: una tarjeta por cada hijo --}}
    @forelse ($alumnosAsociados as $alumno)
        <div class="student-card" data-student-id="{{ $alumno->user->id }}">
            <div class="student-card-header">
                <div class="student-avatar">{{ substr($alumno->user->nombres, 0, 1) }}</div>
                <div class="student-info">
                    <h4>{{ $alumno->user->nombres }} {{ $alumno->user->apellido_paterno }}</h4>
                    <p>Edad: {{ $alumno->user->fecha_nacimiento->age }} años | DNI:
                        {{ $alumno->user->numero_documento }}</p>
                </div>
            </div>
            <div class="student-card-body">
                <div class="tabs">
                    <button class="tab-link active" data-tab="horario">Horario</button>
                    <button class="tab-link" data-tab="asistencias">Asistencias</button>
                    {{-- <button class="tab-link" data-tab="calificaciones">Calificaciones</button> --}}
                </div>

                {{-- Contenido de la Pestaña HORARIO --}}
                <div id="horario-{{ $alumno->user->id }}" class="tab-content active">
                    <h3>Horario de la Semana</h3>
                    <table class="info-table">
                        <thead>
                            <tr>
                                <th>Taller</th>
                                <th>Horario</th>
                                <th>Docente</th>
                                <th>Lugar</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Bucle sobre las matrículas activas del alumno --}}
                            @foreach ($alumno->matriculasActivas as $matricula)
                                
                                    <tr>
                                        <td>{{ $matricula->seccion->talleres->disciplina->nombre }}</td>
                                        <td>{{ $matricula->seccion->dia_semana}}</td>
                                        <td>{{ $matricula->seccion->docentes->user->FullName}}</td>
                                        <td>{{ $matricula->seccion->lugares->nombre }}</td>
                                    </tr>
                               
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Contenido de la Pestaña ASISTENCIAS --}}
                <div id="asistencias-{{$alumno->user->id}}" class="tab-content">
                            <h3>Últimas Asistencias Registradas</h3>
                             <table class="info-table">
                                <thead><tr><th>Fecha</th><th>Taller</th><th>Estado</th></tr></thead>
                                <tbody>
                {{-- Bucle sobre las asistencias del alumno --}}
                @forelse ($alumno->ultimasAsistencias as $asistencia)
                                        <tr>
                                            <td>{{ $asistencia->fecha->format('d/m/Y') }}</td>
                                            <td>{{ $asistencia->matricula->seccion->talleres->disciplina->nombre }}</td>
                                            <td><span class="status-badge status-{{ strtolower($asistencia->estado) }}">{{ $asistencia->estado }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3">No hay registros de asistencia.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                {{-- Contenido de la Pestaña CALIFICACIONES --}}
                {{-- <div id="calificaciones-{{$alumno->user->id}}" class="tab-content">
                             <h3>Últimas Calificaciones</h3>
                             <table class="info-table">
                                <thead><tr><th>Fecha</th><th>Taller</th><th>Evaluación</th><th>Nota</th></tr></thead>
                                <tbody>
                                     @forelse ($alumno->ultimasCalificaciones as $evaluacion)
                                        <tr>
                                            <td>{{ $evaluacion->fecha_evaluacion->format('d/m/Y') }}</td>
                                            <td>{{ $evaluacion->matricula->seccion->talleres->disciplina->nombre }}</td>
                                            <td>{{ $evaluacion->nombre_evaluacion }}</td>
                                            <td><strong>{{ number_format($evaluacion->calificacion, 2) }}</strong></td>
                                        </tr>
                                     @empty
                                        <tr><td colspan="4">No hay calificaciones registradas.</td></tr>
                                     @endforelse
                                </tbody>
                            </table>
                        </div> --}}
            </div>
        </div>
    @empty
        <div class="main-panel" style="text-align: center;">
            <h3>No hay alumnos asociados</h3>
            <p>Aún no has inscrito a ningún alumno en nuestros talleres. ¡Explora nuestra oferta e inscribe
                a tu familia!</p>
            <a href="{{-- {{ route('talleres.index') }} --}}" class="btn btn-primary" style="margin-top: 1rem;">Ver Talleres
                Disponibles</a>
        </div>
    @endforelse

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lógica para el menú responsive
        // const menuToggle = document.getElementById('menu-toggle');
        // if (menuToggle) {
        //     menuToggle.addEventListener('click', function() {
        //         document.querySelector('.sidebar').classList.toggle('open');
        //     });
        // }

        // Lógica para el sistema de pestañas (Tabs)
        const studentCards = document.querySelectorAll('.student-card');

        studentCards.forEach(card => {
            const tabLinks = card.querySelectorAll('.tab-link');
            const tabContents = card.querySelectorAll('.tab-content');

            tabLinks.forEach(link => {
                link.addEventListener('click', () => {
                    // Quitar 'active' de todos
                    tabLinks.forEach(l => l.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));

                    // Añadir 'active' al seleccionado
                    link.classList.add('active');
                    const tabId = link.dataset.tab;
                    card.querySelector(`#${tabId}-${card.dataset.studentId}`).classList
                        .add('active');
                });
            });
        });
    });
</script>
@endpush
