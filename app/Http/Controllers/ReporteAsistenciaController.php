<?php

namespace App\Http\Controllers;

use App\Exports\AlumnosAsistenciaExport;
use App\Http\Controllers\Controller;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteAsistenciaController extends Controller
{

    public function exportarAsistencias(Request $request)
    {
        // Generamos un nombre de archivo dinámico con la fecha.
        $fileName = 'reporte-alumnos-asistencias-' . now()->format('Y-m-d') . '.xlsx';

        // Le decimos a Laravel Excel que descargue el archivo usando nuestra clase Export.
        return Excel::download(new AlumnosAsistenciaExport($request->periodo_id), $fileName);
    }
}
