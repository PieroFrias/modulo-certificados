<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Support\Facades\Storage;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        // Almacenar resultados de búsqueda
        $alumnos = null;

        // Validar entradas
        $request->validate([
            'dni' => 'nullable|numeric|max_digits:15',
            'correo' => 'nullable|email',
        ], [
            'dni.numeric' => 'El DNI solo puede contener números.',
            'dni.max_digits' => 'El DNI no puede tener más de 15 dígitos.',
            'correo.email' => 'El formato del correo no es válido.',
        ]);

        // Buscar por DNI o correo
        if ($request->filled('dni')) {
            $alumnos = Alumno::with('curso.certificado')
                ->where('dni', $request->dni)
                ->where('estado', 1) // Filtrar alumnos activos
                ->whereHas('curso', function ($query) {
                    $query->where('estado', 1); // Filtrar cursos activos
                })
                ->get();
        } elseif ($request->filled('correo')) {
            $alumnos = Alumno::with('curso.certificado')
                ->where('correo', $request->correo)
                ->where('estado', 1) // Filtrar alumnos activos
                ->whereHas('curso', function ($query) {
                    $query->where('estado', 1); // Filtrar cursos activos
                })
                ->get();
        }

        // Retornar la vista con los resultados
        return view('consulta.index', compact('alumnos'));
    }

    public function descargarCertificado($codigo)
    {
        // Buscar el archivo en la ruta especificada
        $filePath = "certificados_firmados/{$codigo}.pdf";

        if (Storage::disk('public')->exists($filePath)) {
            return response()->download(storage_path("app/public/{$filePath}"));
        }

        return redirect()->route('consulta.index')->with('error', 'No se encontró el certificado.');
    }
}
