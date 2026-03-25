<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inscripciones', function (Blueprint $table) {
            // Añadimos la columna. Si es una relación, lo ideal es unsignedBigInteger
            $table->foreignId('seccion_id')->nullable()->after('nivel_establecimiento')->on('secciones')->onDelete('no action');
            
            // Opcional: Si quieres que sea una llave foránea real
            // $table->foreign('seccion_id')->references('id')->on('secciones');
        });
    }

    public function down(): void
    {
        Schema::table('inscripciones', function (Blueprint $table) {
            $table->dropColumn('seccion_id');
        });
    }
};