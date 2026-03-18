<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Lugar;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class LugarController extends Controller
{
        public function index(Request $request)
    {
        $query = Lugar::query();
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nombre', 'ilike', "%{$search}%")
            ->orWhere('direccion','ilike',"%{$search}%");
                // ->WhereHas('docente.user', function ($q2) use ($search) {
                //     $q2->where('nombres', 'ilike', "%{$search}%")
                //         ->orWhere('apellido_paterno', 'ilike', "%{$search}%");
                // });
        // }
         }
        $lugares = $query->paginate(5)->withQueryString();
        return view('portal.lugares', compact('lugares'));
    }

    public function store(Request $request)
    {
        // dd($request->createNombre);
        $lugar = Lugar::create([
            'nombre' => $request->createNombre,
            'direccion' => $request->createDireccion,
            'link_maps' => $request->createLinkMaps
        ]);
        return redirect()
            ->back()
            ->with('success', 'Sede creada correctamente');
    }
    public function update(Request $request, $id)
    {
        $lugar = Lugar::find($id);
        $lugar->update([
            'nombre' => $request->editNombre,
            'direccion' => $request->editDireccion,
            'link_maps' => $request->editLinkMaps
        ]);
        return redirect()
            ->back()
            ->with('success', 'Sede actualizada correctamente');
    }
    public function destroy($id)
    {
       try {
        Lugar::findOrFail($id)->delete();

        return redirect()
            ->back()
            ->with('success', 'Sede eliminada correctamente.');
    } catch (QueryException $e) {
        if ($e->getCode() === '23503') { // código de violación de FK en PostgreSQL
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar esta sede porque tiene secciones asociados.');
        }

        return redirect()
            ->back()
            ->with('error', 'Ocurrió un error al eliminar la sede.');
    }
    }
}
