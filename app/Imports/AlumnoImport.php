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
        // Permitir letras con tildes y espacios (regex actualizado)
        $nombre = mb_strtoupper(preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/u', '', trim($row[1])), 'UTF-8'); // Convertir a mayúsculas incluyendo tildes
        $apellido = mb_strtoupper(preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/u', '', trim($row[2])), 'UTF-8'); // Convertir a mayúsculas incluyendo tildes
        $dni = preg_replace('/\D/', '', trim($row[5])); // Solo números
        $correo = filter_var(trim($row[6]), FILTER_SANITIZE_EMAIL); // Filtrar correo

        // Validar si los campos esenciales están vacíos o el correo es inválido
        if (empty($dni) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return null; // Saltar el registro si el DNI es inválido o el correo no es válido
        }

        // Buscar si el registro ya existe en la base de datos
        $existingAlumno = Alumno::where('dni', $dni)
            ->where('idcurso', $this->idCurso)
            ->first();

        if ($existingAlumno) {
            // Revisar si los datos han cambiado
            $hasChanges = false;

            if ($existingAlumno->nombre !== $nombre) {
                $existingAlumno->nombre = $nombre;
                $hasChanges = true;
            }

            if ($existingAlumno->apellido !== $apellido) {
                $existingAlumno->apellido = $apellido;
                $hasChanges = true;
            }

            if ($existingAlumno->correo !== $correo) {
                $existingAlumno->correo = $correo;
                $hasChanges = true;
            }

            if ($hasChanges) {
                $existingAlumno->updated_at = now(); // Actualizar la fecha de modificación solo si hubo cambios
                $existingAlumno->save();
            }

            return null; // No crear un nuevo registro, solo actualizar el existente si hubo cambios
        }

        // Si el registro no existe, crear uno nuevo
        return new Alumno([
            'nombre' => $nombre, // Nombre filtrado y en mayúsculas
            'apellido' => $apellido, // Apellido filtrado y en mayúsculas
            'dni' => $dni, // DNI filtrado
            'correo' => $correo, // Guardar el correo
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
