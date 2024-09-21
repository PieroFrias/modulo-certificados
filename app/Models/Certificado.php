<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;

    // Asegúrate de que el nombre de la tabla es correcto
    protected $table = 'certificados';
}
