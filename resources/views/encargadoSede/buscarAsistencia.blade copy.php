@extends('layouts.encargadoSede.app')
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @section('vista', 'Asistencias')
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
        }

        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
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

        .filters input,
        .filters select {
            padding: 0.6rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .attendance-table th,
        .attendance-table td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }

        .attendance-table th {
            font-weight: 600;
            background-color: var(--light-green);
        }

        .attendance-options label {
            margin-right: 1rem;
            cursor: pointer;
        }

        .attendance-options input[type="radio"] {
            margin-right: 0.3rem;
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
        }

        .btn-success {
            background-color: var(--secondary-color);
            color: var(--dark-gray);
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .actions-footer {
            text-align: right;
            margin-top: 1.5rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100%;
                transform: translateX(-100%);
                z-index: 1000;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>

<body>
    @section('content')
        <div class="content">
            <h1>Registro de Asistencia</h1>

            <!-- Panel de Filtros -->

            <div class="main-panel">
                <h3>Filtros de Búsqueda</h3>
                <form action="{{ route('encargadoSede.asistencias.index') }}" method="GET">
                    <div class="filters">
                        <div class="form-group">
                            <label for="periodo">Periodo</label>
                            <select id="periodo" name="periodo" required>
                                <option value="">Seleccione un periodo</option>
                                @foreach ($periodos as $p)
                                    <option value="{{ $p->id }}"
                                        {{ request('periodo') == $p->id ? 'selected' : '' }}>{{ $p->anio }} -
                                        {{ $p->ciclo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- {{dd($talleres)}} --}}
                        <div class="form-group">
                            <label for="sede">Sede</label>
                            <select id="sede" name="sede" required>
                                <option value="">Seleccione una sede</option>
                                @foreach ($sedes as $sede)
                                    <option value="{{ $sede->id }}"
                                        {{ request('sede') == $sede->id ? 'selected' : '' }}>{{ $sede->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="disciplina">Disciplina deportiva</label>
                            <select id="disciplina" name="disciplina" required>
                                <option value="">Seleccione una disciplina deportiva</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="docente">Docente</label>
                            <select id="docente" name="docente" required>
                                <option value="">Seleccione una docente</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="seccion">Seccion</label>
                            <select id="seccion" name="seccion" required>
                                <option value="">Seleccione una Seccion</option>
                                {{-- @foreach ($disciplinas as $d)
                                    <option value="{{ $d->id }}"
                                        {{ request('seccion') == $d->id ? 'selected' : '' }}>{{ $d->nombre }}
                                    </option>
                                @endforeach --}}
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label for="categoria">Categoría de edad</label>
                            <select id="categoria" name="categoria" required>
                                <option value="">Seleccione un Categoría de edad</option> --}}

                        {{-- @foreach ($categorias as $c)
                                        <option value="{{ $c->id }}"
                                            {{ request('categoria') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}
                                        </option>
                                    @endforeach --}}
                        {{-- </select>
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="docente">Docente</label>
                            <select id="docente" name="docente">
                                <option value="">Seleccione un docente</option> --}}
                        {{-- @foreach ($docentes as $docente)
                                        <option value="{{ $docente->user->id }}"
                                            {{ request('docente') == $docente->user->id ? 'selected' : '' }}>
                                            {{ $docente->user->nombres }} {{ $docente->user->apellido_paterno }}
                                            {{ $docente->user->apellido_materno }}</option>
                                    @endforeach --}}
                        {{-- </select>
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="horario">Horario</label>
                            <select id="horario" name="horario">
                                <option value="">Seleccione un horario</option> --}}
                        {{-- @foreach ($secciones as $seccion)
                                        <option value="{{ $seccion->horarios->id }}" >
                                            {{ $seccion->dia_semana }}</option>
                                    @endforeach --}}
                        {{-- </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" id="fecha" name="fecha"
                                value="{{ request('fecha') ? request('fecha') : now()->toDateString() }}">
                        </div>

                        <button type="submit" class="btn btn-primary" style="align-self: flex-end;">Ver</button>
                    </div>
                </form>
                <form action="{{ route('encargadoSede.asistencias.index') }}">
                    <button type="submit" class="btn btn-primary" style="align-self: flex-end;">Borrar
                        Filtros</button>
                </form>
                @php
                    $fecha = request('fecha') ?? now()->toDateString();
                    $disciplina = request('disciplina');
                    // $categoria = request('categoria');
                    // $docente = request('docente');
                @endphp

                {{-- <a id="btnCrearAsistencia" href="#" target="_blank" class="btn btn-primary"
                    style="margin-top: 1rem; pointer-events: none; opacity: 0.5;">
                    Crear nueva Asistencia
                </a> --}}


            </div>


            @if ($asistencias != null && $matriculas == null)
                <!-- Panel de Asistencia de Alumnos -->
                <form action="{{ route('encargadoSede.asistencias.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="fecha" value="{{ request('fecha') }}">
                    <div class="main-panel">
                        <h3>Asistencia de Alumnos - {{ $disciplina1->nombre ?? '' }} {{ $seccion->nombre }}- Editar
                            ({{ $categoriaSeleccionada->nombre ?? '' }})</h3>
                        <table class="attendance-table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Apellidos y Nombres</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($asistencias as $i => $a)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            {{ $a->ape_paterno }}
                                            {{ $a->ape_materno }},
                                            {{ $a->nombres }}</td>

                                        <td class="attendance-options">
                                            <div class="form-group">
                                                <select id="disciplina" name="asistencias[{{ $a->matricula->id }}]"
                                                    required>
                                                    <option value="ASISTIO"
                                                        {{ $a->estado == 'ASISTIO' ? 'selected' : '' }}>
                                                        P
                                                    </option>
                                                    <option value="TARDANZA"
                                                        {{ $a->estado == 'TARDANZA' ? 'selected' : '' }}>
                                                        T
                                                    </option>
                                                    <option value="FALTO" {{ $a->estado == 'FALTO' ? 'selected' : '' }}>
                                                        F
                                                    </option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="actions-footer">
                            <button class="btn btn-success" type="submit">Guardar Asistencia</button>
                        </div>
                    </div>
                </form>
            @elseif(request('periodo') && $asistencias->isEmpty() && $matriculas != null)
                @if ($matriculas->count() > 0)
                    <!-- Panel de Asistencia de Alumnos -->
                    <div class="main-panel">
                        {{-- No se encontraron registros de asistencia para la fecha {{request('fecha')}} --}}
                        <form action="{{ route('encargadoSede.guardarAsistencias.store') }}" method="POST">
                            @csrf
                            <input type="date" name="fechaAsistencia" value="{{ $fecha }}" hidden>
                            <div class="main-panel">
                                <h3>Asistencia de Alumnos - {{ $disciplina1->nombre }} {{ $seccion->nombre ?? '' }} -
                                    Nuevo
                                </h3>
                                <table class="attendance-table">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Apellidos y Nombres</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($matriculas as $i => $matricula)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $matricula->alumnos->user->apellido_paterno }}
                                                    {{ $matricula->alumnos->user->apellido_materno }},
                                                    {{ $matricula->alumnos->user->nombres }}</td>
                                                </td>

                                                <td class="attendance-options">
                                                    <div class="form-group">
                                                        <select id="disciplina" name="asistencias[{{ $matricula->id }}]"
                                                            required>
                                                            <option value="ASISTIO">
                                                                P
                                                            </option>
                                                            <option value="TARDANZA">
                                                                T
                                                            </option>
                                                            <option value="FALTO">
                                                                F
                                                            </option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="actions-footer">
                                    <button class="btn btn-success"type="submit">Guardar Asistencia</button>
                                </div>
                            </div>
                        </form>

                    </div>
                @endif
            @endif


        </div>
    @endsection
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(function() {

                // Función para obtener parámetros de la URL
                function getParameterByName(name) {
                    const url = window.location.href;
                    const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
                    const results = regex.exec(url);
                    if (!results) return null;
                    if (!results[2]) return '';
                    return decodeURIComponent(results[2].replace(/\+/g, ' '));
                }

                // Leer los valores desde la URL (si existen)
                const sedeId = getParameterByName('sede');
                const disciplinaId = getParameterByName('disciplina');
                const seccionId = getParameterByName('seccion');
                const docenteId = getParameterByName('docente');
                const periodoId = $("#periodo").val();

                // Si hay un disciplinaId en la URL, seleccionarlo
                if (disciplinaId) {
                    // $("#disciplina").val(disciplinaId);

                    // Disparar el evento change para cargar las secciones por AJAX
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

            });
            // Cuando cambia la sede
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
                        url: '/encargado-sede/docentes/' + periodoId + '/' + sedeId + '/' + disciplinaId,
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
                        }
                    });
                }
            });

            // $('#seccion').on('change', function() {
            //     var seccionId = $(this).val();
            //     var periodoId = $("#periodo").val();
            //     var disciplinaId = $("#disciplina").val();
            //     if (seccionId) {
            //         $.ajax({
            //             url: '/encargado-sede/horarios/' + periodoId + '/' + disciplinaId+ '/' + seccionId,
            //             type: 'GET',
            //             success: function(data) {
            //                 // $('#categoria').empty().append(
            //                 //     '<option value="">-- Selecciona una categoría --</option>');
            //                 // $('#docente').empty().append(
            //                 //     '<option value="">-- Selecciona un docente --</option>');

            //                 $('#horario').empty().append(
            //                     '<option value="">-- Selecciona un horario --</option>');
            //                 $.each(data, function(key, value) {
            //                     $('#horario').append('<option value="' + value.id + '">' + value
            //                         .dia_semana + '</option>');
            //                 });
            //             }
            //         });
            //     }
            // });

            // $('#categoria').on('change', function() {
            //     var categoriaId = $(this).val();
            //     var disciplinaId = $("#disciplina").val();
            //     if (categoriaId) {
            //         $.ajax({
            //             url: '/encargado-sede/docentes/' + disciplinaId + '/' + categoriaId,
            //             type: 'GET',
            //             success: function(data) {
            //                 $('#docente').empty().append(
            //                     '<option value="">-- Selecciona un docente --</option>');
            //                 $('#horario').empty().append(
            //                     '<option value="">-- Selecciona un horario --</option>');
            //                 $.each(data, function(key, value) {
            //                     $('#docente').append('<option value="' + value.user_id + '">' +
            //                         value
            //                         .nombres + ' ' + value.apellido_paterno + ' ' +
            //                         value.apellido_materno + '</option>');
            //                 });
            //             }
            //         });
            //     }
            // });
            // $('#docente').on('change', function() {
            //     var docenteId = $(this).val();
            //     var disciplinaId = $("#disciplina").val();
            //     var categoriaId = $("#categoria").val();
            //     var periodoId = $("#periodo").val();
            //     if (docenteId) {
            //         $.ajax({
            //             url: '/encargado-sede/horarios/'  + periodoId + '/'+ disciplinaId + '/' + seccionId + '/' + docenteId,
            //             type: 'GET',
            //             success: function(data) {
            //                 $('#horario').empty().append(
            //                     '<option value="">-- Selecciona un horario --</option>');
            //                 $.each(data, function(key, value) {
            //                     $('#horario').append('<option value="' + value.id + '">' + value
            //                         .dia_semana + '</option>');
            //                 });
            //             }
            //         });
            //     }
            // });
        </script>

        <script>
            document.getElementById('menu-toggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('open');
            });
        </script>
        <script>
            function actualizarBotonCrear() {
                const periodo = document.getElementById('periodo').value;
                const fecha = document.getElementById('fecha').value;
                const disciplina = document.getElementById('disciplina').value;
                const seccion = document.getElementById('seccion').value;
                // const categoria = document.getElementById('categoria').value;
                // const docente = document.getElementById('docente').value;

                const btn = document.getElementById('btnCrearAsistencia');

                if (fecha && disciplina && periodo && seccion) {
                    // Construimos la URL con los parámetros
                    const url = `/encargado-sede/crear-asistencia/${periodo}/${disciplina}/${seccion}/${fecha}`;
                    btn.href = url;
                    btn.style.pointerEvents = 'auto';
                    btn.style.opacity = '1';
                } else {
                    // Desactivamos el botón
                    btn.href = '#';
                    btn.style.pointerEvents = 'none';
                    btn.style.opacity = '0.5';
                }
            }

            // Detectar cambios en los filtros
            document.getElementById('fecha').addEventListener('change', actualizarBotonCrear);
            document.getElementById('disciplina').addEventListener('change', actualizarBotonCrear);
            document.getElementById('seccion').addEventListener('change', actualizarBotonCrear);
            // document.getElementById('categoria').addEventListener('change', actualizarBotonCrear);
            // document.getElementById('docente').addEventListener('change', actualizarBotonCrear);

            // Ejecutar al cargar la página (por si ya hay filtros seleccionados)
            actualizarBotonCrear();
        </script>
    @endpush


</body>

</html>
