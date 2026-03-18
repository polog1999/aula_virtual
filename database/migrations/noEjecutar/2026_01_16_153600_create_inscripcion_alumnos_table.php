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
//         Schema::create('inscripcion_alumnos', function (Blueprint $table) {
//             $table->id();
//             $table->string('nombres', 100);
//             $table->string('apellido_paterno', 100);
//             $table->string('apellido_materno', 100);
//             $table->date('fecha_nacimiento');
//             $table->string('email', 320)->nullable()->unique();
//             $table->string('direccion', 150)->nullable();
//             $table->string('tipo_documento', 3);
//             $table->string('numero_documento', 8)->unique();
//             $table->string('celular', 9)->nullable();
//             $table->string('numero_conadis',30)->nullable();
//             $table->string('distrito', 25)->nullable();
//             $table->string('numero_contribuyente')->nullable();
//             $table->string('codigo_distrito')->nullable();
//             $table->foreignId('user_id')->nullable()->constrained();

//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('inscripcion_alumnos');
//     }
// };
