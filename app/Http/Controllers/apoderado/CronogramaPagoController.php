<?php

namespace App\Http\Controllers\apoderado;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\CronogramaPago;
use App\Models\Pago;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CronogramaPagoController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $alumnosIds = [];

        if ($user->role->value === 'PADRE') {
            $alumnosIds = $user->padre->alumnos()->pluck('user_id')->toArray();
            $esAlumno = $user->alumno()->exists();
            if($esAlumno) {$alumnosIds[] = $user->alumno()->value('user_id');
            }
        } elseif ($user->role->value === 'ALUMNO') {
            $alumnosIds = [$user->id];
        }

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

        return view('apoderado.pagos', compact('pagos'));
    }
}
