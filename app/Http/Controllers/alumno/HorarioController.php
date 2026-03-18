<?php

namespace App\Http\Controllers\alumno;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\Taller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorarioController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $alumnosIds = [];
    $esAdultoYPadre = false;

    if ($user->role->value === 'PADRE') {
        $alumnosIds = $user->padre->hijos()->pluck('user_id')->toArray();
        // Comprobar si este padre también es alumno
        if ($user->alumno) {
            $alumnosIds[] = $user->id;
            $esAdultoYPadre = true;
        }
    } elseif ($user->role->value === 'ALUMNO') {
        $alumnosIds = [$user->id];
    }
    
    // 1. Obtener todas las matrículas activas de los perfiles gestionados
    $matriculasActivas = Matricula::whereIn('alumno_id', $alumnosIds)
        ->where('estado', 'ACTIVA')
        ->with([
            'alumnos.user', // Para el nombre del alumno
            'seccion.talleres.disciplina', // Para el nombre del taller
            'seccion.periodo', // Para el periodo
            'seccion.lugares', // Para el lugar
            'seccion.docentes.user', 
            'seccion.talleres.categoria',// Para el nombre del docente
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
        
    return view('alumno.horarios', compact('matriculasActivas', 'esAdultoYPadre'));
}
}
