<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    // Especificar la tabla
    protected $table = 'alumno';

    // Especificar la clave primaria
    protected $primaryKey = 'id';

    // Especificar los campos que se pueden asignar en masa
    protected $fillable = ['nombre', 'apellido', 'dni', 'correo', 'idcurso', 'estado'];

    public $timestamps = true; // Esto habilita los timestamps automáticamente

    // Definir la relación con la tabla curso
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'idcurso', 'idcurso')->where('estado', 1);
    }

}
