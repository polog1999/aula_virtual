<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $cursos = Curso::orderBy('nombre')->get();
        $categorias = Categoria::all();
        $cursoSeleccionado = null;
        $modulos = collect(); // Inicializar como colección vacía

        if ($request->has('curso_id')) {
            $cursoSeleccionado = Curso::with([
                'modulos' => fn($q) => $q->orderBy('orden'),
                'modulos.sesiones' => fn($q) => $q->orderBy('id') // O por el campo que uses para ordenar sesiones
            ])->find($request->query('curso_id'));
            
            if ($cursoSeleccionado) {
                $modulos = $cursoSeleccionado->modulos;
            }
        }

        return view('portal.cursos', compact('cursos', 'cursoSeleccionado', 'categorias', 'modulos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:200|unique:cursos,nombre',
            'descripcion' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
            'activo' => 'required|boolean',
        ]);

        $path = null;
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('cursos', 'public');
        }

        Curso::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria_id' => $request->categoria_id,
            'imagen' => $path,
            'activo' => $request->activo,
        ]);

        return redirect()->route('portal.cursos.index')->with('success', 'Curso creado correctamente.');
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|string|max:200|unique:cursos,nombre,' . $curso->id,
            'descripcion' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
            'activo' => 'required|boolean',
        ]);

        $path = $curso->imagen;
        if ($request->hasFile('imagen')) {
            // Borrar imagen anterior si existe
            if ($curso->imagen) {
                Storage::disk('public')->delete($curso->imagen);
            }
            $path = $request->file('imagen')->store('cursos', 'public');
        }

        $curso->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria_id' => $request->categoria_id,
            'imagen' => $path,
            'activo' => $request->activo,
        ]);

        return redirect()->route('portal.cursos.index', ['curso_id' => $curso->id])->with('success', 'Curso actualizado correctamente.');
    }

    // public function destroy(Curso $curso) ...
}