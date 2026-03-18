<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Modulo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- MUY IMPORTANTE
use Symfony\Component\HttpKernel\Event\RequestEvent;

class CursoController extends Controller
{
    // public function index(Request $request)
    // {
    //     $query = Curso::query();

    //     if ($request->filled('search')) {
    //         $search = $request->search;

    //         $query->where('nombre', 'ilike', "%{$search}%");
    //     }
    //     $disciplinas = $query->paginate(5)->withQueryString();
    //     return view('portal.cursos', compact('disciplinas'));
    // }
    public function index(Request $request)
    {
        // $cursos = Curso::all();
        // return view('portal.crear-curso', compact('cursos'));
        $cursos = Curso::orderBy('nombre')->get();
        $categorias = Categoria::all();
        $modulos = [];
        $cursoSeleccionado = null;

        if ($request->has('curso_id')) {
            $modulos = Modulo::where('curso_id',$request->has('curso_id'))->get();
            $cursoSeleccionado = Curso::with([
                'modulos' => fn($q) => $q->orderBy('orden'),
                // 'modulos.sesiones' => fn($q) => $q->orderBy('fecha')
            ])->find($request->query('curso_id'));
        }

        return view('portal.cursos', compact('cursos', 'cursoSeleccionado', 'categorias','modulos'));
    }
    public function store(Request $request)
    {
        // dd($request->createNombre);
        // $disciplina = Disciplina::create([
        //     'nombre' => $request->createNombre
        // ]);
        // return redirect(route('admin.disciplinas.index'));
        // 1. Validación de los datos del formulario
        $nombreImagen = null;
        $request->validate([
            'nombre' => 'required|string|max:255|unique:cursos,nombre',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif|max:2048', // Opcional, tipo imagen, formatos permitidos, tamaño máx 2MB
        ]);

        $path = null; // Inicializamos la ruta de la imagen como nula

        // 2. Comprobar si se ha subido una imagen
        if ($request->hasFile('imagen')) {
            // Generar un nombre único para la imagen para evitar conflictos
            // Formato: timestamp_nombreoriginal.extension
            // $nombreImagen = time() . '_' . $request->file('imagen')->getClientOriginalName();

            // Guardar la imagen en la carpeta 'storage/app/public/disciplinas'
            // El método store() devuelve la ruta relativa donde se guardó
            $path = $request->file('imagen')->store('imagenes', 'public');
        }

        // 3. Crear el registro en la base de datos
        $disciplina = Curso::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->descripcion,
            'categoria_id' => $request->categoria_id,
            'imagen' => $path, // Guardamos la ruta o null si no se subió imagen
            'activo' => $request->activo,
            // 'cod_serv' => $request->createCodServ
        ]);
        // dd($Curso);

        // 4. Redirigir con un mensaje de éxito
        return redirect()
            ->back()
            ->with('success', 'Curso creado correctamente');;
    }
    public function update(Request $request, $id)
    {
        // $Curso = Curso::find($id);
        // $Curso->update([
        //     'nombre' => $request->editNombre
        // ]);
        // return redirect(route('admin.Cursos.index'));
        // 1. Validación (el nombre debe ser único, pero ignorando el registro actual)

        $request->validate([
            'editNombre' => 'required|string|max:255|unique:disciplinas_deportivas,nombre,' . $id,
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif|max:2048',
        ]);

        // 2. Buscar la disciplina a actualizar
        $disciplina = Curso::findOrFail($id);

        // 3. Actualizar el nombre
        $disciplina->nombre = $request->input('editNombre');
        $disciplina->activo = $request->input('editStatus');
        // $disciplina->cod_serv = $request->input('editCodServ');

        // 4. Manejar la actualización de la imagen
        if ($request->hasFile('imagen')) {
            // a. Borrar la imagen anterior si existe
            if ($disciplina->imagen) {
                Storage::disk('public')->delete($disciplina->imagen);
            }

            // b. Guardar la nueva imagen
            // $nombreImagen = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $path = $request->file('imagen')->store('imagenes', 'public');

            // c. Actualizar la ruta en el modelo
            $disciplina->imagen = $path;
        }

        // 5. Guardar los cambios en la base de datos
        $disciplina->save();

        // 6. Redirigir con un mensaje de éxito
        return redirect()
            ->back()
            ->with('success', 'Deporte creado correctamente');
    }
    public function destroy($id)
    {
        try {
            Curso::findOrFail($id)->delete();

            return redirect()
                ->back()
                ->with('success', 'Deporte eliminado correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23503') { // código de violación de FK en PostgreSQL
                return redirect()
                    ->back()
                    ->with('error', 'No se puede eliminar este disciplina porque tiene talleres asociados.');
            }

            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al eliminar el disciplina.');
        }
    }
}
