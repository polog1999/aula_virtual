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
//         Schema::create('pagos', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('cronograma_pago_id')->constrained();
//             $table->decimal('monto_pagado', 10, 2);
//             $table->timestamp('fecha_pago');
//             $table->string('metodo_pago', 10);
//             $table->string('numero_orden', 20);
//             $table->boolean('terminos_aceptados')->default(false);
//             $table->string('ip_cliente', 45)->nullable();
//             $table->timestamp('fecha_aceptacion');
//             $table->foreignId('user_id')->constrained();
//             $table->foreignId('pagos_niubiz_id')->nullable()->references('id')->on('pagos_niubiz')->onDelete('restrict');

//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('pagos');
//     }
// };
