<?php

namespace App\Exports;

use App\Models\Matricula; // Asegúrate de importar tu modelo de Matrícula
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AlumnosMatriculadosExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    // Opcional: si quieres filtrar por periodo, docente, etc.
    // public function __construct(public string $periodo) {}

    /**
    * @return \Illuminate\Database\Query\Builder
    */
    public function query()
    {
        // Esta es la consulta que construye tu reporte. Usamos JOINs para obtener datos legibles.
        return Matricula::query()
            ->with([
                'seccion.talleres.disciplina', 
                'seccion.docentes.user', 
                'seccion.periodo',
                'seccion.talleres',
                'seccion.lugares',
                'alumnos.user', 
                'alumnos.padre.user'
            ]);
            // Opcional: ->where('periodo', $this->periodo);
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
            'Sección',
            'DNI Alumno',
            'Nombre Alumno',
            'Apellidos Alumno',
            'DNI Apoderado',
            'Nombre Apoderado',
            'Apellidos Apoderado',
            'Email Apoderado',
            'Celular Apoderado',
            'Docente',
            'Fecha Matrícula',
        ];
    }

    /**
    * @param Matricula $matricula
    * @return array
    */
    public function map($matricula): array
    {
        // Por cada fila de la consulta, definimos qué dato va en qué columna.
        // Esto nos da control total sobre el formato.
        return [
            // $matricula->id,
            $matricula->seccion->periodo->anio.'-'.$matricula->seccion->periodo->ciclo,
            $matricula->seccion->talleres?->disciplina->nombre,
            $matricula->seccion->nombre,
            $matricula->alumnos?->user->numero_documento,
            $matricula->alumnos?->user->nombres,
            $matricula->alumnos?->user->apellido_paterno . ' ' . $matricula->alumnos?->user->apellido_materno,
            $matricula->alumnos?->padre->user->numero_documento ?? 'N/A', // Usamos '??' por si un adulto se inscribe
            $matricula->alumnos?->padre->user->nombres ?? 'N/A',
            ($matricula->alumnos?->padre->user->apellido_paterno ?? '') . ' ' . ($matricula->alumnos->padre->user->apellido_materno ?? ''),
            $matricula->alumnos?->padre->user->email ?? 'N/A',
            $matricula->alumnos?->padre->user->telefono ?? 'N/A',
            $matricula->seccion->docentes?->user->nombres . ' ' . $matricula->seccion->docentes?->user->apellido_paterno,
            $matricula->created_at?->format('d/m/Y H:i'), // Formateamos la fecha
        ];
    }
}