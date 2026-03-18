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
//         Schema::create('cronograma_pagos', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('matricula_id')->constrained()->onDelete('cascade');
//             $table->string('concepto', 150);
//             $table->decimal('monto', 10, 2);
//             $table->date('fecha_vencimiento')->nullable();
//             $table->string('estado');
//             $table->timestamp('fecha_pago')->nullable();
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('cronograma_pagos');
//     }
// };
