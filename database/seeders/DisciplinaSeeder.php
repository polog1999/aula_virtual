<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\CodigoTusne;
use App\Models\Disciplina;
use App\Models\Docente;
use App\Models\Horario;
use App\Models\Lugar;
use App\Models\Periodo;
use App\Models\Seccion;
use App\Models\Taller;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DisciplinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

   $userDocente1 = User::create([
            'nombres' => 'Docente',
            'apellido_paterno' => 'Numero 1',
            'apellido_materno' => null,
            'fecha_nacimiento' => now(),
            'tipo_documento' => 'DNI',
            'numero_documento' => '02020202',
            'email' => 'docente1@example.com',
            'password' => Hash::make('password'),
            'role' => 'DOCENTE',
            'activo' => 1,
            'es_docente' => 1
        ]);
        $docente1 = $userDocente1->docente()->create([]);

        // $disciplina1 = Disciplina::create([
        //     'nombre' => 'Fútbol',
        //     'imagen' => 'imagenes/bXgX5pDiBHMHGuUiZIu4LOqMUoeIGvrBb0ibFzKm.jpg',
        //     'activo' => 1
        // ]);
        // $categoria1 = Categoria::create([
        //     'edad_min' => 25,
        //     'tiene_discapacidad' => 0,
            
        // ]);
        // $categoria2 = Categoria::create([
        //     'edad_min' => 10,
        //     'edad_max' => 14,
        //     'tiene_discapacidad' => 0,
            
        // ]);
        // $categoria3 = Categoria::create([
        //     'tiene_discapacidad' => 0, 
        // ]);
        // $periodo1 = Periodo::create([
        //     'ciclo' => 'Verano',
        //     'anio' => 2025,
        //     'fecha_inicio' => '2026-01-15',
        //     'fecha_fin' => '2026-03-15'
        // ]);

        // $sede1 = Lugar::create([
        //     'nombre' => 'Estadio Municipal',
        //     'direccion' => 'Fin del Mundo',
        //     'link_maps' => 'https://www.google.com'
        // ]);

        

        // $taller1 = Taller::create([
        //     'disciplina_id' => $disciplina1->id,
        //     'categoria_id' => $categoria1->id,
        //     'activo' => 1
        // ]);
        // $taller2 = Taller::create([
        //     'disciplina_id' => $disciplina1->id,
        //     'categoria_id' => $categoria2->id,
        //     'activo' => 1
        // ]);

        // $taller1->tusnes()->create([
        //     'grupo' => '23',
        //     'codigo' => 'O0068',
        //     'es_vecino' => 1,
        // ]);

        // $taller1->tusnes()->create([
        //     'grupo' => '23',
        //     'codigo' => 'O0071',
        //     'es_vecino' => 0,
        // ]);

        // $taller2->tusnes()->create([
        //     'grupo' => '23',
        //     'codigo' => 'O0015',
        //     'es_vecino' => 1,
        // ]);

        // $taller2->tusnes()->create([
        //     'grupo' => '23',
        //     'codigo' => 'O0035',
        //     'es_vecino' => 0,
        // ]);

        // $seccion1 = Seccion::create([
        //     'fecha_inicio' => $periodo1->fecha_inicio,
        //     'fecha_fin' => $periodo1->fecha_fin,
        //     'nombre' => 'A',
        //     'vacantes' => 20,
        //     'activo' => 1,
        //     'taller_id' => $taller1->id,
        //     'docente_id' => $docente1->user_id,
        //     'lugar_id' => $sede1->id,
        //     'periodo_id' => $periodo1->id

        // ]);

        // $seccion1->horarios()->create([
        //     'dia_semana' => 'LUNES',
        //     'hora_inicio' => '09:00:00',
        //     'hora_fin' => '10:00:00'
        // ]);

        
    }
}
