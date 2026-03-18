<?php

namespace App\Http\Controllers\admin;

use App\Exports\AlumnosMatriculadosExport;
use App\Exports\AlumnosPagosExport;
use App\Http\Controllers\Controller;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PagoController extends Controller
{
    public function index(Request $request){
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
        return view('portal.pagos', compact('matriculas'));
    }

     public function exportarPagos()
    {
        // Generamos un nombre de archivo dinámico con la fecha.
        $fileName = 'reporte-alumnos-pagos-' . now()->format('Y-m-d') . '.xlsx';

        // Le decimos a Laravel Excel que descargue el archivo usando nuestra clase Export.
        return Excel::download(new AlumnosPagosExport, $fileName);
    }
}
