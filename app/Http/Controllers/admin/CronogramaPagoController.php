<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CronogramaPago;
use App\Models\Matricula;
use Illuminate\Http\Request;

class CronogramaPagoController extends Controller
{
    public function index(Request $request)
    {
        $query1 = CronogramaPago::query();
        $query2 = CronogramaPago::query();
        // $query->orderBy('nombres','asc');

        if ($request->filled('search')) {

            $search = $request->search;
            $query1->whereHas('matricula.alumnos.user', function ($q) use ($search) {
                $q->where('nombres', 'ilike', "%{$search}%")->orWhere('apellido_paterno', 'ilike', "%{$search}%")->orWhere('apellido_materno', 'ilike', "%{$search}%");
            })->orWhereHas('matricula.taller', function ($q) use ($search) {
                $q->where('nombre', 'ilike', "%{$search}%");
            });
        }

        $users = $query1->paginate(10)->withQueryString();

        $cronogramaPagosPendientes = $query1->where('estado', 'PENDIENTE')->where('concepto','ilike', "%Mensualidad%")->with(['matricula', 'matricula.alumnos.user', 'matricula.taller'])->paginate(10, ['*'], 'pendientes_page');

        $cronogramaPagosPagados = $query2->where('estado', 'PAGADO')->where('concepto','ilike', "%Mensualidad%")->with(['matricula', 'matricula.alumnos.user', 'matricula.taller'])->paginate(10, ['*'], 'pagados_page');
        // return dd($matriculasPagadas->toArray());
        return view('admin.cronogramaPagos', compact('cronogramaPagosPendientes', 'cronogramaPagosPagados'));
    }

    public function confirmarPago($id)
    {
        // dd($id);
        $cronogramaPago = CronogramaPago::find($id);
        $cronogramaPago->update([
            'estado' => 'PAGADO',
            'fecha_pago' => now()
        ]);
        $cronogramaPago->matricula()->update([
            'estado' => 'ACTIVA'
        ]);
        // $cronogramaPago->estado = 'PAGADO';
        // $cronogramaPago->matricula->estado = 'ACTIVA';
        // $cronogramaPago->save();

        return redirect(route('portal.cronogramaPagos.index'));
    }
}
