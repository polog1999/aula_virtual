@extends('layouts.app')
@push('styles')
@endpush
<style>
    :root {
        --primary-color: #1E8449;
        --secondary-color: #2ECC71;
        --light-green: #D5F5E3;
        --dark-gray: #34495E;
        --light-gray: #ECF0F1;
        --white: #ffffff;
        --info: #3498DB;
    }

</style>
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/docente/talleres.css') }}">
@endpush

@section('content')
    <div class="content">
        <h1>Mis Cursos Asignados</h1>
        <div class="content-card">
            <h3>Periodo: {{$secciones->first()->periodo->anio ?? ''}} - {{$secciones->first()->periodo->ciclo ?? ''}}</h3>
            <ul class="course-list">
                @forelse ($secciones as $seccion)
                    <li class="course-item">
                        <div>
                            <h4>{{ $seccion->talleres->disciplina->nombre }} (@if ($seccion->talleres->categoria->tiene_discapacidad)
                                    Para personas con discapacidad
                                @elseif($seccion->talleres->categoria->edad_min && $seccion->talleres->categoria->edad_max)
                                    De {{ $seccion->talleres->categoria->edad_min }} a
                                    {{ $seccion->talleres->categoria->edad_max }} años
                                @elseif($seccion->talleres->categoria->edad_min)
                                    De {{ $seccion->talleres->categoria->edad_min }} años a más
                                @else
                                    Todas las edades
                                @endif) - {{ $seccion->nombre }}</h4>
                                <p>Horario: {{$seccion->dia_semana}}</p>
                                <p>Sede: {{$seccion->lugares->nombre}}</p>
                            {{-- @foreach ($seccion->horarios as $h)
                                <p> {{ $h->dia_semana }} | {{ $h->hora_inicio }} - {{ $h->hora_fin }}</p>
                            @endforeach --}}
                        </div>
                        <!-- Se añade la clase 'ver-alumnos-btn' y un atributo 'data-taller-nombre' -->
                        <a href="#" class="btn btn-info ver-alumnos-btn" id="btnAlumnos"
                            data-seccion-nombre="{{ $seccion->nombre }}" data-alumnos='@json($seccion->matriculas)'>Ver
                            Alumnos</a>
                    </li>
                @empty
                No hay talleres.
                @endforelse
            </ul>
        </div>
 
    </div>
@endsection
{{-- </main> --}}
{{-- </div> --}}
@section('modals')
    <!-- --- HTML del Modal de Alumnos --- -->
    <div id="alumnosModal" class="modal">
        <div class="modal-content" style="overflow-x: auto;">
            <div class="modal-header">
                <span class="close-button">&times;</span>
                <h4 id="modalTallerNombre">Lista de Alumnos</h4>
            </div>
            <div class="modal-body">
                <!-- Aquí se cargarían los datos de los alumnos dinámicamente -->
                <table>
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>DNI</th>
                            <th>Apellidos y Nombres</th>
                            <th>Edad</th>
                            <th>Contacto Apoderado</th>
                        </tr>
                    </thead>
                    <tbody id="tablaAlumnosBody">
                        <!-- Ejemplo de datos estáticos -->


                        {{-- <tr>
                            <td>2</td>
                            <td>Martinez, Luis</td>
                            <td>9</td>
                            <td>912345678</td>
                        </tr>
                         <tr>
                            <td>3</td>
                            <td>Perez, Sofia</td>
                            <td>10</td>
                            <td>955555555</td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        // Script existente para el menú lateral
        // document.getElementById('menu-toggle').addEventListener('click', function() {
        //     document.getElementById('sidebar').classList.toggle('open');
        // });

        // --- Script para el Modal ---

        // Obtener el modal
        const modal = document.getElementById('alumnosModal');

        // Obtener el elemento <span> que cierra el modal
        const span = document.getElementsByClassName('close-button')[0];

        // Obtener el título del modal para actualizarlo
        const modalTitle = document.getElementById('modalTallerNombre');

        // Obtener todos los botones que abren el modal
        const btns = document.querySelectorAll('.ver-alumnos-btn');

        // Añadir un evento de click a cada botón
        btns.forEach(btn => {
            btn.addEventListener('click', function(event) {
                event.preventDefault(); // Evita que el enlace '#' recargue la página

                tbody = document.getElementById("tablaAlumnosBody");
                tbody.innerHTML = '';
                // Obtener el nombre del taller desde el atributo data
                const tallerNombre = this.getAttribute('data-seccion-nombre');

                // Actualizar el título del modal
                modalTitle.textContent = 'Alumnos Inscritos en: ' + tallerNombre;

                // En una aplicación real, aquí harías una llamada (AJAX/Fetch)
                // para obtener la lista de alumnos de este taller específico
                // y poblar la tabla del modal.

                // Mostrar el modal
                modal.style.display = 'block';
                let matriculas = JSON.parse(this.dataset.alumnos);
                // console.log(matriculas);
                matriculas.forEach((m, i) => {
                    let edad = calcularEdad(m.alumnos.user.fecha_nacimiento);
                    // let edad = calcularEdad('2013-02-15');
                    // console.log(m.alumnos.user.fecha_nacimiento);
                    // console.log(edad);
                    // console.log(m.alumnos.padre);
                    agregarFila(i + 1, m.alumnos.user.numero_documento, m.alumnos.user.nombres, m
                        .alumnos.user.apellido_paterno, m.alumnos.user.apellido_materno,
                        edad, m.alumnos.padre?.user.telefono, m.alumnos.padre?.user.nombres);
                });
            });
        });

        function calcularEdad(fecha) {
            var hoy = new Date();
            var cumpleanos = new Date(fecha);
            var edad = hoy.getFullYear() - cumpleanos.getFullYear();
            var m = hoy.getMonth() - cumpleanos.getMonth();

            if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
                edad--;
            }

            return edad;
        }

        function agregarFila(num, numDocumento, nombre, primerApe, segundoApe, edad, numTelefono, apoNombre) {
            let tbody = document.getElementById("tablaAlumnosBody");

            let fila = document.createElement("tr");
            fila.innerHTML = `
            <td>${num}</td>
            <td>${numDocumento}</td>
            <td>${nombre} ${primerApe} ${segundoApe}</td>
            <td>${edad}</td>
            <td>${numTelefono ?? ''} - ${apoNombre ?? 'Sin apoderado'}</td>

        `;

            tbody.appendChild(fila);
        }

        // Cuando el usuario hace clic en <span> (x), cerrar el modal
        span.onclick = function() {
            modal.style.display = 'none';
        }

        // Cuando el usuario hace clic fuera del modal, cerrarlo
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
@endpush
