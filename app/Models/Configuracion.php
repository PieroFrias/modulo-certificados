<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $table = 'configuraciones';  // Define la tabla asociada

    protected $fillable = [
        'idcertificado',  // Relación con la tabla certificados
        'pos_x',          // Posición horizontal
        'pos_y',          // Posición vertical
        'fuente',         // Fuente de la letra
        'tamaño_fuente'   // Tamaño de la letra
    ];

    // Relación con el modelo Certificado
    public function certificado()
    {
        return $this->belongsTo(Certificado::class, 'idcertificado');
    }
}
