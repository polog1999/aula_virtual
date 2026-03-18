<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Disciplina;
use App\Models\Docente;
use App\Models\Lugar;
use App\Models\Matricula;
use App\Models\oracle\ServiciosTusne;
use App\Models\Taller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TallerController extends Controller
{
    public function index(Request $request)
    {
        $codigos = ['O0001', 'O0002', 'O0003', 'O0004', 'O0005', 'O0006', 'O0007', 'O0008', 'O0009', 'O0010', 'O0011', 'O0012', 'O0013', 'O0014', 'O0015', 'O0016', 'O0017', 'O0018', 'O0019', 'O0020', 'O0021', 'O0022', 'O0023', 'O0024', 'O0025', 'O0026', 'O0027', 'O0028', 'O0029', 'O0030', 'O0031', 'O0032', 'O0033', 'O0034', 'O0035', 'O0036', 'O0037', 'O0038', 'O0039', 'O0040', 'O0041', 'O0042', 'O0043', 'O0044', 'O0045', 'O0046', 'O0047', 'O0048', 'O0049', 'O0050', 'O0051', 'O0052', 'O0053', 'O0054', 'O0067', 'O0068', 'O0069', 'O0070', 'O0071', 'O0072', 'O0075'];
        $tusnesVecino = ServiciosTusne::select('congrupo', 'concodigo', 'condescrip', 'conmonto')->where('congrupo', '23')->whereIn('concodigo', $codigos)
            ->where(function ($q) {
                $q->where('condescrip', 'like', '%- VECINO%')
                    ->orwhere('condescrip', 'like', '%-  VECINO%');
            })
            ->get();

        $tusnesNoVecino = ServiciosTusne::select('congrupo', 'concodigo', 'condescrip', 'conmonto')->where('congrupo', '23')->whereIn('concodigo', $codigos)
            ->where(function ($q) {
                $q->where('condescrip', 'like', '%- NO VECINO%')
                    ->orWhere('condescrip', 'like', '%-  NO VECINO%')
                    ->orWhere('condescrip', 'like', '%- NO  VECINO%');
            })
            ->get();

        // dd($tusnes->toArray());
        $query = Taller::query();
        $query->select('talleres.*')->with(['disciplina', 'categoria', 'tusnes'])

            ->latest();
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('disciplina', function ($q2) use ($search) {
                $q2->where('nombre', 'ilike', "%{$search}%");
            })->orWhere('costo_mensualidad', 'ilike', "%{$search}%");
        }
        $talleres = $query->paginate(5)->withQueryString();



        $num_tall_activos = Taller::select('id')->where('activo', 1)->count();
        $num_docentes = Taller::select('docente_id')->count();

        $num_alumnos = Matricula::select('alumno_id')->where('estado', 'ACTIVA')->count();

        $categorias = Categoria::select('id', 'edad_min', 'edad_max', 'tiene_discapacidad')->get();
        $disciplinas = Disciplina::select('id', 'nombre')->where('activo', 1)->get();
        $lugares = Lugar::select('id', 'nombre')->get();
        $docentes = Docente::select('user_id')->with(['user:id,nombres,apellido_paterno,apellido_materno'])->get();

        return view('portal.talleres', compact('talleres', 'num_tall_activos', 'num_docentes', 'num_alumnos', 'categorias', 'disciplinas', 'docentes', 'lugares', 'tusnesVecino', 'tusnesNoVecino'));
    }
    public function store(Request $request)
    {
        $tusneVecino = $request->createCostoVecino;
        $tusneNoVecino = $request->createCostoNoVecino;

        $arrayVecino = Str::of($tusneVecino)->explode('_');
        $arrayNoVecino = Str::of($tusneNoVecino)->explode('_');


        try {
            $taller = Taller::create([
                // 'nombre' => $request->createNombre,
                'categoria_id' => $request->createCategoria,
                'disciplina_id' => $request->createDisciplina,

                // 'costo_mensualidad' => $request->createMensualidad,
                'activo' => $request->createEstado
            ]);

            $taller->tusnes()->create([
                'grupo' => $arrayVecino[0],
                'codigo' => $arrayVecino[1],
                'es_vecino' => true
            ]);
            $taller->tusnes()->create([
                'grupo' => $arrayNoVecino[0],
                'codigo' => $arrayNoVecino[1],
                'es_vecino' => false
            ]);
            return redirect()
                ->back()
                ->with('success', 'Taller creado correctamente');
        } catch (QueryException $e) {
            if ($e->getCode() === '23505') {
                return redirect()
                    ->back()
                    ->with('error', 'Ya existe un taller con esta categoría.');
            }
            return redirect()
                ->back()
                ->with('error', $arrayNoVecino[0]);
        }
        // 
        // $request->validate([
        //     'email' => 'required | email'
        // ]);



    }

    public function update(Request $request, $id)
    {
        $tusneVecino = $request->editCostoVecino;
        $tusneNoVecino = $request->editCostoNoVecino;

        $arrayVecino = Str::of($tusneVecino)->explode('_');
        $arrayNoVecino = Str::of($tusneNoVecino)->explode('_');
        try {
            $taller = Taller::findOrFail($id);
            $idsVigentes = [];
            $taller->update([
                // 'nombre' => $request->editNombre,
                'categoria_id' => $request->editCategoria,
                'disciplina_id' => $request->editDisciplina,

                'costo_mensualidad' => $request->editMensualidad,
                'activo' => $request->editEstado
            ]);

            $taller->grupoCodigoVecino()->update([
                'grupo' => $arrayVecino[0],
                'codigo' => $arrayVecino[1],
            ]);
            $taller->grupoCodigoNoVecino()->update([
                'grupo' => $arrayNoVecino[0],
                'codigo' => $arrayNoVecino[1],
            ]);

            return redirect()
                ->back()
                ->with('success', 'Taller actualizado correctamente');
        } catch (QueryException $e) {
            if ($e->getCode() === '23505') {
                return redirect()
                    ->back()
                    ->with('error', 'Ya existe un taller con esta categoría.');
            }
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al actualizar el taller.');
        }
    }
    public function destroy($id)
    {
        // $categoria = Categoria::find($id);
        // $categoria->delete();
        // return redirect(route('admin.categorias.index'));

        try {
            Taller::findOrFail($id)->delete();

            return redirect()
                ->back()
                ->with('success', 'Taller eliminada correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23503') { // código de violación de FK en PostgreSQL
                return redirect()
                    ->back()
                    ->with('error', 'No se puede eliminar este taller porque tiene secciones asociados.');
            }

            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al eliminar el taller.');
        }
    }
}
