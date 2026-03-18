<?php

namespace App\Http\Controllers\docente;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagosController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $alumnosIds = [];
        $esApoderado = $user->padre()->exists();
        $esAlumno = $user->alumno()->exists();
        if ($esApoderado) {
            $alumnosIds = $user->padre->alumnos()->pluck('user_id')->toArray();
            
            if ($esAlumno) {
                $alumnosIds[] = $user->alumno()->value('user_id');
            }
        } elseif ($esAlumno) {
            $alumnosIds = [$user->id];
        }
if($esApoderado || $esAlumno){
        // 1. Obtener todos los PAGOS realizados por las matrículas de los alumnos gestionados
        $pagos = Pago::whereHas('cronogramaPago.matricula', fn($q) => $q->whereIn('alumno_id', $alumnosIds))
            ->with([
                'cronogramaPago.matricula.alumnos.user',
                'cronogramaPago.matricula.seccion.talleres.disciplina',
                'cronogramaPago.matricula.seccion.periodo'
            ])
            ->latest('fecha_pago') // Ordenar por los más recientes primero
            ->paginate(10); // Paginar los resultados

        // Ya no necesitas 'cuotasPendientes', 'totalPendiente', ni 'proximoVencimiento'

        return view('docente.pagos', compact('pagos'));
}else{
    abort('404');
}
    }
}
