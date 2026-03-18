<?php

namespace App\Http\Controllers\docente;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HijoController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $alumnosAsociados = collect();
        $esApoderado = $user->padre()->exists();
        $esAlumno = $user->alumno()->exists();
        // Obtener los perfiles de alumno que este usuario puede gestionar
        if ($esApoderado) {
            $alumnosAsociados = $user->padre->alumnos()->with('user')->get();
        } elseif ($esAlumno) {
            // Si el adulto también tiene un perfil de "hijo" (sin padre_id)
            $alumnosAsociados->push($user->alumno);
        }
if($esApoderado){
        // Cargar las relaciones necesarias para cada alumno
        $alumnosAsociados->each(function ($alumno) {

            // Cargar matrículas activas con sus relaciones para el horario
            $alumno->load(['matriculasActivas.seccion.talleres.disciplina', 'matriculasActivas.seccion.lugares', 'matriculasActivas.seccion.horarios']);

            // Cargar las últimas 5 asistencias
            $alumno->ultimasAsistencias = Asistencia::whereHas('matricula', fn($q) => $q->where('alumno_id', $alumno->user_id))
                ->with('matricula.seccion.talleres.disciplina')
                ->latest('id')->take(5)->get(); // 'id' o 'fecha' de la sesion

            // Cargar las últimas 5 calificaciones
            // $alumno->ultimasCalificaciones = Evaluacion::whereHas('matricula', fn($q) => $q->where('alumno_id', $alumno->user_id))
            //     ->with('matricula.seccion.talleres.disciplina')
            //     ->latest('fecha_evaluacion')->take(5)->get();
        });

        return view('docente.hijos', compact('alumnosAsociados'));
}else{
    abort('404');
}
    }
}
