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
        Schema::create('secciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio');
            // $table->date('fecha_fin');
            $table->string('nombre',100);
            $table->integer('vacantes');
            $table->boolean('activo');
            $table->foreignId('curso_id')->constrained()->onDelete('no action');
            $table->foreignId('docente_id')->references('user_id')->on('docentes');
            // $table->foreignId('lugar_id')->references('id')->on('lugares');
            $table->foreignId('periodo_id')->constrained();
            $table->timestamps();
            $table->unique(['curso_id','nombre', 'periodo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secciones');
    }
};
