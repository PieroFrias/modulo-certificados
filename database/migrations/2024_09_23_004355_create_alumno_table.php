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
            $table->string('nombre', 255); // Columna para el nombre del alumno
            $table->string('apellido', 255); // Columna para el apellido del alumno
            $table->string('dni', 8)->unique(); // Columna para el DNI (8 caracteres, único)
            $table->unsignedBigInteger('idcurso'); // Relación con la tabla 'curso'
            $table->foreign('idcurso')->references('idcurso')->on('curso')->onDelete('cascade'); // Llave foránea con 'curso'
            $table->boolean('estado')->default(true); // Columna para el estado (activo/inactivo)
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
