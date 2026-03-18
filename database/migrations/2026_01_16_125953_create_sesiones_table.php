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
        Schema::create('sesiones', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('seccion_id')->references('id')->on('secciones')->onDelete('cascade');
            $table->foreignId('modulo_id')->constrained()->onDelete('no action');
            $table->string('titulo');
            $table->text('descripcion');
            // $table->date('fecha');
            // $table->string('estado',20);
            // $table->string('link_reunion');
            $table->boolean('es_evaluacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesiones');
    }
};
