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
//         Schema::create('inscripciones', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('seccion_id')->references('id')->on('secciones');
//             $table->string('tipo_inscripcion',5);
//             $table->decimal('monto',10,2);
//             $table->string('estado',20)->nullable();
//             $table->string('numero_orden', 10)->nullable();
//             $table->string('visanet_auth_code')->nullable();
//             $table->uuid('reference_uuid');
//             $table->string('pasarela_transaccion_id')->nullable();
//             $table->string('numero_liquidacion',20)->nullable();
//             $table->boolean('es_vecino');
//             $table->foreignId('user_id')->nullable()->constrained();
//             $table->foreignId('inscripcion_apoderado_id')->nullable()->references('id')->on('inscripcion_apoderados');
//             $table->foreignId('inscripcion_alumno_id')->nullable()->references('id')->on('inscripcion_alumnos');
            
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('inscripciones');
//     }
// };
