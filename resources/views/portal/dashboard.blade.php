@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush

@section('vista', 'Dashboard')

@section('content')
    <div class="content">
        <div id="dashboard-view">
            <h1>Dashboard Principal</h1>

            <!-- INICIO: Formulario de Filtro de Ingresos -->
            <div class="filter-container">
                <form action="{{-- {{ route('portal.dashboard') }} --}}" method="GET" class="filter-form" id="filtros">
                    <div class="form-group">
                        <label for="anio">Año</label>
                        <select name="anio" id="anio">
                            @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}"
                                    {{ request('anio', date('Y')) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mes">Mes</label>
                        <select name="mes" id="mes">
                            <option value="todos">-- Todos --</option>
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('mes', 'todos') == $m ? 'selected' : '' }}>
                                    {{ Str::ucfirst(Carbon\Carbon::create()->month($m)->monthName) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <button type="submit" class="btn btn-primary">Filtrar</button> --}}
                    <a href="{{ route('portal.dashboard') }}" class="btn btn-primary">Borrar Filtro</a>
                </form>
            </div>
            <!-- FIN: Formulario de Filtro de Ingresos -->

            <div class="dashboard-cards">
                <div class="card">
                    <h4>Alumnos Inscritos</h4>
                    <div class="value">{{ $num_alumnos ?? 0 }}</div>
                    <div class="description">Total de alumnos matriculados</div>
                </div>
                <div class="card">
                    <h4>Secciones Activas</h4>
                    <div class="value">{{ $num_tall_activos ?? 0 }}</div>
                    <div class="description">Oferta académica actual</div>
                </div>
                <div class="card">
                    <h4>Docentes</h4>
                    <div class="value">{{ $num_docentes ?? 0 }}</div>
                    <div class="description">Personal docente registrado</div>
                </div>
                <div class="card">
                    <h4>Ingresos</h4>
                    <div class="value">S/ {{ number_format($ingresos ?? 0, 2) }}</div>
                    <div class="description">{{ $periodo_ingresos ?? 'No se encontró data' }}</div>
                </div>
            </div>

            <div class="table-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3>Últimos Talleres Creados</h3>
                </div>
                <div style="width: 100%;overflow: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Sección</th>
                                <th>Docente</th>
                                <th>Inscritos</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($secciones as $seccion)
                                <tr>
                                    <td>{{ $seccion->talleres->disciplina->nombre }} ({{ $seccion->nombre }})</td>
                                    <td>{{ $seccion->docentes ? $seccion->docentes->user->nombres . ' ' . $seccion->docentes->user->apellido_paterno . ' ' . $seccion->docentes->user->apellido_materno : '' }}
                                    </td>
                                    <td>{{ $seccion->matriculas_activas_count }}/{{ $seccion->vacantes }}</td>
                                    <td><span
                                            class="status-badge status-{{ $seccion->activo ? 'active' : 'inactive' }}">{{ $seccion->activo ? 'Activo' : 'Inactivo' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var anioElement = $('#anio');
        var mesElement = $('#mes');
        var formFiltros = $('#filtros')
        anioElement.add(mesElement).change(function() {
            if (mesElement != "" || anioElement != "") {
                formFiltros.submit();
            }
        })
    </script>
@endpush
