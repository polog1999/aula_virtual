<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::factory()->create([
            'nombres' => 'Administrador',
            'apellido_paterno' => 'Del',
            'apellido_materno' => 'Sistema',
            'fecha_nacimiento' => now(),
            'tipo_documento' => 'DNI',
            'numero_documento' => '01010101',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
            'activo' => 1
        ]);
        $this->call([
            DisciplinaSeeder::class
        ]);
    }
}
