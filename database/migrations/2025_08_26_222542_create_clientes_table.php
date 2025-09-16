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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_empresa')->nullable();
            $table->string('nombre_cliente')->nullable();
            $table->string('nit_ci')->unique()->nullable();
            $table->integer('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->decimal('credito', 15, 2)->default(0);
            $table->decimal('saldo', 15, 2)->default(0);
            $table->dateTime('fecha_registro')->useCurrent();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
