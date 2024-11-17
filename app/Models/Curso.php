<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'curso';
    protected $primaryKey = 'idcurso';
    protected $fillable = ['nombre', 'estado', 'idcertificado'];

    // Relación con el modelo Certificado
    public function certificado()
    {
        return $this->belongsTo(Certificado::class, 'idcertificado', 'id');
    }
    

    // Relación con el modelo Alumno
    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'idcurso', 'idcurso');
    }
}
