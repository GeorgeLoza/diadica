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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // código único de la venta
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade'); // cliente que compra
            $table->foreignId('vendedor_id')->constrained('users')->onDelete('cascade'); // vendedor (tu usuario interno)
            $table->date('fecha_venta');
            $table->decimal('total', 12, 2)->default(0);
            $table->string('estado')->default('pendiente'); // pendiente, pagado, anulado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
