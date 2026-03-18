@extends('layouts.apoderado.app') {{-- O como se llame tu layout --}}

@section('title', 'Mi Asistencia')
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
            --warning: #F39C12;
            --danger: #E74C3C;
            --info: #3498DB;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            background-color: var(--light-gray);
            color: var(--dark-gray);
        }

        .container-fluid {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            /* ... tus estilos de sidebar ... */
        }

        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .top-nav {
            /* ... tus estilos de top-nav ... */
        }

        .content {
            padding: 2rem;
        }

        .main-panel {
            background: var(--white);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .main-panel h3 {
            margin-top: 0;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }

        /* --- ESTILOS PARA LA VISTA DE ASISTENCIA --- */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .filter-bar label {
            font-weight: 600;
        }

        .filter-bar select {
            padding: 0.6rem;
            border-radius: 5px;
            border: 1px solid #ccc;
            flex-grow: 1;
            max-width: 400px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: var(--light-gray);
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            border-left: 5px solid;
        }

        .stat-card .value {
            font-size: 2.5rem;
            font-weight: bold;
            display: block;
        }

        .stat-card .label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #555;
        }

        .stat-card.percentage {
            border-color: var(--primary-color);
        }

        .stat-card.attended {
            border-color: var(--secondary-color);
        }

        .stat-card.absent {
            border-color: var(--danger);
        }

        .stat-card.late {
            border-color: var(--warning);
        }

        .attendance-history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .attendance-history-table th,
        .attendance-history-table td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }

        .attendance-history-table th {
            font-weight: 600;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: bold;
            color: var(--white);
            display: inline-block;
            text-align: center;
            min-width: 90px;
        }

        .status-asistio {
            background-color: var(--secondary-color);
            color: var(--dark-gray);
        }

        .status-falto {
            background-color: var(--danger);
        }

        .status-tardanza {
            background-color: var(--warning);
        }

        .status-justificado {
            background-color: var(--info);
        }
    </style>
@endpush

@section('content')
    <div class="content">
        <h1>Mi Asistencia</h1>
        <div class="main-panel">
            <div class="filter-bar">
                <label for="matriculaSelector">Mostrando asistencia para:</label>
                <select id="matriculaSelector">
                    @foreach ($matriculas as $matricula)
                        <option value="{{ $matricula->id }}"
                            {{ $matriculaSeleccionada->id == $matricula->id ? 'selected' : '' }}>
                            {{ $matricula->seccion->talleres->disciplina->nombre }} -
                            {{ $matricula->alumnos->user->nombres }} {{$matricula->alumnos->user_id == auth()->id()?' (Yo)':''}}
                        </option>
                    @endforeach
                </select>
            </div>

            @if ($matriculaSeleccionada)
                {{-- Resumen de Estadísticas --}}
                <h3>Resumen General</h3>
                <div class="stats-grid">
                    <div class="stat-card percentage">
                        <span class="value">{{ number_format($stats['porcentaje_asistencia'], 1) }}%</span>
                        <span class="label">Asistencia General</span>
                    </div>
                    <div class="stat-card attended">
                        <span class="value">{{ $stats['total_asistencias'] }}</span>
                        <span class="label">Días Asistidos</span>
                    </div>
                    <div class="stat-card absent">
                        <span class="value">{{ $stats['total_faltas'] }}</span>
                        <span class="label">Faltas</span>
                    </div>
                    <div class="stat-card late">
                        <span class="value">{{ $stats['total_tardanzas'] }}</span>
                        <span class="label">Tardanzas</span>
                    </div>
                </div>

                {{-- Historial Detallado --}}
                <h3 style="margin-top: 2rem;">Historial de Asistencias</h3>
                <div class="attendance-history-container">
                    <table class="attendance-history-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Día</th>
                                <th>Estado</th>
                                <th>Observación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($asistencias as $asistencia)
                                <tr>
                                    <td>{{ $asistencia->fecha->format('d/m/Y') }}</td>
                                    <td>{{ $asistencia->fecha->locale('es')->dayName }}</td>
                                    <td><span
                                            class="status-badge status-{{ strtolower($asistencia->estado) }}">
                                        @if($asistencia->estado === 'ASISTIO')
                                        PRESENTE
                                        @elseif($asistencia->estado === 'FALTO')
                                        FALTÓ
                                        @elseif($asistencia->estado ==='TARDANZA')
                                        TARDANZA
                                        @endif
                                        </span>
                                    </td>
                                    <td>{{ $asistencia->detalles ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 2rem;">No hay registros de
                                        asistencia para esta matrícula.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- Paginación --}}
                    <div style="margin-top: 1.5rem;">
                        {{ $asistencias->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @else
                <p>No tienes ninguna matrícula activa. ¡Inscríbete a un taller!</p>
            @endif
        </div>
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

            // Lógica para recargar la página al cambiar de matrícula
            const matriculaSelector = document.getElementById('matriculaSelector');
            if (matriculaSelector) {
                matriculaSelector.addEventListener('change', function() {
                    const selectedMatriculaId = this.value;
                    // Construye la nueva URL con el parámetro de la matrícula seleccionada
                    const url = new URL(window.location.href);
                    url.searchParams.set('matricula_id', selectedMatriculaId);
                    window.location.href = url.toString();
                });
            }
        });
    </script>
@endpush
</body>

</html>
