<?php

namespace App\Http\Controllers\asistencia;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Categoria;
use App\Models\Disciplina;
use App\Models\Docente;
use App\Models\Lugar;
use App\Models\Matricula;
use App\Models\Periodo;
use App\Models\Seccion;
use App\Models\Sesion;
use App\Models\Taller;
use Illuminate\Http\Request;



use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        //  DB::enableQueryLog(); // 🟢 Empieza a registrar

        $periodos = Periodo::select('id', 'anio', 'ciclo')->get();
        $sedes = Lugar::select('id', 'nombre')->get();
        //?fecha=2025-08-06&disciplina=1&categoria=1&docente=106
        $fecha =  $request->fecha;
        $disciplinaId = $request->disciplina;

        $periodoId = $request->periodo;
        $seccionId = $request->seccion;
        $sedeId = $request->sede;
        $docenteId = $request->docente;

        $seccion = Seccion::find($seccionId);
        $disciplina1 = Disciplina::find($disciplinaId);
        $disciplinaSeleccionada = Disciplina::find($disciplinaId);
        // dd($disciplina->toArray());

        $matriculas = null;
        $asistencias = null;
        $info = null;
        if ($request->filled('disciplina', 'periodo', 'sede', 'docente', 'fecha', 'seccion')) {
            $asistencias = Asistencia::join('matriculas', 'asistencias.matricula_id', '=', 'matriculas.id')
                ->join('alumnos', 'matriculas.alumno_id', '=', 'alumnos.user_id')
                ->join('users', 'alumnos.user_id', '=', 'users.id')
                ->join('secciones', 'matriculas.seccion_id', '=', 'secciones.id')
                ->join('talleres', 'secciones.taller_id', '=', 'talleres.id')
                ->join('disciplinas_deportivas', 'talleres.disciplina_id', '=', 'disciplinas_deportivas.id')
                ->join('periodos', 'secciones.periodo_id', '=', 'periodos.id')
                ->whereDate('fecha', $fecha)
                ->when($periodoId, fn($q) => $q->where('periodos.id', $periodoId))
                ->when($sedeId, fn($q) => $q->where('secciones.lugar_id', $sedeId))
                ->when($disciplinaId, fn($q) => $q->where('talleres.disciplina_id', $disciplinaId))
                ->when($docenteId, fn($q) => $q->where('secciones.docente_id', $docenteId))
                ->when($seccionId, fn($q) => $q->where('secciones.id', $seccionId))
                ->orderBy('users.apellido_paterno', 'asc')
                ->select(
                    'asistencias.*',
                    'users.apellido_paterno as ape_paterno',
                    'users.apellido_materno as ape_materno',
                    'users.nombres as nombres'

                )
                // ->with(['matricula.seccion.talleres', 'matricula.alumnos.user:id'])
                ->get();
            if ($asistencias->isNotEmpty()) {
                return view('encargadoSede.buscarAsistencia', compact('sedes', 'disciplina1', 'seccion', 'matriculas', 'periodos', 'asistencias', 'disciplinaSeleccionada', 'info'));
            } else {
                //  if ($asistencias == null) {
                // dd($asistencias->toArray());
                $matriculas = Matricula::select('matriculas.*')
                    ->with('seccion.talleres.disciplina', 'taller.categoria', 'seccion.docentes', 'alumnos')
                    ->whereHas('seccion.talleres', function ($q) use ($disciplinaId) {
                        $q->where('disciplina_id', $disciplinaId);
                    })
                    ->whereHas('seccion', function ($q) use ($periodoId, $seccionId, $docenteId, $sedeId) {
                        $q->where('periodo_id', $periodoId)
                            ->where('lugar_id', $sedeId)
                            ->where('docente_id', $docenteId)
                            ->where('id', $seccionId);
                    })
                    ->where('estado', 'ACTIVA')
                    ->whereHas('alumnos.user')
                    ->join('secciones', 'matriculas.seccion_id', '=', 'secciones.id')
                    ->join('alumnos', 'matriculas.alumno_id', '=', 'alumnos.user_id')
                    ->join('users', 'alumnos.user_id', '=', 'users.id')

                    ->orderBy('users.apellido_paterno', 'asc')
                    ->get();
                // dd('Hola mundo')

                if ($matriculas->isEmpty($matriculas)) {
                    $info = 'No se encontraron matrículas en esta sección';
                }

                // }
                return view('encargadoSede.buscarAsistencia', compact('sedes', 'disciplina1', 'seccion', 'matriculas', 'periodos', 'asistencias', 'disciplinaSeleccionada', 'info'));
                // $matriculas = Matricula::select('matriculas.*')
                //     ->join('matriculas', 'matriculas.id', 'asistencias.matricula_id')
                //     ->join('secciones', 'matriculas.seccion_id', '=', 'secciones.id')
                //     ->join('talleres', 'secciones.taller_id', '=', 'talleres.id')
                //     ->whereDate($fecha);



                // dd($asistencias->toArray());

                // $tallerQuery = Taller::query();

                // $matriculasQuery  = Matricula::query();

                // if($request->disciplina){

                //     $taller = $tallerQuery->where('disciplina_id');
                // }




                // $categoriaSeleccionada = Categoria::find($categoriaId);
                //   dd(DB::getQueryLog());
            }
        }

        // dd($asistencias->toArray());


        return view('encargadoSede.buscarAsistencia', compact('sedes', 'disciplina1', 'seccion', 'matriculas', 'periodos', 'asistencias', 'disciplinaSeleccionada', 'info'));
    }

    // public function create($periodoId, $disciplinaId, $seccionId, $fecha)
    // {
    //     $matriculas = Matricula::select('matriculas.*')
    //         ->with('seccion.talleres.disciplina', 'taller.categoria', 'seccion.docentes', 'alumnos')->whereHas('seccion.talleres', function ($q) use ($disciplinaId) {
    //             $q->where('disciplina_id', $disciplinaId);
    //         })
    //         ->whereHas('seccion', function ($q) use ($periodoId, $seccionId) {
    //             $q->where('periodo_id', $periodoId)
    //                 ->where('id', $seccionId);
    //         })
    //         ->whereHas('alumnos.user')
    //         ->join('alumnos', 'matriculas.alumno_id', '=', 'alumnos.user_id')
    //         ->join('users', 'alumnos.user_id', '=', 'users.id')
    //         ->orderBy('users.nombres', 'asc')
    //         ->get();
    //     $disciplina = Disciplina::find($disciplinaId);
    //     $periodo = Periodo::find($periodoId);
    //     $seccion = Seccion::find($seccionId);
    //     // $categoria = Categoria::find($categoriaId);
    //     // $docente = Docente::find($docenteId);
    //     // dd($matriculas);
    //     return view('encargadoSede.crearAsistencia', compact('seccion', 'periodo', 'matriculas', 'disciplina', 'fecha'));
    // }

    public function store(Request $request)
    {
        // dd($request->toArray());
        $asistencias  = $request->asistencias;
        foreach ($asistencias as $matriculaId => $asistencia) {
            $asistencias1 = Asistencia::updateOrCreate(
                [
                    'matricula_id' => $matriculaId,
                    'fecha' => $request->fechaAsistencia
                ],
                [
                    'estado' => $asistencia

                ]
            );
        }
        // dd($asistencias);
        return redirect()
            ->back()
            ->with('success', 'Asistencia guardada correctamente');
    }
    public function update(Request $request)
    {
        $asistencias = $request->asistencias;
        // dd([$asistencias,$request->fecha]);
        foreach ($asistencias as $matriculaId => $asistencia) {
            $a = Asistencia::where('matricula_id', $matriculaId)
                ->where('fecha', $request->fecha)->update([
                    'estado' => $asistencia
                ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Asistencia actualizada correctamente');
    }

    public function getDisciplinas($periodoId, $lugarId)
    {
        //disciplinas = DB::table('secciones')

        $disciplinas = DB::table('secciones')
            ->join('talleres', 'talleres.id', '=', 'secciones.taller_id')
            ->join('disciplinas_deportivas', 'talleres.disciplina_id', '=', 'disciplinas_deportivas.id')
            ->where('lugar_id', $lugarId)
            ->where('periodo_id', $periodoId)
            ->select('disciplinas_deportivas.id', 'disciplinas_deportivas.nombre')
            ->distinct()
            ->get();

        // $secciones = Seccion::where('periodo_id', $periodoId)
        //     ->where('lugar_id', $lugarId)->with(['talleres.disciplina'])
        //     ->select('id', 'taller_id')
        //     ->get();
        // $disciplinas = $secciones->map(function ($seccion) {
        //     $disciplina  = $seccion->talleres->disciplina ?? null;
        //     return $disciplina ? [
        //         'id' => $disciplina->id,
        //         'nombre' => $disciplina->nombre
        //     ] : null;
        // })
        //     ->filter()
        //     ->unique('id')
        //     ->values();
        return response()->json($disciplinas);
    }
    public function getDocentes($periodoId, $lugarId, $disciplinaId)
    {
        $secciones = Seccion::where('periodo_id', $periodoId)
            ->where('lugar_id', $lugarId)
            ->whereHas('talleres', function ($q) use ($disciplinaId) {
                $q->where('disciplina_id', $disciplinaId);
            })
            ->with('docentes.user:id,nombres,apellido_paterno,apellido_materno')
            ->select('id', 'taller_id', 'docente_id')
            ->get();
        // dd($secciones);
        $docentes = $secciones->map(function ($seccion) {
            $docente  = $seccion->docentes->user ?? null;
            return $docente ? [
                'id' => $docente->id,
                'nombres' => $docente->full_name
            ] : null;
        })
            ->filter()
            ->unique('id')
            ->values();
        // dd($docentes);

        return response()->json($docentes);
    }


    public function getSecciones($periodoId, $lugarId, $disciplinaId, $docenteId)
    {

        $secciones = Seccion::where('periodo_id', $periodoId)
            ->where('lugar_id', $lugarId)
            ->where('docente_id', $docenteId)
            ->whereHas('talleres', function ($q) use ($disciplinaId) {
                $q->where('disciplina_id', $disciplinaId);
            })
            ->select('id', 'taller_id', 'nombre')
            ->get();
        // dd($secciones);
        $secciones = $secciones->map(function ($seccion) {
            return $seccion ? [
                'id' => $seccion->id,
                'nombre' => $seccion->nombre,
                'dia_semana' => $seccion->dia_semana
            ] : null;
        })
            ->filter()
            ->unique('id')
            ->values();

        // dd($secciones);

        return response()->json($secciones);
    }


    public function reporte(Request $request)
    {
        // --- Cargar datos para los filtros (igual que en el método index) ---
        $sedes = Lugar::select('id', 'nombre')->get();

        $disciplinas = Disciplina::select('id', 'nombre')->where('activo', true)->get();
        $periodos = Periodo::select('id', 'anio', 'ciclo')->get();

        // --- Obtener filtros de la URL ---
        $periodoId = $request->input('periodo');
        $disciplinaId = $request->input('disciplina');
        $seccionId = $request->input('seccion');
        $mes = $request->input('mes'); // Nuevo filtro para el mes

        $estudiantesReporte = collect();
        $diasDelMes = 0;
        $nombreMesSeleccionado = '';

        // --- Ejecutar la consulta solo si todos los filtros están presentes ---
        if ($periodoId && $disciplinaId && $seccionId && $mes) {

            // Obtener el año del periodo. Asumimos que el nombre del periodo es el año, ej: "2025-II".
            // Esta lógica podría necesitar ajuste según el formato exacto de `periodos.nombre`
            $periodo = Periodo::find($periodoId);
            $anio = $periodo->anio; // Extrae '2025' de '2025-II'

            $totalClasesProgramadas = Sesion::where('seccion_id', $seccionId)
                ->whereMonth('fecha',(int) $mes)
                ->whereYear('fecha', (int )$anio)->count();

                // dd($totalClasesProgramadas->toArray());

            // Calcular el número de días del mes y su nombre
            $diasDelMes = Carbon::createFromDate($anio, $mes)->daysInMonth;
            $nombreMesSeleccionado = Carbon::createFromDate($anio, $mes)->locale('es')->monthName;

            // 1. Obtener todas las matrículas activas de la sección
            $matriculas = Matricula::query()
                ->where('seccion_id', $seccionId)
                ->where('estado', 'ACTIVA')
                ->with([
                    'alumnos.user',
                    // 2. Cargar SOLO las asistencias del mes y año seleccionados
                    'asistencias' => function ($query) use ($anio, $mes) {
                        $query->whereYear('fecha', $anio)
                            ->whereMonth('fecha', $mes);
                    }
                ])
                ->get();

            // 3. Procesar los datos para que la vista los pueda usar fácilmente
            $estudiantesReporte = $matriculas->map(function ($matricula) use ($totalClasesProgramadas) {
                $estudiante = $matricula->alumnos->user;

                // Creamos un array asociativo donde la clave es el día del mes
                $asistenciasPorDia = [];
                $asistidos = [];
                $faltas = [];
                $tardanzas = [];

                foreach ($matricula->asistencias as $asistencia) {
                    // Extraemos el día (ej: 5) de la fecha completa (ej: '2025-10-05')
                    $dia = Carbon::parse($asistencia->fecha)->day;
                    $asistenciasPorDia[$dia] = $asistencia->estado;

                    if ($asistencia->estado == 'ASISTIO') {
                        $asistidos[] = $asistencia->estado;
                    }
                    if ($asistencia->estado == 'FALTO') {
                        $faltas[] = $asistencia->estado;
                    }
                    if ($asistencia->estado == 'TARDANZA') {
                        $tardanzas[] = $asistencia->estado;
                    }



                    // if($asistenciasPorDia[$dia]->estado == 'ASISTIO'){

                    // }
                }


                $total_asistencias = count($asistidos);
                $total_faltas = count($faltas);
                $total_tardanzas = count($tardanzas);
                $total_clases_mes = $totalClasesProgramadas;
                // $porcentaje_asistencia = $totalClasesProgramadas;

                $porcentaje_asistencia = ($total_asistencias / $totalClasesProgramadas) * 100;
                // Añadimos esta información procesada como una nueva propiedad al objeto estudiante
                $estudiante->asistencias_por_dia = $asistenciasPorDia;
                $estudiante->total_asistencias = $total_asistencias;
                $estudiante->total_faltas = $total_faltas;
                $estudiante->total_tardanzas = $total_tardanzas;
                $estudiante->porcentaje_asistencia = $porcentaje_asistencia;
                $estudiante->total_clases_mes = $total_clases_mes;




                return $estudiante;
            })
                ->sortBy('apellido_paterno')
                ->values();
        }

        return view('encargadoSede.reporteAsistencia', compact(
            'periodos',
            'disciplinas',
            'estudiantesReporte',
            'diasDelMes',
            'nombreMesSeleccionado',
            'sedes'
            // Pasa también los valores seleccionados para que los filtros los recuerden
            // 'periodoId', 'disciplinaId', 'seccionId', 'mes' 
        ));
    }
    public function reportePeriodo()
    {
        $periodos = Periodo::select('id', 'anio', 'ciclo')->get();
        return view('encargadoSede.reporteExcelAsistencias', compact('periodos'));
    }
}
