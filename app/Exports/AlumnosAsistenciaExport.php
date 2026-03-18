<?php

namespace App\Exports;

use App\Models\Asistencia;
use App\Models\Matricula; // Asegúrate de importar tu modelo de Matrícula
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AlumnosAsistenciaExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    // Opcional: si quieres filtrar por periodo, docente, etc.
    // public function __construct(public string $periodo) {}

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function __construct(public int $periodoId) {}
    public function query()
    {
        // Esta es la consulta que construye tu reporte. Usamos JOINs para obtener datos legibles.
        return Asistencia::query()
            ->with([
                'matricula.alumnos.user',
                'matricula.alumnos.padre.user',
                'matricula.seccion.periodo',
                'matricula.seccion.talleres',
                'matricula.seccion.talleres.disciplina',

            ])->when($this->periodoId, function ($q) {
                $q->whereHas('matricula.seccion', function ($q) {
                    $q->where('periodo_id', $this->periodoId);
                });
            });
        // Opcional: 
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Estas son las cabeceras de las columnas en tu Excel.
        return [
            'Periodo',
            'Taller',
            'Categoría',
            'Sección',
            'Nombres Docente',
            'Apellido Paterno Docente',
            'Apellido Materno Docente',
            'Tipo de documento Docente',
            'Número documento Docente',
            'Email Docente',
            'Nombres Alumno',
            'Apellido Paterno Alumno',
            'Apellido Materno Alumno',
            'Tipo de documento Alumno',
            'Número de documento Alumno',
            'Email Alumno',
            'Nombres Apoderado',
            'Apellido Paterno Apoderado',
            'Apellido Materno Apoderado',
            'Tipo de documento Apoderado',
            'Número de documento Apoderado',
            'Email Apoderado',
            'Asistencia',
            'Observaciones',
            'Fecha de Asitencia'
            
        ];
    }

    /**
     * @param Matricula $matricula
     * @return array
     */
    public function map($asistencia): array
    {
        // Por cada fila de la consulta, definimos qué dato va en qué columna.
        // Esto nos da control total sobre el formato.
        $categoria = $asistencia->matricula->seccion->talleres->categoria;
       $nombreCategoria = null;
                                    if ($categoria->tiene_discapacidad){
                                       $nombreCategoria =  "Para personas con discapacidad";
                                    }
                                    else if($categoria->edad_min && $categoria->edad_max){
                                        $nombreCategoria = "De $categoria->edad_min a $categoria->edad_max años";
                                    }else if($categoria->edad_min){
                                        $nombreCategoria = "De $categoria->edad_min años a más";
                                    }
                                    else{
                                        $nombreCategoria = "Todas las edades";
                                    }
        return [
            // $matricula->id,
            $asistencia->matricula->seccion->periodo->anio.'-'.$asistencia->matricula->seccion->periodo->ciclo,
            $asistencia->matricula->seccion->talleres->disciplina->nombre,
            $nombreCategoria,
            $asistencia->matricula->seccion->nombre,
            $asistencia->matricula->seccion->docentes->user->nombres,
            $asistencia->matricula->seccion->docentes->user->apellido_paterno,
            $asistencia->matricula->seccion->docentes->user->apellido_materno,
            $asistencia->matricula->seccion->docentes->user->tipo_documento,
            $asistencia->matricula->seccion->docentes->user->numero_documento,
            $asistencia->matricula->seccion->docentes->user->email,
            $asistencia->matricula->alumnos->user->nombres,
            $asistencia->matricula->alumnos->user->apellido_paterno,
            $asistencia->matricula->alumnos->user->apellido_materno,
            $asistencia->matricula->alumnos->user->tipo_documento,
            $asistencia->matricula->alumnos->user->numero_documento,
            $asistencia->matricula->alumnos->user->email,
            $asistencia->matricula->alumnos->padre?->user->nombres,
            $asistencia->matricula->alumnos->padre?->user->apellido_paterno,
            $asistencia->matricula->alumnos->padre?->user->apellido_materno,
            $asistencia->matricula->alumnos->padre?->user->tipo_documento,
            $asistencia->matricula->alumnos->padre?->user->numero_documento,
            $asistencia->matricula->alumnos->padre?->user->email,
            $asistencia->estado,
            $asistencia->detalles,
            Carbon::parse($asistencia->fecha)->format('d/m/Y')
            // $matricula->seccion->talleres?->disciplina->nombre,
            // $matricula->seccion->nombre,
            // $matricula->alumnos?->user->numero_documento,
            // $matricula->alumnos?->user->nombres,
            // $matricula->alumnos?->user->apellido_paterno . ' ' . $matricula->alumnos?->user->apellido_materno,
            // $matricula->alumnos?->padre->user->numero_documento ?? 'N/A', // Usamos '??' por si un adulto se inscribe
            // $matricula->alumnos?->padre->user->nombres ?? 'N/A',
            // ($matricula->alumnos?->padre->user->apellido_paterno ?? '') . ' ' . ($matricula->alumnos->padre->user->apellido_materno ?? ''),
            // $matricula->alumnos?->padre->user->email ?? 'N/A',
            // $matricula->alumnos?->padre->user->telefono ?? 'N/A',
            // $matricula->seccion->docentes?->user->nombres . ' ' . $matricula->seccion->docentes?->user->apellido_paterno,
            // $matricula->created_at?->format('d/m/Y H:i'), // Formateamos la fecha
        ];
    }
}
