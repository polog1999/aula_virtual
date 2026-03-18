@extends('layouts.encargadoSede.app')
@section('vista', 'Central de Reportes')
@push('styles')
    <style>
        /* --- ESTILOS GENERALES (Copia los mismos de tu otra vista para consistencia) --- */
        :root {
            --primary-color: #1E8449;
            --secondary-color: #2ECC71;
            --light-green: #D5F5E3;
            --dark-gray: #34495E;
            --light-gray: #ECF0F1;
            --white: #ffffff;
        }

        .content {
            padding: 2rem;
        }

        .main-panel {
            background: var(--white);
            border-radius: 8px;
            padding: 1.5rem 2rem;
            /* Un poco más de padding horizontal */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .main-panel h3 {
            margin-top: 0;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
            /* Espacio después del título */
            color: var(--primary-color);
            font-size: 1.4rem;
        }

        /* Párrafo descriptivo del reporte */
        .report-description {
            font-size: 1rem;
            color: #566573;
            /* Un gris un poco más oscuro para mejor lectura */
            margin-bottom: 1.5rem;
            max-width: 800px;
            /* Limita el ancho para fácil lectura */
        }

        .report-description strong {
            color: var(--dark-gray);
        }

        /* --- Filtros --- */
        .filters {
            display: flex;
            gap: 1.5rem;
            align-items: flex-end;
            /* Alinea el botón con el select */
            flex-wrap: wrap;
        }

        .filters .form-group {
            display: flex;
            flex-direction: column;
        }

        .filters label {
            margin-bottom: 0.3rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .filters select {
            padding: 0.6rem;
            border-radius: 5px;
            border: 1px solid #ccc;
            min-width: 250px;
            /* Ancho para el selector de periodo */
        }

        .btn {
            padding: 0.6rem 1.5rem;
            /* Un poco más de padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            /* Para alinear ícono y texto */
            align-items: center;
            gap: 0.5rem;
            /* Espacio entre ícono y texto */
            font-size: 0.95rem;
            font-weight: bold;
            height: 42px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
            transition: background-color 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #145A32;
            /* Un verde más oscuro al pasar el mouse */
        }

        /* --- Estilos responsivos --- */
        @media (max-width: 768px) {
            .content {
                padding: 1rem;
            }

            .main-panel {
                padding: 1rem 1.2rem;
            }

            .main-panel h3 {
                font-size: 1.2rem;
            }

            .filters {
                flex-direction: column;
                align-items: stretch;
                /* Ocupan todo el ancho */
            }

            .filters .form-group,
            .filters select {
                width: 100%;
                min-width: 0;
            }

            .btn-primary {
                width: 100%;
                justify-content: center;
                /* Centra el contenido del botón */
            }
        }
    </style>
@endpush

@section('content')
    <div class="content">
        <h1>Central de Reportes</h1>
        <p class="report-description" style="margin-top: 0.5rem; margin-bottom: 2rem; font-size: 1.1rem;">
            Desde aquí puedes generar y descargar reportes consolidados en formato Excel para un análisis detallado de
            las operaciones.
        </p>

        <!-- Panel para el Reporte de Asistencias -->
        <div class="main-panel">
            <h3>Reporte Consolidado de Asistencias</h3>
            <p class="report-description">
                Este reporte generará un archivo Excel con el historial completo de asistencias de
                <strong>TODAS</strong>
                las secciones que pertenecen al periodo que selecciones. La descarga puede tardar unos segundos si hay
                muchos datos.
            </p>

            <form action="{{ route('encargadoSede.reportes.asistencias') }}" method="GET" target="_blank">
                {{-- Usar target="_blank" es una buena práctica para descargas, para no "bloquear" la página actual --}}
                {{-- @csrf --}}
                <div class="filters">
                    <div class="form-group">
                        <label for="periodo_asistencias">Selecciona el Periodo a Exportar</label>
                        <select id="periodo_asistencias" name="periodo_id" required>
                            <option value="">-- Seleccione un periodo --</option>
                            @foreach ($periodos as $p)
                                <option value="{{ $p->id }}">{{ $p->anio }} - {{ $p->ciclo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-file-excel"></i>
                        <span>Descargar Reporte</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Panel para el Reporte de Alumnos Matriculados -->
        {{-- <div class="main-panel">
                <h3>Reporte Consolidado de Alumnos Matriculados</h3>
                <p class="report-description">
                    Genera una lista maestra en Excel con todos los alumnos inscritos en el periodo seleccionado, 
                    incluyendo los detalles de sus apoderados, sección y docente a cargo.
                </p>
                
                <form action="" method="POST" target="_blank">
                    @csrf
                    <div class="filters">
                        <div class="form-group">
                            <label for="periodo_alumnos">Selecciona el Periodo a Exportar</label>
                            <select id="periodo_alumnos" name="periodo_id" required>
                                <option value="">-- Seleccione un periodo --</option>
                                @foreach ($periodos as $p)
                                    <option value="{{ $p->id }}">{{ $p->anio }} - {{ $p->ciclo }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-file-excel"></i>
                            <span>Descargar Reporte</span>
                        </button>
                    </div>
                </form>
            </div> --}}

        <!-- Puedes seguir añadiendo más paneles para futuros reportes aquí -->

    </div>
@endsection
