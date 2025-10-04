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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->string("codigo");
            $table->string("lugar_pago");
            $table->string("recibi_de");
            $table->dateTime("tiempo");
            $table->string("tipo_pago");
            $table->string("concepto");
            $table->string("comprobante");
            $table->decimal("monto", 10, 2);
            $table->string("moneda");
            $table->decimal("total", 10, 2);
            $table->string("estado");
            $table->foreignId('trabajador_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('cliente_id')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
