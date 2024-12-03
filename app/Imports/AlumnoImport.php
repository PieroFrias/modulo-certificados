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
        // Filtrar y formatear los datos
        $nombre = mb_strtoupper(preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/u', '', trim($row[1])), 'UTF-8'); // Convertir a mayúsculas incluyendo tildes
        $apellido = mb_strtoupper(preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/u', '', trim($row[2])), 'UTF-8'); // Convertir a mayúsculas incluyendo tildes
        $dni = preg_replace('/\D/', '', trim($row[5])); // Solo números
        $correo = filter_var(trim($row[6]), FILTER_SANITIZE_EMAIL); // Filtrar correo

        // Buscar si el registro ya existe basándose en el correo
        $existingAlumno = Alumno::where('correo', $correo)
            ->where('idcurso', $this->idCurso)
            ->first();

        if ($existingAlumno) {
            // Completar los datos que faltan si están vacíos en la base de datos
            $hasChanges = false;

            if (empty($existingAlumno->nombre) && !empty($nombre)) {
                $existingAlumno->nombre = $nombre;
                $hasChanges = true;
            }

            if (empty($existingAlumno->apellido) && !empty($apellido)) {
                $existingAlumno->apellido = $apellido;
                $hasChanges = true;
            }

            if (empty($existingAlumno->dni) && !empty($dni)) {
                $existingAlumno->dni = $dni;
                $hasChanges = true;
            }

            // Guardar solo si hubo cambios
            if ($hasChanges) {
                $existingAlumno->updated_at = now(); // Actualizar la fecha de modificación
                $existingAlumno->save();
            }

            return null; // No crear un nuevo registro, solo actualizar el existente si hubo cambios
        }

        // Si no se encuentra un registro existente, crear uno nuevo
        return new Alumno([
            'nombre' => $nombre ?: 'N/A', // Usar 'N/A' si el nombre está vacío
            'apellido' => $apellido ?: 'N/A', // Usar 'N/A' si el apellido está vacío
            'dni' => $dni ?: null, // Permitir que el DNI sea nulo
            'correo' => $correo ?: null, // Permitir que el correo sea nulo
            'idcurso' => $this->idCurso, // Usar el ID del curso proporcionado
            'codigo' => null, // Dejar el código vacío
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
