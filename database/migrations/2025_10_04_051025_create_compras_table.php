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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // código único de la compra
            $table->foreignId('proveedor_id')->constrained('proveedors')->onDelete('cascade');
            $table->foreignId('comprador_id')->constrained('users')->onDelete('cascade'); // quién compra
            $table->date('fecha_compra');
            $table->decimal('total', 12, 2)->default(0);
            $table->string('metodo_pago')->default('efectivo'); // efectivo, tarjeta, transferencia
            $table->date('fecha_llegada')->nullable(); // fecha de llegada
            $table->string('estado')->default('pendiente'); // pendiente, pagado, cancelado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
