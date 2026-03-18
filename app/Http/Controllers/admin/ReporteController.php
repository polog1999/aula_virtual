<?php

namespace App\Http\Controllers\admin;

use App\Exports\AlumnosAsistenciaExport;
use App\Exports\AlumnosMatriculadosExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function exportarAlumnos()
    {
        // Generamos un nombre de archivo dinámico con la fecha.
        $fileName = 'reporte-alumnos-matriculados-' . now()->format('Y-m-d') . '.xlsx';

        // Le decimos a Laravel Excel que descargue el archivo usando nuestra clase Export.
        return Excel::download(new AlumnosMatriculadosExport, $fileName);
    }

}
