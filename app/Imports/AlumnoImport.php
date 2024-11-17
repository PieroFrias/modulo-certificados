<?php

namespace App\Imports;

use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumnoImport implements ToModel, WithBatchInserts, WithHeadingRow
{
    protected $idCurso;
    protected $importedDniNames; // Almacena combinaciones DNI + Nombre del archivo para evitar duplicados en el mismo archivo

    // Constructor para recibir el ID del curso
    public function __construct($idCurso)
    {
        // Asignar el curso directamente usando el ID proporcionado
        $this->idCurso = $idCurso;

        // Inicializar el array para evitar duplicados en el archivo de importación
        $this->importedDniNames = [];
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Filtrar solo letras (A-Z, a-z) para las celdas 1 (nombre) y 2 (apellido), y convertir a mayúsculas
        $nombre = strtoupper(preg_replace('/[^a-zA-Z\s]/', '', trim($row[1]))); // Solo letras y espacios en mayúsculas
        $apellido = strtoupper(preg_replace('/[^a-zA-Z\s]/', '', trim($row[2]))); // Solo letras y espacios en mayúsculas

        // Filtrar solo números para la celda 5 (DNI)
        $dni = preg_replace('/\D/', '', trim($row[5])); // Solo números

        // Verificar si nombre, apellido o DNI están vacíos después del filtro
        if (empty($nombre) || empty($apellido) || empty($dni)) {
            return null; // Saltar registro si algún campo esencial está vacío
        }

        // Generar la clave compuesta para evitar duplicados en el archivo
        $dniNameKey = $dni . '|' . $nombre . ' ' . $apellido;
        if (in_array($dniNameKey, $this->importedDniNames)) {
            return null; // Saltar registro duplicado en el archivo
        }

        // Verificar si ya existe el DNI para el curso actual en la base de datos
        $existing = Alumno::where('dni', $dni)
            ->where('idcurso', $this->idCurso)
            ->exists();

        if ($existing) {
            return null; // Saltar si el DNI ya existe para este curso
        }

        // Marcar como procesado para evitar duplicados en este archivo
        $this->importedDniNames[] = $dniNameKey;

        return new Alumno([
            'nombre' => $nombre, // Nombre filtrado y en mayúsculas
            'apellido' => $apellido, // Apellido filtrado y en mayúsculas
            'dni' => $dni, // DNI filtrado
            'idcurso' => $this->idCurso, // Usar el ID del curso proporcionado
            'created_at' => now(), // Fecha de creación
            'updated_at' => now(), // Fecha de actualización
        ]);
    }

    /**
     * Límite de filas para la inserción por lote (mejora rendimiento).
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Indicar la fila de encabezados en el Excel.
     */
    public function headingRow(): int
    {
        return 1; // Cambiar si los encabezados están en otra fila
    }
}
