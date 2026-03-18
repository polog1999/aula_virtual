<?php

namespace App\Http\Controllers\admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeccionRequest;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Lugar;
use App\Models\Matricula;
use App\Models\Periodo;
use App\Models\Seccion;
use App\Models\Taller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Runner\UnsupportedPhptSectionException;

class SeccionController extends Controller
{
    public function index(Request $request)
    {

    // dd(array_column(UserRole::cases(), 'value'));
        //     $talleres = Taller::latest()->with(['disciplina:id,nombre'])->withCount([
        //     'matricula as matriculas_activas_count' => function ($q) {
        //         $q->where('estado', 'ACTIVA');
        //     }
        // ])->take(3)->get();
        // $secciones = Seccion::select('secciones.*')->with(['talleres', 'docentes.user', 'lugares', 'horarios', 'talleres.categoria', 'talleres.disciplina'])
        //     ->withCount([
        //         'matriculas as matriculas_activas_count' => function ($q) {
        //             $q->where('estado', 'ACTIVA');
        //         }
        //     ])->join('talleres', 'secciones.taller_id', '=', 'talleres.id')
        //     ->where('talleres.activo', '1')->get();

        $query = Seccion::query();
        $query->select('secciones.*')->with(['docentes.user'])
            // ->join('secciones','talleres.id','=','secciones.taller_id')
            // ->join('matriculas','matriculas.seccion_id','=','secciones.id')
            // ->withCount([
            //     'seccion.taller.matricula as matriculas_activas_count' => function ($q) {
            //         $q->where('matriculas.estado', 'ACTIVA');
            //     }
            // ])
            ->latest();
        if ($request->filled('search')) {
            $search = $request->search;

            $query
                ->where('nombre', 'ilike', "%{$search}%")
                ->orWhereHas('talleres.disciplina', function ($q) use ($search) {
                    $q->where('nombre', 'ilike', "%{$search}%");
                })
                ->orWhereHas('talleres.categoria', function ($q) use ($search) {
                    $q->where('nombre', 'ilike', "%{$search}%");
                })
                // ->orWhere('dia_semana', 'ilike', "%{$search}%")
                ->orWhereHas('horarios', function ($q) use ($search) {
                    $q->where('dia_semana', 'ilike', "%{$search}%");

                    // ->WhereHas('docente.user', function ($q2) use ($search) {
                    //     $q2->where('nombres', 'ilike', "%{$search}%")
                    //         ->orWhere('apellido_paterno', 'ilike', "%{$search}%");
                })
                ->orWhereHas('docentes.user', function ($q) use ($search) {
                    $q->where('nombres', 'ilike', "%{$search}%")
                        ->orWhere('apellido_paterno', 'ilike', "%{$search}%")
                        ->orWhere('apellido_materno', 'ilike', "%{$search}%");
                })
                ->orWhere('vacantes', 'ilike', "%{$search}%")
                ->orWhereHas('periodo', function ($q) use ($search) {
                    $q->where('anio', 'ilike', "%{$search}%")
                    ->orWhere('ciclo', 'ilike', "%{$search}%");
                })
            ;
        }
        $secciones = $query->withCount(['matriculas as matriculas_activas' => function($q){
            $q->where('estado','ACTIVA');
        }])
        ->paginate(5)->withQueryString();

     
        // $lugares = Lugar::select('id', 'nombre')->get();
        $docentes = Docente::select('user_id')->with(['user:id,nombres,apellido_paterno,apellido_materno'])->get();
        $cursos = Curso::select('id', 'nombre', 'descripcion')->where('activo',1)->get();
        $periodos = Periodo::select('id', 'anio', 'ciclo','fecha_inicio','fecha_fin')->get();

        return view('portal.secciones', compact('secciones',  'docentes', 'cursos', 'periodos'));
    }
    public function store(SeccionRequest $request)
    {
        // dd($request->toArray());
        // 
        // $request->validate([
        //     'email' => 'required | email'
        // ]);
        $seccion = Seccion::create([
            'curso_id' => $request->createTaller,
            'docente_id' => $request->createDocente,
            // 'lugar_id' => $request->createLugar,
            'nombre' => $request->createNombre,
            // 'categoria_id' => $request->createCategoria,

            'vacantes' => $request->createVacantes,
            // 'vacantes_disponibles' => $request->createVacantes,
            'periodo_id' => $request->createPeriodo,
            'fecha_inicio' => $request->createFechaInicio,
            'fecha_fin' => $request->createFechaFin,
            // 'costo_matricula' => $request->createMatricula,
            // 'costo_mensualidad' => $request->createMensualidad,
            'activo' => $request->createEstado
        ]);

        $dias = $request->createDias;
        $horasInicio = $request->createHoraInicio;
        $horasFin = $request->createHoraFin;
        foreach ($dias as $i => $dia) {
            $horaInicio = $horasInicio[$i] ?? null;
            $horaFin = $horasFin[$i] ?? null;
            if ($dias && $horaInicio && $horaFin) {
                $seccion->horarios()->create([
                    'hora_inicio' => $horaInicio,
                    'hora_fin' => $horaFin,
                    'dia_semana' => $dia
                ]);
            }
            // dd($dias);
        }

        // $taller = new Taller();
        // $taller->nombre = $request->createNombre;
        // $taller->categoria_id = $request->createCategoria;
        // $taller->disciplina_id = $request->createDisciplina;
        // $taller->docente_id = $request->createDocente;
        // $taller->lugar_id = $request->createLugar;
        // $taller->vacantes = $request->createVacantes;
        // $taller->costo_matricula = $request->createMatricula;
        // $taller->costo_mensualidad = $request->createMensualidad;
        // $taller->activo = $request->createEstado;
        // $taller->save();
            $seccion->generarSesiones();
        return redirect()
                ->back()
                ->with('success', 'Sección creada correctamente.');
    }

   // En app/Http/Controllers/admin/SeccionController.php

public function update(Request $request, $id)
{
    // Es una buena práctica usar una transacción para asegurar la integridad de los datos.
    // Si algo falla, todo se revierte.
    $cantidadMatriculados = Matricula::where('seccion_id',$id)->where('estado','ACTIVA')->count();
    if($request->editVacantes < $cantidadMatriculados){
        return back()->with('error',"Actualmente hay $cantidadMatriculados matriculados activos. No puede ser menor las vacantes");
    }
    try {
        DB::transaction(function () use ($request, $id) {
            
            // --- PASO 1: ENCONTRAR Y ACTUALIZAR LA SECCIÓN ---
            $seccion = Seccion::findOrFail($id);
            $seccion->update([
                'taller_id' => $request->editTaller,
                'nombre' => $request->editNombre,
                'lugar_id' => $request->editLugar,
                'docente_id' => $request->editDocente,
                'vacantes' => $request->editVacantes,
                'periodo_id' => $request->editPeriodo,
                'fecha_inicio' => $request->editFechaInicio,
                'fecha_fin' => $request->editFechaFin,
                'activo' => $request->editEstado
            ]);

            // --- PASO 2: SINCRONIZAR LOS HORARIOS ---
            $idsVigentes = [];
            if (is_array($request->editDias)) {
                foreach ($request->editDias as $i => $dia) {
                    $horario = $seccion->horarios()->updateOrCreate(
                        ['id' => $request->idHorario[$i] ?? null],
                        [
                            'dia_semana' => $dia,
                            'hora_inicio' => $request->editHoraInicio[$i],
                            'hora_fin' => $request->editHoraFin[$i]
                        ]
                    );
                    $idsVigentes[] = $horario->id;
                }
            }
            // Borrar horarios que ya no se enviaron
            $seccion->horarios()->whereNotIn('id', $idsVigentes)->delete();


            // --- PASO 3: REGENERAR LAS SESIONES (LA LÓGICA CLAVE) ---

            // ¡IMPORTANTE! Volvemos a cargar la sección desde la BD con sus relaciones actualizadas.
            // Esto asegura que trabajamos con los datos más frescos, incluyendo los nuevos horarios.
            $seccionRefrescada = Seccion::with('horarios')->find($id);

            // Borramos todas las sesiones programadas desde HOY hacia el futuro.
            // Las sesiones pasadas (con posible asistencia) NO se tocan.
            $seccionRefrescada->sesiones()->where('fecha', '>=', now()->toDateString())->delete();

            // Determinamos la fecha desde la cual empezar a generar las nuevas sesiones.
            $fechaDePartida = Carbon::parse($seccionRefrescada->fecha_inicio);
            if ($fechaDePartida->isPast()) {
                $fechaDePartida = now()->startOfDay(); // Si la fecha de inicio ya pasó, empezamos desde hoy.
            }
            
            // Mapeamos los días de la semana a números de Carbon.
            $diasDeClase = $seccionRefrescada->horarios->pluck('dia_semana')->map(function ($dia) {
                $map = [
                    'LUNES' => Carbon::MONDAY, 'MARTES' => Carbon::TUESDAY,
                    'MIÉRCOLES' => Carbon::WEDNESDAY, 'JUEVES' => Carbon::THURSDAY,
                    'VIERNES' => Carbon::FRIDAY, 'SÁBADO' => Carbon::SATURDAY,
                    'DOMINGO' => Carbon::SUNDAY
                ];
                return $map[strtoupper($dia)] ?? null;
            })->filter()->toArray();

            // Si hay días de clase, generamos las nuevas sesiones.
            if (!empty($diasDeClase)) {
                $periodo = CarbonPeriod::create($fechaDePartida, $seccionRefrescada->fecha_fin);
                $sesionesParaInsertar = [];
                foreach ($periodo as $fecha) {
                    if (in_array($fecha->dayOfWeek, $diasDeClase)) {
                        $sesionesParaInsertar[] = [
                            'seccion_id' => $seccionRefrescada->id,
                            'fecha' => $fecha->toDateString(),
                            'estado' => 'Pendiente',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }

                // Insertamos las nuevas sesiones de una sola vez.
                if (!empty($sesionesParaInsertar)) {
                    DB::table('sesiones')->insert($sesionesParaInsertar);
                }
            }
        }); // Fin de la transacción

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Ocurrió un error al actualizar: ' . $e->getMessage())->withInput();
    }

    return redirect()->back()->with('success', 'Sección actualizada y calendario regenerado correctamente.');
}

    public function destroy($id)
    {
        try {
        Seccion::findOrFail($id)->delete();

        return redirect()
            ->back()
            ->with('success', 'Sección eliminado correctamente.');
    } catch (QueryException $e) {
        if ($e->getCode() === '23503') { // código de violación de FK en PostgreSQL
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar esta sección porque tiene matrículas asociados.');
        }

        return redirect()
            ->back()
            ->with('error', 'Ocurrió un error al eliminar la sección.');
    }
    }
}
