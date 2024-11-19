<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        // Si hay una búsqueda, obtener el DNI
        $alumnos = null;

        if ($request->has('dni')) {
            // Validar el DNI ingresado (asumiendo que tiene 8 dígitos)
            $request->validate([
                'dni' => 'nullable|numeric|max_digits:15',
                'correo' => 'nullable|email',
            ], [
                'dni.numeric' => 'El DNI solo puede contener números.',
                'dni.max_digits' => 'El DNI no puede tener más de 15 dígitos.',
                'correo.email' => 'El formato del correo no es válido.',
            ]);

            // Mostrar el valor del DNI recibido para depuración
            Log::info("DNI recibido: " . $request->dni);

            // Buscar todos los alumnos relacionados al DNI
            // Búsqueda por DNI
    if ($request->filled('dni')) {
        $alumnos = Alumno::with('curso.certificado')
            ->where('dni', $request->dni)
            ->whereHas('curso', function ($query) {
                $query->where('estado', 1); // Filtrar solo cursos con estado = 1
            })
            ->get();
    }

    // Búsqueda por correo
    if ($request->filled('correo')) {
        $alumnos = Alumno::with('curso.certificado')
            ->where('correo', $request->correo)
            ->whereHas('curso', function ($query) {
                $query->where('estado', 1); // Filtrar solo cursos con estado = 1
            })
            ->get();
    }

    // Validar si se encontraron resultados
    if ($request->has('dni') || $request->has('correo')) {
        if (!$alumnos || $alumnos->isEmpty()) {
            return redirect()->route('consulta.index')->with('error', 'No se encontraron resultados para la búsqueda realizada.');
        }
    }



            // Verificar si se encontraron cursos asociados al DNI
            if ($alumnos->isEmpty()) {
                Log::info("No se encontró ningún alumno con el DNI: " . $request->dni);
                return redirect()->route('consulta.index')->with('error', 'No se encontró ningún alumno con ese DNI.');
            }

            Log::info("Cursos encontrados para el DNI: " . $request->dni);

            // Si la acción es 'download' o 'view', generar el certificado para un curso específico
            if ($request->has('action') && $request->has('curso_id')) {
                $cursoId = $request->curso_id;

                // Buscar el curso específico asociado al alumno
                $alumno = $alumnos->firstWhere('curso.idcurso', $cursoId);

                if (!$alumno) {
                    return redirect()->route('consulta.index')->with('error', 'Curso no encontrado para este alumno.');
                }

                $certificado = $alumno->curso->certificado;
                $configuracion = $certificado->configuracion;

                if (!$configuracion) {
                    return redirect()->route('consulta.index')->with('error', 'No se encontró la configuración para el certificado.');
                }

                // Ruta del PDF base guardado en 'storage/app/public/certificados'
                $pdfPath = public_path('storage/certificados/' . $certificado->template);

                // Verificar si el archivo PDF existe
                if (!file_exists($pdfPath)) {
                    return redirect()->route('consulta.index')->with('error', 'No se encontró el certificado en el sistema.');
                }

                // Crear un nuevo documento PDF con FPDI
                $pdf = new Fpdi();
                $pdf->setSourceFile($pdfPath);
                $templateId = $pdf->importPage(1);

                // Obtener las dimensiones del PDF base en milímetros
                $size = $pdf->getTemplateSize($templateId);

                // Determinar la orientación según el ancho y la altura de la plantilla
                $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';

                // Añadir una página con tamaño A4 y orientación automática
                $pdf->AddPage($orientation, [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);

                // Configurar la fuente, tamaño y estilo según la configuración
                $pdf->SetFont($configuracion->fuente, '', $configuracion->tamaño_fuente);
                $pdf->SetTextColor(0, 0, 0);

                // Concatenar el nombre y apellido del alumno
                $nombreCompleto = utf8_decode($alumno->nombre . ' ' . $alumno->apellido);

                // Medir el ancho del texto generado en milímetros
                $textoAncho = $pdf->GetStringWidth($nombreCompleto);
                $textoAlto = $configuracion->tamaño_fuente;

                // Coordenadas configuradas (centro del elemento draggable)
                $posXCentro = $configuracion->pos_x;
                $posYCentro = $configuracion->pos_y;

                // Calcular la posición inicial del texto (esquina superior izquierda del texto)
                $posX = $posXCentro - ($textoAncho / 2.12); // Centrar texto horizontalmente a partir del ancho completo
                $posY = $posYCentro - ($textoAlto / 3); // Centrar texto verticalmente

                // Limitar las coordenadas dentro del rango permitido
                $posX = max(0, min($size['width'] - $textoAncho, $posX));
                $posY = max(0, min($size['height'] - $textoAlto, $posY));

                // Escribir el nombre completo del alumno centrado horizontal y verticalmente
                $pdf->SetXY($posX, $posY);
                $pdf->Cell($textoAncho, 35, $nombreCompleto, 0, 0, 'C');

                // Acciones específicas según 'view' o 'download'
                if ($request->action === 'view') {
                    return response($pdf->Output('I', 'certificado.pdf'))->header('Content-Type', 'application/pdf');
                } elseif ($request->action === 'download') {
                    return response($pdf->Output('D', 'certificado_' . $alumno->dni . '.pdf'))->header('Content-Type', 'application/pdf');
                }
            }
        }

        // Retornar la vista con los datos encontrados
        return view('consulta.index', compact('alumnos'));
    }
}
