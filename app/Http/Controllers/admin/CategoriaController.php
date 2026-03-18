<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Categoria::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nombre', 'ilike', "%{$search}%");
            // ->WhereHas('docente.user', function ($q2) use ($search) {
            //     $q2->where('nombres', 'ilike', "%{$search}%")
            //         ->orWhere('apellido_paterno', 'ilike', "%{$search}%");
            // });
            // }
        }
        $categorias = $query->paginate(5)->withQueryString();
        return view('portal.categorias', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'createNombre' => 'required',
            // 'tipo_categoria' => 'required|in:edad,discapacidad,todas_edades',
            // 'createEdadMinima' => 'nullable|integer|min:1|max:99',
            // 'createEdadMaxima' => 'nullable|integer|min:1|max:99',
        ]);
        // 1. Definir los datos de creación
        Categoria::create([
            'nombre' => $request->createNombre
        ]);
        
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'edit_tipo_categoria' => 'required|in:edad,discapacidad,todas_edades',
            'editEdadMinima' => 'nullable|integer|min:1|max:99',
            'editEdadMaxima' => 'nullable|integer|min:1|max:99',
        ]);
        $dataToUpdate = [
            'tiene_discapacidad' => false,
            'edad_min' => null,
            'edad_max' => null,
        ];
        $tieneDiscapacidad = false;
        if ($request->edit_tipo_categoria == 'edad') {
            $dataToUpdate['edad_min'] = $request->editEdadMinima;
            $dataToUpdate['edad_max'] = $request->editEdadMaxima;
        } else if ($request->edit_tipo_categoria == 'discapacidad') {
            $dataToUpdate['tiene_discapacidad'] = true;
            $tieneDiscapacidad = true;
        }



        try {


            $categoria = Categoria::find($id);
            $hayCategoria = Categoria::where('edad_min', $request->editEdadMinima)
                ->where('edad_max', $request->editEdadMaxima)
                ->where('tiene_discapacidad', $tieneDiscapacidad)
                ->exists();
            if (!$hayCategoria) {
                $categoria->update($dataToUpdate);
                return redirect()
                    ->back()
                    ->with('success', 'Categoría actualizada correctamente.');
            } else {
                return back()->with(['error' => 'Ya existe esta categoría.']);
            }
        } catch (QueryException $e) {
            if ($e->getCode() === '23505') {
                return redirect()
                    ->back()
                    ->with('error', 'Ya existe esta categoría.');
            }
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al actualizar la categoría.');
        }
    }
    public function destroy($id)
    {
        // $categoria = Categoria::find($id);
        // $categoria->delete();
        // return redirect(route('admin.categorias.index'));

        try {
            Categoria::findOrFail($id)->delete();

            return redirect()
                ->back()
                ->with('success', 'Categoría eliminada correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23503') { // código de violación de FK en PostgreSQL
                return redirect()
                    ->back()
                    ->with('error', 'No se puede eliminar esta categoría porque tiene talleres asociados.');
            }

            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al eliminar la categoría.');
        }
    }
}
