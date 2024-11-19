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
            $table->id('idcurso'); // Llave primaria llamada idcurso
            $table->unsignedBigInteger('idcertificado'); // Llave foránea relacionada con la tabla certificados
            $table->string('nombre', 255); // Nombre del curso
            $table->integer('hora')->nullable(); // Campo hora
            $table->boolean('estado')->default(true); // Estado del curso (activo/inactivo)
            $table->timestamps(); // Campos created_at y updated_at

            // Relación con la tabla certificados
            $table->foreign('idcertificado')->references('id')->on('certificados')->onDelete('restrict')->onUpdate('restrict');
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
