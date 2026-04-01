<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesion_recursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesion_id')->constrained('sesiones')->onDelete('cascade');
            $table->string('nombre');       // Nombre visible para el alumno
            $table->string('url_path');     // Ruta del archivo en storage o URL externa
            $table->string('tipo', 20);     // 'ARCHIVO' o 'LINK'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesion_recursos');
    }
};