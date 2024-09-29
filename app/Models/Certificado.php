<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;

    protected $table = 'certificados';  // Define la tabla asociada

    protected $fillable = [
        'nombre',        // Nombre del certificado (asumiendo que hay una columna nombre)
        'template',      // Plantilla del certificado (si hay una columna para el archivo PDF)
        // Otros campos que puedas tener
    ];

    // Relación con el modelo Configuracion
    public function configuracion()
    {
        return $this->hasOne(Configuracion::class, 'idcertificado');
    }
}
