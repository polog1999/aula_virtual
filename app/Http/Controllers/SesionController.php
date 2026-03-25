<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Modulo;
use App\Models\Sesion;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SesionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'modulo_id' => 'required|exists:modulos,id',
            'descripcion' => 'required|string',
            'es_evaluacion' => 'required|boolean',
            'activo' => 'required|boolean',
        ]);

        // Lógica para el título automático
        $nextSessionNumber = Sesion::where('modulo_id', $request->modulo_id)->count() + 1;
        $tituloSesion = "Sesión " . $nextSessionNumber;

        $sesion = Sesion::create([
            'modulo_id' => $request->modulo_id,
            'titulo' => $tituloSesion, // Título automático
            'descripcion' => $request->descripcion,
            'es_evaluacion' => $request->es_evaluacion,
            'activo' => $request->activo,
            // 'fecha', 'link_reunion' no están en tu formulario, Laravel los pondrá como null si la BD lo permite
        ]);

        // Redirigir de vuelta al curso al que pertenece este módulo
        $cursoId = Modulo::find($request->modulo_id)->curso_id;
        return redirect()->route('portal.cursos.index', ['curso_id' => $cursoId])
                         ->with('success', 'Sesión creada correctamente.');
    }

    public function update(Request $request, Sesion $sesion)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'es_evaluacion' => 'required|boolean',
            'activo' => 'required|boolean',
        ]);

        $sesion->update([
            // 'titulo' => $request->titulo, // El título no se edita si es automático
            'descripcion' => $request->descripcion,
            'es_evaluacion' => $request->es_evaluacion,
            'activo' => $request->activo,
        ]);
        
        $cursoId = $sesion->modulo->curso_id;
        return redirect()->route('portal.cursos.index', ['curso_id' => $cursoId])
                         ->with('success', 'Sesión actualizada correctamente.');
    }
    public function destroy(Sesion $sesion)
    {
        // Guardamos el ID del curso para la redirección
        $cursoId = $sesion->modulo->curso_id;

        try {
            $sesion->delete();
            return redirect()->route('portal.cursos.index', ['curso_id' => $cursoId])
                             ->with('success', 'Sesión eliminada correctamente.');
                             
        } catch (QueryException $e) {
            // Una sesión normalmente no tiene relaciones que impidan su borrado directo,
            // pero es buena práctica tener el manejo de errores.
            if ($e->getCode() === '23503') {
                return redirect()->back()->with('error', 'No se puede eliminar esta sesión porque tiene recursos o progresos de alumnos asociados.');
            }
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar la sesión.');
        }
    }
}