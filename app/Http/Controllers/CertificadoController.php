<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;


class CertificadoController extends Controller
{
    public function index()
    {
        $certificados = Certificado::orderBy('updated_at', 'desc')->get();
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

        if ($request->hasFile('template')) {
            try {
                $file = $request->file('template');

                // Obtener el nombre original del archivo
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Sin extensión
                $extension = $file->getClientOriginalExtension();

                // Crear el nuevo nombre del archivo: nombre original + nombre de la plantilla
                $filename = str_replace(' ', '_', $request->nombre) . '_' . $originalFilename . '.' . $extension;

                // Guardar el archivo en la carpeta 'certificados' dentro de 'storage/app/public'
                $filePath = $file->storeAs('certificados', $filename, 'public');

                if (!$filePath) {
                    return redirect()->back()->with('error', 'No se pudo guardar el archivo.');
                }

                // Crear el registro en la base de datos
                $certificado = new Certificado();
                $certificado->nombre = $request->nombre;
                $certificado->template = $filename; // Guardar el nuevo nombre en la base de datos
                $certificado->fecha = now();
                $certificado->save();

                return redirect()->route('certificados.index')->with('success', 'Certificado creado correctamente.');
            } catch (\Exception $e) {
                Log::error('Error al guardar el certificado: ' . $e->getMessage());
                return redirect()->back()->withErrors(['template' => 'Hubo un problema al procesar el PDF.']);
            }
        } else {
            return redirect()->back()->withErrors(['template' => 'No se pudo cargar el archivo.']);
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
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'template' => 'nullable|mimes:pdf|max:10240', // El archivo debe ser PDF y no exceder 10MB
        ]);

        $certificado = Certificado::findOrFail($id);

        if ($request->hasFile('template')) {
            try {
                // Ruta completa del archivo anterior
                $previousFilePath = 'certificados/' . $certificado->template;

                // Eliminar la plantilla anterior si existe
                if ($certificado->template && Storage::disk('public')->exists($previousFilePath)) {
                    Storage::disk('public')->delete($previousFilePath);
                }

                $file = $request->file('template');

                // Obtener el nombre original del archivo sin extensión
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();

                // Crear el nuevo nombre del archivo: nombre de la plantilla + nombre original del archivo
                $filename = str_replace(' ', '_', $request->nombre) . '_' . $originalFilename . '.' . $extension;

                // Guardar el nuevo archivo en la carpeta 'certificados' dentro de 'storage/app/public'
                $filePath = $file->storeAs('certificados', $filename, 'public');

                if (!$filePath) {
                    throw new \Exception('No se pudo guardar el archivo en la carpeta certificados.');
                }

                // Actualizar el nombre del archivo en la base de datos
                $certificado->template = $filename;
            } catch (\Exception $e) {
                Log::error('Error al verificar o guardar el archivo PDF: ' . $e->getMessage());
                return redirect()->back()->withErrors(['template' => 'Hubo un problema al guardar el PDF.']);
            }
        }

        $certificado->nombre = $request->nombre;
        $certificado->save();

        return redirect()->route('certificados.index')->with('success', 'Certificado actualizado correctamente.');
    }



    public function destroy($id)
{
    // Buscar el certificado por ID
    $certificado = Certificado::findOrFail($id);

    try {
        // Eliminar el archivo del disco si existe
        $filePath = 'certificados/' . $certificado->template;
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Eliminar el registro de la base de datos
        $certificado->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('certificados.index')->with('success', 'Certificado eliminado correctamente.');
    } catch (\Exception $e) {
        Log::error('Error al eliminar el archivo o el registro: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Hubo un problema al eliminar el certificado.']);
    }
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
