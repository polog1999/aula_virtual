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
        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained()->onDelete('no action');
            $table->string('nombre',100);
            $table->text('descripcion');
            $table->integer('orden');
            $table->date('disponible_desde');
            $table->foreignId('prerequisito_id')->nullable()->on('modulos')->onDelete('no action');
            $table->boolean('activo');
            $table->timestamps();
            // $table->unique(['disciplina_id','categoria_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
