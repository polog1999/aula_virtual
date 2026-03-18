<?php

namespace App\Http\Controllers\admin;

use App\Exports\AlumnosMatriculadosExport;
use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\PreInscripcion;
use App\Models\Seccion;
use App\Models\Taller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MatriculaController extends Controller
{
    public function index(Request $request)
    {
        // $matriculas = Matricula::all();
        $query = Matricula::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('seccion.talleres.disciplina', function ($q) use ($search) {
                $q->where('nombre', 'ilike', "%{$search}%");
            })->orWhereHas('seccion.talleres.categoria', function ($q) use ($search) {
                $q->where('nombre', 'ilike', "%{$search}%");
            })->orWhereHas('alumnos.user', function ($q) use ($search) {
                $q->where('nombres', 'ilike', "%{$search}%")
                ->orWhere('apellido_paterno', 'ilike', "%{$search}%")
                ->orWhere('apellido_materno', 'ilike', "%{$search}%");
            })->orWhereHas('seccion', function ($q) use ($search) {
                $q->where('nombre', 'ilike', "%{$search}%");
            });
        }
        // $query->join('alumnos', 'matriculas.alumno_id', '=', 'alumnos.user_id')
        //     ->join('users', 'alumnos.user_id', '=', 'users.id')
        //     ->join('pre_inscripciones','pre_inscripciones.id','=','matriculas.preinscripcion_id')
        //     ->select('matriculas.*') // <-- Esta línea es CLAVE
        //     ->orderBy('fecha_matricula', 'desc');

        $query->with('cronogramasPagos.pago')
            ->orderBy('fecha_matricula', 'desc');
        $matriculas = $query->paginate(10)->withQueryString();
        // dd($matriculas->toArray());
        $secciones = Seccion::select('id', 'taller_id', 'docente_id', 'nombre')->with(['talleres', 'talleres.disciplina', 'docentes.user', 'talleres.categoria'])->get();
        return view('portal.matriculas', compact('matriculas', 'secciones'));
    }
    public function update($id, Request $request)
    {
        try {
            // dd($request->toArray());
            $matricula = Matricula::findOrFail($id);
            //  dd($matricula);

            $matricula->update([
                'seccion_id' => $request->editTaller,
                'estado' => $request->editEstado
            ]);
            return redirect()
                ->back()
                ->with('success', 'Matrícula actualizada correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23505') {
                return redirect()
                    ->back()
                    ->with('error', 'Este alumno ya está matriculado en esta sección.');
            }
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al actualizar la matrícula.');
        }
    }

    // public function destroy($id)
    // {
    //     $matricula = Matricula::findOrFail($id);
    //     $matricula->delete();
    // }

    public function exportarAlumnos()
    {
        // Generamos un nombre de archivo dinámico con la fecha.
        $fileName = 'reporte-alumnos-matriculados-' . now()->format('Y-m-d') . '.xlsx';

        // Le decimos a Laravel Excel que descargue el archivo usando nuestra clase Export.
        return Excel::download(new AlumnosMatriculadosExport, $fileName);
    }
    // public function cancelarMatricula(Matricula $matricula){
    //     DB::transaction(function() use ($matricula){
    //         $matricula->update([
    //             'estado' => 'CANCELADA'
    //         ]);
            
    //         $matricula->preInscripcion()->update([
    //             'estado' => 'RECHAZADO'
    //         ]);
    //     });
    // }
}
