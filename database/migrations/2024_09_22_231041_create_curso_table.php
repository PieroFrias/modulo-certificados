<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso', function (Blueprint $table) {
            // Columnas de la tabla
            $table->id('idcurso'); // Llave primaria llamada 'idcurso'
            $table->unsignedBigInteger('idcertificado'); // Columna para relacionar con el certificado
            $table->string('nombre', 255); // Columna de nombre del curso
            $table->boolean('estado')->default(true); // Columna para estado del curso (activo/inactivo)
            $table->timestamps(); // Crea automáticamente las columnas created_at y updated_at

            // Establecer relación con la tabla de certificados
            $table->foreign('idcertificado')->references('id')->on('certificados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curso');
    }
}
