<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    // Definir la tabla 'alumno'
    protected $table = 'alumno';

    // Relación con el modelo Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'idcurso', 'idcurso');
    }
}
