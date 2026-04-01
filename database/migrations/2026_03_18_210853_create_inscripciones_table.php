<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscripciones', function (Blueprint $blueprint) {
            $blueprint->id();
            
            // Datos del Participante (del formulario)
            $blueprint->string('nombres');
            $blueprint->string('apellidos');
            $blueprint->string('dni', 8);
            $blueprint->string('colegiatura');
            $blueprint->string('email');
            $blueprint->string('profesion');
            $blueprint->string('nivel_establecimiento');
            
            // Ubicación (SUSALUD)
            $blueprint->string('region');
            $blueprint->string('diris_diresa');
            $blueprint->string('establecimiento');

            
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};