<?php

namespace App\Http\Controllers\docente;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorarioController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $alumnosIds = [];
        $esAdultoYPadre = false;
        $esApoderado = $user->padre()->exists();
        $esAlumno = $user->alumno()->exists();
        if ($esApoderado) {
            // $alumnosIds = $user->padre->alumnos()->pluck('user_id')->toArray();
            // Comprobar si este padre también es alumno
            if ($user->alumno) {
                $alumnosIds[] = $user->id;
                $esAdultoYPadre = true;
            }
        } elseif ($esAlumno) {
            $alumnosIds = [$user->id];
        }
        if ($esAlumno) {
            // 1. Obtener todas las matrículas activas de los perfiles gestionados
            $matriculasActivas = Matricula::whereIn('alumno_id', $alumnosIds)
                ->where('estado', 'ACTIVA')
                ->with([
                    'alumnos.user', // Para el nombre del alumno
                    'seccion.talleres.disciplina', // Para el nombre del taller
                    'seccion.periodo', // Para el periodo
                    'seccion.lugares', // Para el lugar
                    'seccion.docentes.user', // Para el nombre del docente
                    'seccion.horarios' => function ($query) { // Para los horarios
                        // Opcional: ordenar los días
                        $query->orderByRaw("
                    CASE dia_semana
                        WHEN 'LUNES' THEN 1 WHEN 'MARTES' THEN 2 WHEN 'MIÉRCOLES' THEN 3
                        WHEN 'JUEVES' THEN 4 WHEN 'VIERNES' THEN 5 WHEN 'SÁBADO' THEN 6
                        WHEN 'DOMINGO' THEN 7
                    END
                ");
                    }
                ])
                ->get();

            return view('docente.horarios', compact('matriculasActivas', 'esAdultoYPadre'));
        } else {
            abort('404');
        }
    }
}
