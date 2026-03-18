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
//         Schema::create('pagos_niubiz', function (Blueprint $table) {
//             $table->id();
//             $table->string('num_orden_niubiz')->nullable();
//             $table->string('id_transaccion_niubiz')->nullable();
//             $table->string('codigo_autorizacion')->nullable();
//             $table->decimal('monto_pagado',10,2)->nullable();
//             $table->string('moneda')->nullable();
//             $table->string('marca_tarjeta')->nullable();
//             $table->string('tarjeta_enmascarada')->nullable();
//             $table->string('codigo_accion')->nullable();
//             $table->string('descripcion_estado')->nullable();
//             $table->string('fecha_transaccion')->nullable();
//             $table->uuid('ecoreTransactionUUID')->nullable();
//             $table->string('merchantId')->nullable();
//             $table->string('terminalId')->nullable();
//             $table->string('captureType')->nullable();
//             $table->string('tokenId')->nullable();
//             $table->string('estado')->nullable();
//             $table->string('eci_descripcion')->nullable();
//             $table->json('json_niubiz')->nullable();
//             $table->string('id_unico')->nullable();
//             $table->string('brand')->nullable();
//             $table->json('trace_number')->nullable();
//             $table->string('id_resolutor')->nullable();
//             $table->string('signature')->nullable();
//             $table->string('authorization_code')->nullable();
//             $table->foreignId('inscripcion_id')->nullable()->references('id')->on('inscripciones');
//             $table->foreignId('cronograma_pago_id')->nullable()->constrained();
//             $table->timestamps();
            
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('pagos_niubiz');
//     }
// };
