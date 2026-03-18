<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
 // 1. Crear o recuperar Roles
        $admin   = Role::firstOrCreate(['name' => 'admin']);
        $docente = Role::firstOrCreate(['name' => 'docente']);
        $alumno  = Role::firstOrCreate(['name' => 'alumno']);
        $encargadoSede  = Role::firstOrCreate(['name' => 'encargado_sede']);

        // 2. Crear o recuperar Permisos
        $gestionarCursos = Permission::firstOrCreate(['name' => 'gestionar-cursos']);
        $subirRecursos   = Permission::firstOrCreate(['name' => 'subir-recursos']);
        $marcarAsistencia   = Permission::firstOrCreate(['name' => 'marcar-asistencia']);

        // 3. Asignar Permisos a Roles (syncPermissions evita duplicados en la tabla intermedia)}
        $encargadoSede->syncPermissions([$marcarAsistencia]);
        $admin->syncPermissions([$gestionarCursos, $subirRecursos]);
        $docente->syncPermissions([$subirRecursos]);

        $useradmin = User::find(1);
        $useradmin->assignRole($admin);
        
        // El alumno no tiene permisos de edición, así que no le asignamos estos.
}
}
