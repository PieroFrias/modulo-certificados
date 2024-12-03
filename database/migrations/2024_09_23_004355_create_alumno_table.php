<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno', function (Blueprint $table) {
            $table->id(); // Llave primaria
            $table->string('nombre', 255)->nullable(); // Columna para el nombre del alumno
            $table->string('apellido', 255)->nullable(); // Columna para el apellido del alumno
            $table->string('dni', 15)->nullable(); // Columna para el DNI (máximo 15 caracteres, sin unique)
            $table->string('correo', 255)->nullable(); // Columna para el correo (acepta valores nulos)
            $table->unsignedBigInteger('idcurso')->nullable(); // Relación con la tabla 'curso'
            $table->foreign('idcurso')->references('idcurso')->on('curso')->onDelete('set null')->onUpdate('restrict'); // Llave foránea con restricciones
            $table->string('codigo', 255)->nullable(); // Columna para el código (acepta valores nulos)
            $table->boolean('estado')->default(1)->nullable(); // Columna para el estado (activo/inactivo)
            $table->boolean('enviado')->default(0)->nullable(); // Nueva columna para rastrear si se ha enviado
            $table->unsignedInteger('vecesenviado')->default(0)->nullable(); // Nueva columna para contar veces enviado
            $table->timestamps(); // Columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumno');
    }
}
