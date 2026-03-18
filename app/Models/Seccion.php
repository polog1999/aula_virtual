<?php

namespace App\Models;

use App\Enums\DiaSemana;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    protected $table = 'secciones';
    public $timestamps = false;
    protected $fillable = ['curso_id', 'docente_id', 'periodo_id', 'periodo', 'vacantes', 'activo', 'nombre', 'fecha_inicio', 'fecha_fin'];
    protected $casts = [
        'activo' => 'integer',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
    public function docentes()
    {
        return $this->belongsTo(Docente::class, 'docente_id', 'user_id');
    }
    public function lugares()
    {
        return $this->belongsTo(Lugar::class, 'lugar_id');
    }
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'seccion_id');
    }
    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }
    public function sesiones()
    {
        return $this->hasMany(Sesion::class, 'seccion_id');
    }
    // public function preInscripcion(){
    //     return $this->
    // }

    public function getDiaSemanaAttribute()
    {
        if ($this->horarios->isEmpty()) {
            return null;
        }
        // dump($this->horario->toArray());
        $diasHoras = $this->horarios->map(function ($h) {
            // Día en formato corto
            $dia = ucfirst(Str::substr(Str::lower($h->dia_semana), 0, 3));

            // Convertir horas usando Carbon
            $inicio = Carbon::parse($h->hora_inicio)->format('g:i a');
            $fin = Carbon::parse($h->hora_fin)->format('g:i a');

            return "$dia $inicio-$fin";
        });

        return $diasHoras->implode(' - ');
    }

    // public function generarSesiones(): void
    // {
    //     // 1. Obtenemos los días de la semana de la sección
    //     $diasDeClase = $this->horarios->pluck('dia_semana')->map(function ($dia) {
    //         $map = [
    //             'LUNES'     => Carbon::MONDAY,
    //             'MARTES'    => Carbon::TUESDAY,
    //             'MIÉRCOLES' => Carbon::WEDNESDAY,
    //             'JUEVES'    => Carbon::THURSDAY,
    //             'VIERNES'   => Carbon::FRIDAY,
    //             'SÁBADO'    => Carbon::SATURDAY,
    //             'DOMINGO'   => Carbon::SUNDAY,
    //         ];
    //         return $map[strtoupper($dia)] ?? null; // Usamos strtoupper para ser seguros
    //     })->filter()->toArray(); // filter() elimina los nulls si hay algún error
    //     // dd($seccion);
    //     // dd($diasDeClase);

    //     // Si no hay días definidos, no hacemos nada
    //     if (empty($diasDeClase)) {
    //         return;
    //     }

    //     // 2. Creamos un "periodo" de fechas desde el inicio hasta el fin de la sección
    //     $periodo = CarbonPeriod::create($this->fecha_inicio, $this->fecha_fin);

    //     $sesionesParaInsertar = [];

    //     // 3. Iteramos sobre cada día del periodo
    //     foreach ($periodo as $fecha) {
    //         // 4. Si el día de la semana de la fecha actual está en nuestro array de días de clase...
    //         if (in_array($fecha->dayOfWeek, $diasDeClase)) {
    //             // ...preparamos una nueva sesión para ser insertada.
    //             $sesionesParaInsertar[] = [
    //                 'seccion_id' => $this->id,
    //                 'fecha' => $fecha->toDateString(),
    //                 'estado' => 'Pendiente',
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ];
    //         }
    //     }

    //     // 5. Insertamos todas las sesiones en la base de datos de una sola vez (muy eficiente)
    //     if (!empty($sesionesParaInsertar)) {
    //         $this->sesiones()->insert($sesionesParaInsertar);
    //     }
    // }
    public function generarSesiones(): void
    {
        // 1. Obtenemos las sesiones maestras (la plantilla) del curso que tiene esta sección
        // Asumiendo que tu modelo Seccion tiene la relación 'curso' y el curso tiene 'modulos' y estos 'sesiones'
        $sesionesPlantilla = Sesion::whereHas('modulo', function ($q) {
            $q->where('curso_id', $this->curso_id);
        })->orderBy('modulo_id')->orderBy('id')->get(); // Las traemos en orden

        if ($sesionesPlantilla->isEmpty()) {
            return; // No hay nada que programar si el curso está vacío
        }

        // 2. Mapeamos los días de la semana (Tu lógica original)
        $diasDeClase = $this->horarios->pluck('dia_semana')->map(function ($dia) {
            $map = [
                'LUNES'     => \Carbon\Carbon::MONDAY,
                'MARTES'    => \Carbon\Carbon::TUESDAY,
                'MIÉRCOLES' => \Carbon\Carbon::WEDNESDAY,
                'JUEVES'    => \Carbon\Carbon::THURSDAY,
                'VIERNES'   => \Carbon\Carbon::FRIDAY,
                'SÁBADO'    => \Carbon\Carbon::SATURDAY,
                'DOMINGO'   => \Carbon\Carbon::SUNDAY,
            ];
            return $map[strtoupper($dia)] ?? null;
        })->filter()->toArray();

        if (empty($diasDeClase)) {
            return;
        }

        $sesionesParaInsertar = [];
        $fechaActual = \Carbon\Carbon::parse($this->fecha_inicio);
        $contadorSesiones = 0;
        $totalSesionesRequeridas = $sesionesPlantilla->count();

        // 3. El Bucle Mágico: Avanza día por día hasta que hayamos asignado todas las sesiones
        while ($contadorSesiones < $totalSesionesRequeridas) {

            // Si el día actual es uno de los días de clase permitidos...
            if (in_array($fechaActual->dayOfWeek, $diasDeClase)) {

                // Tomamos la sesión de la plantilla que corresponde
                $sesionMaestra = $sesionesPlantilla[$contadorSesiones];

                $sesionesParaInsertar[] = [
                    'seccion_id' => $this->id,
                    'sesion_id'  => $sesionMaestra->id, // IMPORTANTE: Vinculamos al contenido maestro
                    'fecha'      => $fechaActual->toDateString(),
                    'estado'     => 'Pendiente',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $contadorSesiones++; // Ya asignamos una sesión, vamos por la siguiente
            }

            $fechaActual->addDay(); // Pasamos al siguiente día del calendario
        }

        // 4. Inserción masiva
        if (!empty($sesionesParaInsertar)) {
            // Asegúrate de que la relación se llame seccionClases o como la hayas definido
            $this->seccionClase()->insert($sesionesParaInsertar);

            // OPCIONAL: Actualizar la fecha_fin de la sección automáticamente
            $ultimaFecha = end($sesionesParaInsertar)['fecha'];
            $this->update(['fecha_fin' => $ultimaFecha]);
        }
    }
    public function seccionClase()
    {
        return $this->hasMany(SeccionClase::class, 'seccion_id');
    }
}
