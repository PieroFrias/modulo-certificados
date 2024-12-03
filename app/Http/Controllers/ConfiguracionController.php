<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    // Mostrar la lista de certificados con la opción de agregar o editar configuraciones
    public function show()
    {
        // Obtenemos todos los certificados con sus configuraciones
        $certificados = Certificado::with('configuracion')->get();

        // Retornar la vista con los datos de los certificados
        return view('configuracion.configuracioncertificado', compact('certificados'));
    }

    // Mostrar la configuración de un certificado para editar o agregar
    public function edit($idcertificado)
    {
        // Obtiene el certificado por su ID
        $certificado = Certificado::findOrFail($idcertificado);

        // Utilizamos la relación para obtener la configuración asociada al certificado
        $configuracion = $certificado->configuracion;

        // Si no existe una configuración, podríamos crear una nueva
        if (!$configuracion) {
            // Crear una nueva configuración si no existe
            $configuracion = new Configuracion([
                'idcertificado' => $idcertificado,
            ]);
        }

        // Aseguramos que la ruta del PDF es correcta
        $pdfUrl = asset('storage/certificados/' . $certificado->template);

        return view('configuracion.editarconfiguracion', compact('certificado', 'configuracion', 'pdfUrl'));
    }





    // Actualizar la configuración del certificado
    public function update(Request $request, $idcertificado)
    {
        //dd($request);
        // Validar los datos
        $request->validate([
            'pos_x' => 'required|numeric', // Ancho máximo de A4 en mm
            'pos_y' => 'required|numeric', // Alto máximo de A4 en mm
            'fuente' => 'required|string',
            'tamaño_fuente' => 'required|numeric|min:8|max:100',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        // Buscar o crear la configuración asociada al certificado
        $configuracion = Configuracion::updateOrCreate(
            ['idcertificado' => $idcertificado],
            [
                'idcertificado' => $idcertificado,
                'pos_x' => $request->input('pos_x'),
                'pos_y' => $request->input('pos_y'),
                'fuente' => $request->input('fuente'),
                'tamaño_fuente' => $request->input('tamaño_fuente'),
                'color' => $request->input('color'), // Guardar el color
            ]
        );

        // Redirigir a la lista de configuraciones con un mensaje de éxito
        return redirect()->route('certificados.index')->with('success', 'Configuración actualizada correctamente.');
    }

    public function index()
    {
        // Obtenemos todos los certificados con sus configuraciones
        $certificados = Certificado::with('configuracion')->get();

        // Retornar la vista con los datos de los certificados
        return view('configuracion.configuracioncertificado', compact('certificados'));
    }


}
