<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class CertificadoController extends Controller
{
    public function index()
    {
        $certificados = Certificado::all();
        return view('certificados.index', compact('certificados'));
    }

    public function create()
    {
        return view('certificados.create');
    }

    public function store(Request $request)
    {
        // Validar el formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'template' => 'required|mimes:pdf|max:10240', // El archivo debe ser PDF y no exceder 10MB
        ]);

        // Verificar si el archivo fue cargado correctamente
        if ($request->hasFile('template')) {
            try {
                $file = $request->file('template');

                // Obtener el nombre original del archivo
                $filename = $file->getClientOriginalName();

                // Guardar el archivo en la carpeta 'certificados' dentro de 'storage/app/public/certificados'
                $filePath = $file->storeAs('certificados', $filename, 'public'); // Corregido para usar 'public'

                // Verificar si el archivo se guardó correctamente
                if (!$filePath) {
                    return redirect()->back()->with('error', 'No se pudo guardar el archivo.');
                }

                // Crear un nuevo registro en la base de datos con el nombre del archivo PDF
                $certificado = new Certificado();
                $certificado->nombre = $request->nombre;
                $certificado->template = $filename;  // Solo guardamos el nombre del archivo en la base de datos
                $certificado->fecha = now(); // Asignar la fecha actual
                $certificado->save();

                // Redirigir con un mensaje de éxito
                return redirect()->route('certificados.index')->with('success', 'Certificado creado correctamente.');

            } catch (\Exception $e) {
                // En caso de error, lo registramos y redirigimos con un mensaje de error
                Log::error('Error al guardar el certificado: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Hubo un problema al guardar el certificado. Por favor, inténtelo nuevamente.');
            }
        } else {
            // En caso de que no se haya subido el archivo correctamente
            return redirect()->back()->with('error', 'No se pudo cargar el archivo.');
        }
    }

    // Método edit para mostrar el formulario de edición
    public function edit($id)
    {
        // Buscar el certificado por ID
        $certificado = Certificado::findOrFail($id);

        // Retornar la vista de edición con el certificado encontrado
        return view('certificados.edit', compact('certificado'));
    }

    public function update(Request $request, $id)
    {
        // Validar el formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'template' => 'nullable|mimes:pdf|max:10240', // El archivo debe ser PDF y no exceder 10MB
        ]);

        // Buscar el certificado existente
        $certificado = Certificado::findOrFail($id);

        // Verificar si hay un nuevo archivo para subir
        if ($request->hasFile('template')) {
            $file = $request->file('template');

            // Obtener el nombre original del archivo
            $filename = $file->getClientOriginalName();

            // Guardar el archivo en la carpeta 'certificados'
            $filePath = Storage::putFileAs('certificados', $file, $filename);

            // Actualizar el nombre del archivo en la base de datos
            $certificado->template = $filename;
        }

        // Actualizar el nombre del certificado
        $certificado->nombre = $request->nombre;
        $certificado->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('certificados.index')->with('success', 'Certificado actualizado correctamente.');
    }

    public function destroy($id)
    {
        // Buscar el certificado por ID
        $certificado = Certificado::findOrFail($id);

        // Eliminar el archivo del disco
        Storage::delete('certificados/' . $certificado->template);

        // Eliminar el registro de la base de datos
        $certificado->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('certificados.index')->with('success', 'Certificado eliminado correctamente.');
    }

    public function show($id)
{
    // Buscar el certificado por ID
    $certificado = Certificado::findOrFail($id);

    // Obtener la URL del archivo PDF
    $url = Storage::url('certificados/' . $certificado->template);

    // Retornar la vista de visualización con la variable $certificado y la URL
    return view('certificados.view', compact('certificado', 'url'));
}

}
