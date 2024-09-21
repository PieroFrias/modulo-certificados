<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('certificados', function (Blueprint $table) {
        $table->id();
        $table->string('nombre'); // El nombre del usuario
        $table->string('template'); // Ruta al archivo PDF del certificado
        $table->date('fecha'); // Fecha del certificado
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
