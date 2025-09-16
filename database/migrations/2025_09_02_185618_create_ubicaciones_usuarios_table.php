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
        Schema::create('ubicaciones_usuarios', function (Blueprint $table) {
            $table->id();
             $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->string('nombre', 255);
            $table->string('observaciones', 255)->nullable();
            $table->string('url_map')->nullable(); // string es lo más flexible
            $table->string('persona_referencia', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicaciones_usuarios');
    }
};
