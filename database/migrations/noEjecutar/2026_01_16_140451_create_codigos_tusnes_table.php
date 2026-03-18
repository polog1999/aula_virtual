<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('codigos_tusnes', function (Blueprint $table) {
//             $table->id();
//             $table->string('grupo',2);
//             $table->string('codigo',5);
//             $table->foreignId('taller_id')->references('id')->on('talleres')->onDelete('cascade');
//             $table->boolean('es_vecino');
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('codigos_tusnes');
//     }
// };
