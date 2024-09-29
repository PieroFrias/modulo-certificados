<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracionesTable extends Migration
{
    public function up()
    {
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idcertificado');  // Relación con la tabla certificados
            $table->integer('pos_x')->default(50);        // Posición horizontal
            $table->integer('pos_y')->default(100);       // Posición vertical
            $table->string('fuente')->default('Arial');   // Fuente de la letra
            $table->integer('tamaño_fuente')->default(16);  // Tamaño de la letra
            $table->timestamps();

            // Foreign key para relacionar con la tabla certificados
            $table->foreign('idcertificado')->references('id')->on('certificados')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('configuraciones');
    }
}
