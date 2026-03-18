<?php

namespace App\Http\Controllers\alumno;

use App\Http\Controllers\Controller;
use App\Models\CronogramaPago;
use App\Models\Pago;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    public function index()
    {
        $alumno_id = Auth::user()->alumno->user_id;

        $cuotasPendientes = CronogramaPago::whereIn('estado', ['PENDIENTE', 'VENCIDO'])
            ->whereHas('matricula', function ($q) use ($alumno_id) {
                $q->where('alumno_id', $alumno_id);
            })->orderBy('fecha_vencimiento','asc')
            ->with(['matricula', 'matricula.alumnos.user'])->get();

        $totalPendiente = CronogramaPago::where('estado', 'PENDIENTE')
            ->whereHas('matricula', function ($q) use ($alumno_id) {
                $q->where('alumno_id', $alumno_id);
            })->sum('monto');

        $proximoVencimientoString = CronogramaPago::whereHas('matricula', function ($q) use ($alumno_id) {
            $q->where('alumno_id', $alumno_id);
        })->whereDate('fecha_vencimiento', '>=', now()->toDateString())->min('fecha_vencimiento');

        $proximoVencimiento = $proximoVencimientoString?Carbon::parse($proximoVencimientoString):null;

        $historialPagos = Pago::whereHas('cronogramaPago.matricula', function ($q) use ($alumno_id) {
            $q->where('alumno_id', $alumno_id)
            ->with(['cronogramaPago', 'cronogramaPago.matricula.alumnos.user']);
        })->get();

        return view('alumno.pagos', compact('cuotasPendientes', 'totalPendiente', 'proximoVencimiento','historialPagos'));
    }
}
