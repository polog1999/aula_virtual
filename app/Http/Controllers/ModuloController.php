<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Modulo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ModuloController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'descripcion' => 'required|string',
            'orden' => 'required|integer',
            'disponible_desde' => 'required|date',
            'prerequisito_id' => 'nullable|exists:modulos,id',
            'activo' => 'required|boolean',
        ]);

        // Lógica para el nombre automático
        $nextModuleNumber = Modulo::where('curso_id', $request->curso_id)->count() + 1;
        $nombreModulo = "Módulo " . $nextModuleNumber;

        Modulo::create([
            'curso_id' => $request->curso_id,
            'nombre' => $nombreModulo, // Nombre automático
            'descripcion' => $request->descripcion,
            'orden' => $request->orden,
            'disponible_desde' => $request->disponible_desde,
            'prerequisito_id' => $request->prerequisito_id,
            'activo' => $request->activo,
        ]);

        return redirect()->route('portal.cursos.index', ['curso_id' => $request->curso_id])
                         ->with('success', 'Unidad creada correctamente.');
    }

    public function update(Request $request, Modulo $modulo)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'orden' => 'required|integer',
            'disponible_desde' => 'required|date',
            'prerequisito_id' => 'nullable|exists:modulos,id',
            'activo' => 'required|boolean',
        ]);

        $modulo->update([
            // 'nombre' => $request->nombre, // El nombre no se edita si es automático
            'descripcion' => $request->descripcion,
            'orden' => $request->orden,
            'disponible_desde' => $request->disponible_desde,
            'prerequisito_id' => $request->prerequisito_id,
            'activo' => $request->activo,
        ]);

        return redirect()->route('portal.cursos.index', ['curso_id' => $modulo->curso_id])
                         ->with('success', 'Unidad actualizada correctamente.');
    }
    public function destroy(Modulo $modulo)
    {
        // Guardamos el ID del curso para la redirección
        $cursoId = $modulo->curso_id;
        
        try {
            $modulo->delete();
            return redirect()->route('portal.cursos.index', ['curso_id' => $cursoId])
                             ->with('success', 'Unidad eliminada correctamente.');

        } catch (QueryException $e) {
            if ($e->getCode() === '23503') {
                return redirect()->back()->with('error', 'No se puede eliminar esta unidad porque tiene sesiones asociadas.');
            }
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar la unidad.');
        }
    }
}