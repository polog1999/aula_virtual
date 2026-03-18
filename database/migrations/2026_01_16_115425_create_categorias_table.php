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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            // $table->integer('edad_min')->nullable();
            // $table->integer('edad_max')->nullable();
            // $table->boolean('tiene_discapacidad')->nullable();
            $table->timestamps();
            // $table->unique(['edad_min','edad_max', 'tiene_discapacidad']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
