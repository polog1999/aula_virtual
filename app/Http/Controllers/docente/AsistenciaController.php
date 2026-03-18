<?php

namespace App\Http\Controllers\docente;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $alumnosIds = [];
        $esApoderado = $user->padre()->exists();
        $esAlumno = $user->alumno()->exists();
        if ($esApoderado) {
            $alumnosIds = $user->padre->alumnos()->pluck('user_id')->toArray();
            if ($user->alumno) {
                $alumnosIds[] = $user->id;
                $esAdultoYPadre = true;
            }
        } 
        elseif ($esAlumno) {
            $alumnosIds = [$user->id];
        }
if($esApoderado || $esAlumno){
  // 1. Obtener todas las matrículas activas para el selector
        $matriculas = Matricula::whereIn('alumno_id', $alumnosIds)
            ->where('estado', 'ACTIVA')
            ->with('alumnos.user', 'seccion.talleres.disciplina')
            ->get();

        if ($matriculas->isEmpty()) {
            return view('alumno.asistencias', ['matriculas' => collect(), 'matriculaSeleccionada' => null]);
        }

        // 2. Determinar la matrícula a mostrar
        $matriculaIdSeleccionada = $request->query('matricula_id', $matriculas->first()->id);
        $matriculaSeleccionada = $matriculas->find($matriculaIdSeleccionada);

        // Si el ID no es válido, redirigir a la primera matrícula
        if (!$matriculaSeleccionada) {
            return redirect()->route('alumno.asistencias.index', ['matricula_id' => $matriculas->first()->id]);
        }

        // 3. Calcular las estadísticas
        $totalClases = $matriculaSeleccionada->seccion->sesiones()->count();
        $asistenciasRegistradas = $matriculaSeleccionada->asistencias->countBy('estado');

        $totalAsistencias = $asistenciasRegistradas->get('ASISTIO', 0);
        $totalFaltas = $asistenciasRegistradas->get('FALTO', 0);
        $totalTardanzas = $asistenciasRegistradas->get('TARDANZA', 0);

        $porcentaje = ($totalClases > 0) ? ($totalAsistencias / $totalClases) * 100 : 0;

        $stats = [
            'porcentaje_asistencia' => $porcentaje,
            'total_asistencias' => $totalAsistencias,
            'total_faltas' => $totalFaltas,
            'total_tardanzas' => $totalTardanzas,
        ];

        // 4. Obtener el historial de asistencias paginado
        $asistencias = Asistencia::where('matricula_id', $matriculaSeleccionada->id)
            // ->with('sesion')
            ->latest('id') // Asume que 'id' es cronológico, o usa 'sesion.fecha' con un join
            ->paginate(10);

        return view('docente.asistencias', compact('matriculas', 'matriculaSeleccionada', 'stats', 'asistencias'));
}else{
    abort('404');
}
      
    }
}
