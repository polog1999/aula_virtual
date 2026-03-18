<?php

// namespace App\Console\Commands;

// use App\Models\Sesion;
// use App\Models\Taller;
// use Carbon\Carbon;
// use Illuminate\Console\Command;

// class GenerarSesiones extends Command
// {
//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     protected $signature = 'sesiones:generar {taller_id} {--inicio=} {--fin=}';
//     //php artisan sesiones:generar 5 --inicio="2025-10-15" --fin="2025-10-31"

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = 'Generar sesiones de clase para un taller';

//     /**
//      * Execute the console command.
//      */
//    public function handle()
// {
//     $tallerId = $this->argument('taller_id');
//     $fechaInicio = Carbon::parse($this->option('inicio'));
//     $fechaFin = Carbon::parse($this->option('fin'));

//     $taller = Taller::with('horario')->findOrFail($tallerId);

//     // Días que dicta (ej: ['Martes','Jueves'])
//     $diasPermitidos = $taller->horario->pluck('dia_semana')->toArray();

//     // Recorremos desde fechaInicio hasta fechaFin
//     for ($fecha = $fechaInicio->copy(); $fecha->lte($fechaFin); $fecha->addDay()) {
//         $nombreDia = ucfirst($fecha->locale('es')->dayName); // "Martes", "Jueves", etc.
//          // Mostrar los días permitidos como string
//     // $this->info("Días permitidos: " . implode(', ', $diasPermitidos));
//         if (in_array(strtoupper($nombreDia), $diasPermitidos)) {
//             Sesion::firstOrCreate([
//                 'taller_id' => $taller->id,
//                 'fecha' => $fecha->toDateString()
//             ]);
//             // $this->info("{$fecha->toDateString()}");
//         }
//     }

//     $this->info("Sesiones generadas para el taller {$taller->nombre}");
// }
// }
