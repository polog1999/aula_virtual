<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Periodo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    public function index(Request $request)
    {


        $query = Periodo::query();
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('anio', 'ilike', "%{$search}%")
                ->orWhere('ciclo', 'ilike', "%{$search}%");
        }
        $periodos = $query->paginate(5)->withQueryString();
        return view('portal.periodos', compact('periodos'));
    }

    public function store(Request $request)
    {
        // dd($request->createNombre);
        try {
            $periodos = Periodo::create([
                'anio' => $request->createAnio,
                'ciclo' => $request->createNombre,
                'fecha_inicio' => $request->createFechaInicio,
                'fecha_fin' => $request->createFechaFin
            ]);
            return redirect()
                ->back()
                ->with('success', 'Periodo creado correctamente');
        } catch (QueryException $e) {
            if ($e->getCode() === '23505') {
                return redirect()
                    ->back()
                    ->with('error', 'Ya existe este periodo');
            }
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al actualizar el periodo.');
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $periodos = Periodo::find($id);
            $periodos->update([
                'anio' => $request->editAnio,
                'ciclo' => $request->editNombre,
                'fecha_inicio' => $request->editFechaInicio,
                'fecha_fin' => $request->editFechaFin

            ]);
            return redirect()
                ->back()
                ->with('success', 'Periodo actualizado correctamente');
        } catch (QueryException $e) {
            if ($e->getCode() === '23505') {
                return redirect()
                    ->back()
                    ->with('error', 'Ya existe este periodo');
            }
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al actualizar el periodo.');
        }
    }
    public function destroy($id)
    {
        try {
            Periodo::findOrFail($id)->delete();

            return redirect()
                ->back()
                ->with('success', 'Periodo eliminado correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23503') { // código de violación de FK en PostgreSQL
                return redirect()
                    ->back()
                    ->with('error', 'No se puede eliminar este periodo porque tiene secciones asociados.');
            }

            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al eliminar el periodo.');
        }
    }

    // public function getPeriodo($periodoId){
    //     $periodo = Periodo::find($periodoId)->select('id','fecha_inicio','fecha_fin');
    //     return response()->json($periodo);
    // }

}
