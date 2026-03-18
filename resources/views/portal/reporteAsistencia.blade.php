@extends('layouts.app')

    @section('vista', 'Reporte de Asistencias')
    @push('styles')
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
            --info-blue: #3498DB;
        }

        /* --- Estilos base (sin cambios) --- */
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
            color: var(--primary-color);
        }

        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filters .form-group {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            min-width: 160px;
        }

        .filters label {
            margin-bottom: 0.3rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .filters input,
        .filters select {
            padding: 0.6rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 0.9rem;
            font-weight: bold;
            height: 42px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }

        /* --- Estilos de la Tabla de Reporte (sin cambios) --- */
        .report-table-container {
            overflow-x: auto;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
            min-width: 800px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #ddd;
            padding: 0.5rem;
            text-align: center;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .report-table th {
            background-color: var(--light-green);
            font-weight: 600;
        }

        .report-table td:first-child {
            text-align: left;
            font-weight: 500;
            white-space: nowrap;
            background: var(--white);
        }

        /* --- Leyenda e Iconos (sin cambios) --- */
        .legend {
            margin-top: 1rem;
            display: flex;
            gap: 1.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            color: white;
            font-weight: bold;
            line-height: 24px;
            font-size: 0.9rem;
        }

        .icon-asistio {
            background-color: var(--secondary-color);
        }

        .icon-falto {
            background-color: var(--danger);
        }

        .icon-tardanza {
            background-color: var(--warning);
        }

        .icon-justificado {
            background-color: var(--info-blue);
        }

        /* ================================================= */
        /* --- INICIO: NUEVOS ESTILOS PARA LA COLUMNA DE RESUMEN --- */
        /* ================================================= */
        .report-table .summary-col {
            width: 180px;
            /* Ancho fijo para la columna de resumen */
            min-width: 180px;
            text-align: left;
            padding: 0.5rem 0.8rem;
        }

        .percentage {
            font-size: 1.2rem;
            font-weight: bold;
            display: block;
            margin-bottom: 0.25rem;
        }

        /* Colores condicionales para el porcentaje */
        .percentage.high {
            color: var(--primary-color);
        }

        .percentage.medium {
            color: var(--warning);
        }

        .percentage.low {
            color: var(--danger);
        }

        .summary-details {
            font-size: 0.8rem;
            color: #555;
            line-height: 1.4;
        }

        /* ================================================= */
        /* --- FIN: NUEVOS ESTILOS --- */
        /* ================================================= */

        /* --- Estilos Responsivos (modificados) --- */
        @media (max-width: 768px) {
            .content {
                padding: 1rem;
            }

            .filters {
                flex-direction: column;
                align-items: stretch;
                gap: 0.8rem;
            }

            .btn-primary {
                width: 100%;
                margin-top: 0.5rem;
            }

            .report-table th,
            .report-table td {
                font-size: 0.8rem;
                padding: 0.4rem;
                min-width: 40px;
            }

            /* --- Técnica STICKY (modificada para incluir la nueva columna) --- */
            .report-table th {
                position: -webkit-sticky;
                position: sticky;
                top: 0;
                z-index: 2;
            }

            .report-table td:first-child,
            .report-table th:first-child {
                position: -webkit-sticky;
                position: sticky;
                left: 0;
                z-index: 1;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            }

            .report-table th:first-child {
                z-index: 3;
            }

            /* NUEVO: Hacer que la columna de resumen también sea fija a la derecha */
            .report-table td.summary-col,
            .report-table th.summary-col {
                position: -webkit-sticky;
                position: sticky;
                right: 0;
                z-index: 1;
                background: #fdfdfd;
                /* Fondo ligeramente diferente para destacar */
                box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            }

            .report-table th.summary-col {
                z-index: 3;
                /* Para que esté por encima de todo en la esquina */
            }
        }
    </style>
    @endpush

    @section('content')
        <div class="content">
            <h1>Reporte de Asistencia Mensual</h1>

            <!-- Panel de Filtros (sin cambios) -->
            <div class="main-panel">
                <h3>Filtros de Búsqueda</h3>
                <form action="{{ route('encargadoSede.asistencias.reporte') }}" method="GET">
                    <div class="filters">
                        {{-- Tus filtros aquí (sin cambios) --}}
                        <div class="form-group">
                            <label for="periodo">Periodo (Año)</label>
                            <select id="periodo" name="periodo" required>
                                <option value="">Seleccione</option>
                                @foreach ($periodos as $p)
                                    <option value="{{ $p->id }}"
                                        {{ request('periodo') == $p->id ? 'selected' : '' }}>
                                        {{ $p->anio }} - {{ $p->ciclo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sede">Sede</label>
                            <select id="sede" name="sede" required>
                                <option value="">Seleccione una sede</option>
                                @foreach ($sedes as $sede)
                                    <option value="{{ $sede->id }}"
                                        {{ request('sede') == $sede->id ? 'selected' : '' }}>{{ $sede->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="disciplina">Disciplina deportiva</label>
                            <select id="disciplina" name="disciplina" required>
                                <option value="">Selecciona una disciplina</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="docente">Docente</label>
                            <select id="docente" name="docente" required>
                                <option value="">Selecciona un docente</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="seccion">Seccion</label>
                            <select id="seccion" name="seccion" required>
                                <option value="">Selecciona una sección</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mes">Mes</label>
                            <select id="mes" name="mes" required>
                                <option value="">Selecciona un mes</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ request('mes') == $m ? 'selected' : '' }}>
                                        {{ Carbon\Carbon::create()->month($m)->locale('es')->monthName }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Ver</button>
                        {{-- <a class="btn btn-primary">Exportar asistencias a Excel</a> --}}
                    </div>
                </form>
            </div>

            @if ($estudiantesReporte->isNotEmpty())
                <div class="main-panel">
                    <h3>Reporte de {{ ucwords($nombreMesSeleccionado) }}</h3>

                    <div class="legend">
                        {{-- Tu leyenda aquí (sin cambios) --}}
                        <strong>Leyenda:</strong>
                        <div class="legend-item"><span class="status-icon icon-asistio">✔</span> Presente</div>
                        <div class="legend-item"><span class="status-icon icon-falto">✖</span> Faltó</div>
                        <div class="legend-item"><span class="status-icon icon-tardanza">T</span> Tardanza</div>
                    </div>

                    <div class="report-table-container">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Estudiantes | Fecha</th>
                                    @for ($i = 0; $i < $diasDelMes->count(); $i++)
                                        <th>{{ $diasDelMes[$i]->day }}</th>
                                    @endfor
                                    {{-- CAMBIO: Añadir la cabecera de la nueva columna --}}
                                    <th class="summary-col">Resumen de Asistencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estudiantesReporte as $estudiante)
                                    <tr>
                                        <td>{{ $estudiante->apellido_paterno }} {{ $estudiante->apellido_materno }},
                                            {{ $estudiante->nombres }}</td>

                                        @for ($i = 0; $i < $diasDelMes->count(); $i++)
                                            <td>
                                                @if (isset($estudiante->asistencias_por_dia[$diasDelMes[$i]->day]))
                                                    @switch($estudiante->asistencias_por_dia[$diasDelMes[$i]->day])
                                                        @case('ASISTIO')
                                                            <span class="status-icon icon-asistio" title="Asistió">✔</span>
                                                        @break

                                                        @case('FALTO')
                                                            <span class="status-icon icon-falto" title="Faltó">✖</span>
                                                        @break

                                                        @case('TARDANZA')
                                                            <span class="status-icon icon-tardanza" title="Tardanza">T</span>
                                                        @break

                                                        @case('JUSTIFICADO')
                                                            <span class="status-icon icon-justificado" title="Justificado">J</span>
                                                        @break
                                                    @endswitch
                                                @endif
                                            </td>
                                        @endfor

                                        {{-- =============================================== --}}
                                        {{-- INICIO: CÓDIGO PARA LA NUEVA COLUMNA DE RESUMEN --}}
                                        {{-- =============================================== --}}
                                        <td class="summary-col">
                                            {{-- Asumimos que tu controlador ya calculó y añadió estos datos al objeto $estudiante --}}
                                            @php
                                                $porcentaje = $estudiante->porcentaje_asistencia ?? 0;
                                                $colorClass = 'low';
                                                if ($porcentaje >= 85) {
                                                    $colorClass = 'high';
                                                } elseif ($porcentaje >= 60) {
                                                    $colorClass = 'medium';
                                                }
                                            @endphp
                                            <span class="percentage {{ $colorClass }}">{{ number_format($porcentaje,2) }}%</span>
                                            <div class="summary-details">
                                                <span>A: {{ $estudiante->total_asistencias ?? 0 }}</span> |
                                                <span>F: {{ $estudiante->total_faltas ?? 0 }}</span> |
                                                <span>T: {{ $estudiante->total_tardanzas ?? 0 }}</span><br>
                                                <small>Total Clases: {{ $estudiante->total_clases_mes ?? 0 }}</small>
                                            </div>
                                        </td>
                                        {{-- =============================================== --}}
                                        {{-- FIN: CÓDIGO DE LA NUEVA COLUMNA --}}
                                        {{-- =============================================== --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif(request('mes'))
                <div class="main-panel">
                    <p>No se encontraron estudiantes o asistencias para los filtros seleccionados.</p>
                </div>
            @endif

        </div>
    @endsection

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(function() {
                function getParameterByName(name) {
                    const url = window.location.href;
                    name = name.replace(/[\[\]]/g, '\\$&');
                    const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
                    const results = regex.exec(url);
                    if (!results) return null;
                    if (!results[2]) return '';
                    return decodeURIComponent(results[2].replace(/\+/g, ' '));
                }

                // const disciplinaId = getParameterByName('disciplina');
                // const seccionId = getParameterByName('seccion');
                // const periodoId = $("#periodo").val();

                const sedeId = getParameterByName('sede');
                const disciplinaId = getParameterByName('disciplina');
                const seccionId = getParameterByName('seccion');
                const docenteId = getParameterByName('docente');
                const periodoId = $("#periodo").val();

                // if (disciplinaId && periodoId) {
                //     $.ajax({
                //         url: '/encargado-sede/secciones/' + periodoId + '/' + disciplinaId,
                //         type: 'GET',
                //         success: function(data) {
                //             $('#seccion').empty().append(
                //                 '<option value="">-- Selecciona una sección --</option>');
                //             $.each(data, function(key, value) {
                //                 $('#seccion').append('<option value="' + value.id + '">' + value
                //                     .nombre + '</option>');
                //             });
                //             if (seccionId) {
                //                 $('#seccion').val(seccionId);
                //             }
                //         }
                //     });
                // }
                // Si hay un disciplinaId en la URL, seleccionarlo
                if (disciplinaId) {
                    // $("#disciplina").val(disciplinaId);

                    // Disparar el evento change para cargar las secciones por AJAX
                    $('#disciplina').empty().append(
                        '<option value="">Cargando...</option>');
                    $.ajax({
                        url: '/encargado-sede/deportes/' + periodoId + '/' + sedeId,
                        type: 'GET',
                        success: function(data) {
                            $('#disciplina').empty().append(
                                '<option value="">-- Selecciona un deporte --</option>');
                            $.each(data, function(key, value) {
                                $('#disciplina').append('<option value="' + value.id +
                                    '">' + value.nombre + '</option>');
                            });

                            // Si hay una disciplina en la URL, seleccionarla
                            if (disciplinaId) {
                                $('#disciplina').val(disciplinaId);
                            }
                        }
                    });
                }

                if (docenteId) {
                    // $("#disciplina").val(disciplinaId);
                    $('#docente').empty().append(
                        '<option value="">Cargando...</option>');
                    // Disparar el evento change para cargar las secciones por AJAX
                    $.ajax({
                        url: '/encargado-sede/docentes/' + periodoId + '/' + sedeId + '/' + disciplinaId,
                        type: 'GET',
                        success: function(data) {
                            $('#docente').empty().append(
                                '<option value="">-- Selecciona un docente --</option>');
                            $.each(data, function(key, value) {
                                $('#docente').append('<option value="' + value.id +
                                    '">' + value.nombres + '</option>'
                                );
                            });

                            // Si hay una sección en la URL, seleccionarla
                            if (docenteId) {
                                $('#docente').val(docenteId);
                            }
                        }
                    });
                }
                if (seccionId) {
                    // $("#disciplina").val(disciplinaId);

                    // Disparar el evento change para cargar las secciones por AJAX
                    $('#seccion').empty().append(
                        '<option value="">Cargando...</option>');
                    $.ajax({
                        url: '/encargado-sede/secciones/' + periodoId + '/' + sedeId + '/' + disciplinaId +
                            '/' + docenteId,
                        type: 'GET',
                        success: function(data) {
                            $('#seccion').empty().append(
                                '<option value="">-- Selecciona una sección --</option>');
                            $.each(data, function(key, value) {
                                $('#seccion').append('<option value="' + value.id +
                                    '">' + value.nombre + ' (' + value.dia_semana +
                                    ') </option>'
                                );
                            });

                            // Si hay una sección en la URL, seleccionarla
                            if (seccionId) {
                                $('#seccion').val(seccionId);
                            }
                        }
                    });
                }
                $('#sede').on('change', function() {
                    console.log('Funciona')
                    var sedeId = $(this).val();
                    var periodoId = $("#periodo").val();
                    if (sedeId) {
                        $('#disciplina').empty().append(
                            '<option value="">Cargando...</option>');
                        $.ajax({
                            url: '/encargado-sede/deportes/' + periodoId + '/' + sedeId,
                            type: 'GET',
                            success: function(data) {
                                $('#disciplina').empty().append(
                                    '<option value="">-- Selecciona un deporte --</option>');
                                $('#docente').empty().append(
                                    '<option value="">-- Selecciona un deporte --</option>');
                                $('#seccion').empty().append(
                                    '<option value="">-- Selecciona un deporte --</option>');
                                $.each(data, function(key, value) {
                                    $('#disciplina').append('<option value="' + value.id +
                                        '">' + value.nombre + '</option>');
                                });
                            }
                        });
                    }
                });
                // Cuando cambia la disciplina
                $('#disciplina').on('change', function() {
                    var disciplinaId = $(this).val();
                    var periodoId = $("#periodo").val();
                    var sedeId = $("#sede").val()
                    if (disciplinaId) {
                        $('#docente').empty().append(
                            '<option value="">Cargando...</option>');
                        $.ajax({
                            url: '/encargado-sede/docentes/' + periodoId + '/' + sedeId + '/' +
                                disciplinaId,
                            type: 'GET',
                            success: function(data) {
                                $('#docente').empty().append(
                                    '<option value="">-- Selecciona un docente --</option>');
                                $('#seccion').empty().append(
                                    '<option value="">-- Selecciona un deporte --</option>');
                                $.each(data, function(key, value) {
                                    $('#docente').append('<option value="' + value.id +
                                        '">' + value.nombres + '</option>'
                                    );
                                });
                            }
                        });
                    }
                });
                //Cuando cambia Docente
                $('#docente').on('change', function() {
                    var disciplinaId = $("#disciplina").val();
                    var periodoId = $("#periodo").val();
                    var sedeId = $("#sede").val()
                    var docenteId = $(this).val()
                    if (docenteId) {
                        $('#seccion').empty().append(
                            '<option value="">Cargando...</option>');
                        $.ajax({
                            url: '/encargado-sede/secciones/' + periodoId + '/' + sedeId + '/' +
                                disciplinaId +
                                '/' + docenteId,
                            type: 'GET',
                            success: function(data) {
                                $('#seccion').empty().append(
                                    '<option value="">-- Selecciona una sección --</option>');
                                $.each(data, function(key, value) {
                                    $('#seccion').append('<option value="' + value.id +
                                        '">' + value.nombre + ' (' + value.dia_semana +
                                        ') </option>'
                                    );
                                });
                            }
                        });
                    }
                });

                // $('#disciplina, #periodo').on('change', function() {
                //     var disciplinaId = $("#disciplina").val();
                //     var periodoId = $("#periodo").val();
                //     if (disciplinaId && periodoId) {
                //         $('#seccion').empty().append('<option value="">Cargando...</option>');
                //         $.ajax({
                //             url: '/encargado-sede/secciones/' + periodoId + '/' + disciplinaId,
                //             type: 'GET',
                //             success: function(data) {
                //                 $('#seccion').empty().append(
                //                     '<option value="">-- Selecciona una sección --</option>');
                //                 $.each(data, function(key, value) {
                //                     $('#seccion').append('<option value="' + value.id + '">' + value.nombre + '</option>');
                //                 });
                //             }
                //         });
                //     }
                // });
            });
        </script>
    @endpush

