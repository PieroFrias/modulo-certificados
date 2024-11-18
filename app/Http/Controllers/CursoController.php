<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Certificado;
use ZipArchive;

use App\Models\Alumno;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;

class CursoController extends Controller
{
    // Método para mostrar la lista de cursos
    public function index()
{
    // Cargar los cursos con el certificado relacionado
    $cursos = Curso::with('certificado')->get();
    return view('curso.index', compact('cursos'));
}


    // Método para mostrar el formulario de creación de un curso
    public function create()
{
    // Obtener la lista de certificados para mostrar en el formulario
    $certificados = Certificado::all();

    return view('curso.create', compact('certificados'));
}

  // Método para almacenar un nuevo curso
public function store(Request $request)
{
    // Validar los datos de entrada, incluyendo idcertificado
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'estado' => 'required|boolean',
        'idcertificado' => 'required|exists:certificados,id', // Validar que el idcertificado exista en la tabla 'certificados'
        'hora' => 'required|integer|min:0', // Validación para hora (de 0 a 23)
    ]);

    // Crear un nuevo registro en la base de datos
    Curso::create([
        'nombre' => $validated['nombre'],
        'estado' => $validated['estado'],
        'idcertificado' => $validated['idcertificado'], // Almacenar la relación con el certificado
        'hora' => $validated['hora'], // Guardar la hora
    ]);

    // Redirigir a la lista de cursos con un mensaje de éxito
    return redirect()->route('curso.index')->with('success', 'Curso creado correctamente.');
}

    // Método para mostrar un curso específico (opcional)
    public function show($id)
    {
        $curso = Curso::findOrFail($id);
        return view('curso.show', compact('curso'));
    }

       // Método para mostrar el formulario de edición de un curso
       public function edit($id)
       {
           $curso = Curso::findOrFail($id);
           $certificados = Certificado::all(); // Para cargar los certificados en la vista
           return view('curso.edit', compact('curso', 'certificados'));
       }

       // Método para actualizar un curso existente
       public function update(Request $request, $id)
       {
           $validated = $request->validate([
               'nombre' => 'required|string|max:255',
               'estado' => 'required|boolean',
               'idcertificado' => 'required|exists:certificados,id',
               'hora' => 'required|integer|min:0', // Validación para hora
           ]);

           $curso = Curso::findOrFail($id);
           $curso->update([
               'nombre' => $validated['nombre'],
               'estado' => $validated['estado'],
               'idcertificado' => $validated['idcertificado'],
               'hora' => $validated['hora'], // Actualizar la hora
           ]);

           return redirect()->route('curso.index')->with('success', 'Curso actualizado correctamente.');
       }
    // Método para eliminar un curso
    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        // Redirigir a la lista de cursos con un mensaje de éxito
        return redirect()->route('curso.index')->with('success', 'Curso eliminado correctamente.');
    }

    public function alumnos($idcurso)
{
    $curso = Curso::with('alumnos')->findOrFail($idcurso); // Obtener el curso con sus alumnos
    return view('curso.alumnos', compact('curso'));
}

public function generarCertificadosMasivos($idcurso)
{
    $curso = Curso::with('alumnos.curso.certificado.configuracion')->findOrFail($idcurso);

    if ($curso->alumnos->isEmpty()) {
        return redirect()->route('curso.alumnos', $idcurso)->with('error', 'No hay alumnos registrados en este curso.');
    }

    $zip = new ZipArchive();
    $zipFileName = 'certificados_curso_' . $curso->idcurso . '.zip';
    $zipPath = storage_path($zipFileName);

    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        foreach ($curso->alumnos as $alumno) {
            // Obtener el certificado y configuración
            $certificado = $curso->certificado;
            $configuracion = $certificado->configuracion;

            if (!$configuracion) {
                continue;
            }

            // Ruta del PDF base
            $pdfPath = public_path('storage/certificados/' . $certificado->template);
            if (!file_exists($pdfPath)) {
                continue;
            }

            // Crear el PDF con FPDI
            $pdf = new Fpdi();
            $pdf->setSourceFile($pdfPath);
            $templateId = $pdf->importPage(1);
            $size = $pdf->getTemplateSize($templateId);
            $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
            $pdf->AddPage($orientation, [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            $pdf->SetFont($configuracion->fuente, '', $configuracion->tamaño_fuente);
            $pdf->SetTextColor(0, 0, 0);
            $nombreCompleto = utf8_decode($alumno->nombre . ' ' . $alumno->apellido);
            $textoAncho = $pdf->GetStringWidth($nombreCompleto);
            $textoAlto = $configuracion->tamaño_fuente;

            // Coordenadas configuradas (centro del elemento draggable)
            $posXCentro = $configuracion->pos_x;
            $posYCentro = $configuracion->pos_y;

            // Calcular la posición inicial del texto (esquina superior izquierda del texto)
            $posX = max(0, min($size['width'] - $textoAncho, $posXCentro - ($textoAncho / 2.12)));
            $posY = max(0, min($size['height'] - $textoAlto, $posYCentro - ($textoAlto / 3)));

            // Escribir el nombre completo del alumno centrado horizontal y verticalmente
            $pdf->SetXY($posX, $posY);
            $pdf->Cell($textoAncho, 35, $nombreCompleto, 0, 0, 'C');

            // Guardar el PDF temporalmente
            $tempPdfPath = storage_path('certificado_' . $alumno->nombre . '_' . $alumno->apellido . '.pdf');
            $pdf->Output($tempPdfPath, 'F');

            // Agregar el PDF al ZIP
            $zip->addFile($tempPdfPath, $alumno->nombre . '_' . $alumno->apellido . '.pdf');
        }

        $zip->close();

        // Eliminar los archivos temporales
        array_map('unlink', glob(storage_path('certificado_*.pdf')));

        // Descargar el ZIP
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    return redirect()->route('curso.alumnos', $idcurso)->with('error', 'No se pudo crear el archivo ZIP.');
}

public function generarCertificado($idcurso, $idalumno)
{
    $alumno = Alumno::findOrFail($idalumno);

    // Lógica para generar un certificado individual
    return redirect()->route('curso.alumnos', $idcurso)->with('success', 'Certificado generado para ' . $alumno->nombre . ' ' . $alumno->apellido);
}


}
