<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seccion_clases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seccion_id')->on('secciones')->onDelete('no action');
            $table->foreignId('sesion_id')->on('sesiones')->onDelete('no action');
            $table->date('fecha');                          // La fecha calculada
            $table->string('link_reunion')->nullable();     // Zoom/Meet específico para esta clase
            $table->string('estado', 20)->default('PROGRAMADA');
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seccion_clases');
    }
};
