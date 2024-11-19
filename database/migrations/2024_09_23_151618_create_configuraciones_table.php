<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracionesTable extends Migration
{
    public function up()
    {
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id(); // Llave primaria
            $table->unsignedBigInteger('idcertificado'); // Relación con la tabla certificados
            $table->decimal('pos_x', 11, 0)->default(0); // Posición horizontal con precisión decimal
            $table->decimal('pos_y', 11, 0)->default(0); // Posición vertical con precisión decimal
            $table->string('fuente', 255)->default('Arial'); // Fuente de la letra
            $table->integer('tamaño_fuente')->default(16); // Tamaño de la letra
            $table->string('tipo', 255)->nullable(); // Columna tipo opcional
            $table->string('estado', 255)->nullable(); // Columna estado opcional
            $table->timestamps(); // created_at y updated_at

            // Foreign key para relacionar con la tabla certificados
            $table->foreign('idcertificado')
                ->references('id')
                ->on('certificados')
                ->onDelete('restrict') // Acción ON DELETE
                ->onUpdate('restrict'); // Acción ON UPDATE
        });
    }


    public function down()
    {
        Schema::dropIfExists('configuraciones');
    }
}
