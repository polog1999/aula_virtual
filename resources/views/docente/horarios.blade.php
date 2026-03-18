@extends('layouts.docente.app')

@section('title', 'Mi Horario')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/paginacion-buscador.css') }}">
    <style>
        :root {
            --primary-color: #1E8449;
            --secondary-color: #2ECC71;
            --light-green: #D5F5E3;
            --dark-gray: #34495E;
            --light-gray: #ECF0F1;
            --white: #ffffff;
        }

        /* ... tus estilos base (body, sidebar, etc. sin cambios) ... */
        .content {
            padding: 2rem;
        }

        .main-panel,
        .side-panel {
            background: var(--white);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .main-panel h3,
        .side-panel h3 {
            margin-top: 0;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2.5fr 1fr;
            gap: 2rem;
            align-items: flex-start;
        }

        /* --- NUEVOS ESTILOS PARA LA TARJETA DE HORARIO --- */
        .schedule-card {
            background: #fdfdfd;
            border-left: 5px solid var(--primary-color);
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 0 8px 8px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .schedule-card h4 {
            margin: 0 0 0.5rem 0;
            font-size: 1.4rem;
            color: var(--dark-gray);
        }

        .schedule-card .student-name {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: block;
        }

        .schedule-list {
            list-style: none;
            padding: 0;
            margin: 1rem 0;
            border-top: 1px solid var(--light-gray);
        }

        .schedule-list li {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--light-gray);
            font-size: 1rem;
        }

        .schedule-list i {
            color: var(--primary-color);
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .schedule-list .day {
            font-weight: 600;
            min-width: 90px;
        }

        .side-panel ul {
            list-style: none;
            padding: 0;
        }

        .side-panel li {
            background-color: var(--light-green);
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            margin-bottom: 0.5rem;
            font-weight: 600;
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
            width: 100%;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }

        @media (max-width: 992px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ... tus otros media queries ... */
    </style>
@endpush

@section('content')
    <div class="content">
        <h1>Mi Horario Semanal</h1>
        <div class="content-grid">
            <div class="main-panel">
                <h3>Talleres Inscritos</h3>

                @forelse ($matriculasActivas as $matricula)
                    <div class="schedule-card">
                        <h4>{{ $matricula->seccion->talleres->disciplina->nombre }} - {{ $matricula->seccion->nombre }}</h4>

                        {{-- Mostrar el nombre del alumno, especialmente útil para el rol PADRE --}}
                        @if (Auth::user()->role->value === 'PADRE' || $esAdultoYPadre)
                            <span class="student-name">
                                <i class="fa-solid fa-user"></i>
                                {{$matricula->alumnos->user_id == Auth::user()->id? 'Yo':Auth::user()}}: {{ $matricula->alumnos->user->nombres }}
                                {{ $matricula->alumnos->user->apellido_paterno }}
                            </span>
                        @endif

                        <ul class="schedule-list">
                            {{-- Bucle para mostrar cada día del horario de la sección --}}

                            <li>
                                <i class="fa-solid fa-calendar-day"></i>
                                <span class="day">Horario</span>
                                <span>{{ $matricula->seccion->dia_semana }}</span>
                            </li>
                            
                            <li>
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <span class="day">Profesor</span>
                                <span>{{ $matricula->seccion->docentes->user->nombres }}
                                    {{ $matricula->seccion->docentes->user->apellido_paterno }}</span>
                            </li>
                            <li>
                                <i class="fa-solid fa-location-dot"></i>
                                <span class="day">Lugar</span>
                                <span>{{ $matricula->seccion->lugares->nombre }}</span>
                            </li>
                        </ul>
                    </div>
                @empty
                    <div style="text-align: center; padding: 2rem;">
                        <h4>No hay inscripciones activas</h4>
                        <p>Actualmente no estás inscrito en ningún taller. ¡Explora nuestra oferta y encuentra tu próxima
                            actividad!</p>
                    </div>
                @endforelse

            </div>

            <div class="side-panel">
                <h3>Resumen</h3>
                <p><strong>Talleres Activos:</strong></p>
                <ul>
                    @foreach ($matriculasActivas as $matricula)
                        <li>{{ $matricula->seccion->talleres->disciplina->nombre }} - {{$matricula->seccion->nombre}} 
                            @php
                                $categoria = $matricula->seccion->talleres->categoria;
                            @endphp
                            @if ($categoria->edad_min != null && $categoria->edad_max == null)
                                        (De {{ $categoria->edad_min }} años a más)
                                    @elseif($categoria->edad_min != null && $categoria->edad_max != null)
                                        (De {{ $categoria->edad_min }} a {{ $categoria->edad_max }} años de)
                                    @elseif($categoria->tiene_discapacidad)
                                        (Para personas con discapacidad)
                                    @else
                                   (Todas las edades)
                                    @endif
                                 </li>
                    @endforeach
                </ul>
                <a href="{{ route('index') }}" class="btn btn-primary" style="margin-top: 1.5rem;">
                    <i class="fa-solid fa-plus"></i> Inscribirse a un Nuevo Taller
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
  
@endpush
