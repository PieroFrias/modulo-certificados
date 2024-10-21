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
        $alumno = null;

        if ($request->has('dni')) {
            // Validar el DNI ingresado (asumiendo que tiene 8 dígitos)
            $request->validate([
                'dni' => 'required|digits:8',
            ]);

            // Mostrar el valor del DNI recibido para depuración
            Log::info("DNI recibido: " . $request->dni);

            // Buscar al alumno por DNI
            $alumno = Alumno::with('curso.certificado')->where('dni', $request->dni)->first();

            // Verificar si se encontró el alumno
            if (!$alumno) {
                Log::info("No se encontró un alumno con el DNI: " . $request->dni);
                return redirect()->route('consulta.index')->with('error', 'No se encontró un alumno con ese DNI.');
            }

            Log::info("Alumno encontrado: " . $alumno->nombre);

            // Obtener la configuración asociada al certificado del curso del alumno
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

            // Pasar la URL del PDF a la vista para la opción de "ver"
            $pdfUrl = asset('storage/certificados/' . $certificado->template);

            // Escala utilizada en la vista del canvas
            $scale = 1;

            // Si la acción es 'view', generar la vista limpia del certificado

            if ($request->has('action') && $request->action == 'view') {
                // Usar FPDI para cargar el PDF base y escribir el nombre del alumno
                $pdf = new Fpdi();

                // Cargar el archivo PDF existente y definir la página
                $pdf->setSourceFile($pdfPath);
                $templateId = $pdf->importPage(1);

                // Obtener las dimensiones del PDF base en milímetros
                $size = $pdf->getTemplateSize($templateId);

                // Determinar la orientación según el ancho y la altura de la plantilla
                $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';

                // Añadir una página con tamaño A4 y orientación automática
                $pdf->AddPage($orientation, [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);

                // Ajustar la posición del nombre del alumno según la configuración
                $posX = $configuracion->pos_x;
                $posY = $configuracion->pos_y;

                // Limitar las coordenadas dentro del rango permitido
                $posX = max(0, min($size['width'], $posX));
                $posY = max(0, min($size['height'], $posY));

                // Establecer la fuente, tamaño y estilo según la configuración
                $pdf->SetFont($configuracion->fuente, '', $configuracion->tamaño_fuente);
                $pdf->SetTextColor(0, 0, 0);

                // Escribir el nombre del alumno en la posición configurada
                $pdf->SetXY($posX, $posY);
                $pdf->Cell(0, 10, utf8_decode($alumno->nombre . ' ' . $alumno->apellido), 0, 1, 'L');

                // Salida en memoria para ser visualizado directamente en la vista
                $pdfContent = $pdf->Output('S');

                // Codificar el contenido en base64 para pasarlo a la vista
                $pdfBase64 = base64_encode($pdfContent);

                // Pasar la base64 del PDF a la vista
                return view('consulta.template', ['pdfBase64' => $pdfBase64]);
            }




            if ($request->has('action') && $request->action == 'download') {
                // Usar FPDI para cargar el PDF base y escribir el nombre del alumno
                $pdf = new Fpdi();

                // Cargar el archivo PDF existente y definir la página
                $pdf->setSourceFile($pdfPath);
                $templateId = $pdf->importPage(1);

                // Obtener las dimensiones del PDF base en milímetros
                $size = $pdf->getTemplateSize($templateId);

                // Determinar la orientación según el ancho y la altura de la plantilla
                $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';

                // Definir dimensiones del PDF a tamaño A4 en milímetros
                $A4_WIDTH_MM = $size['width'] ;
                $A4_HEIGHT_MM = $size['height'];

                // Añadir una página con tamaño A4 y orientación automática
                if ($orientation == 'L') {
                    $pdf->AddPage('L', [$A4_HEIGHT_MM, $A4_WIDTH_MM]); // Página horizontal
                } else {
                    $pdf->AddPage('P', [$A4_WIDTH_MM, $A4_HEIGHT_MM]); // Página vertical
                }

                // Escalar el contenido de la plantilla para ajustarse al tamaño A4 manteniendo la proporción
                $scaleX = $A4_WIDTH_MM / $size['width'];
                $scaleY = $A4_HEIGHT_MM / $size['height'];
                $scale = min($scaleX, $scaleY); // Mantener la proporción correcta (usar el menor)

                // Usar la plantilla escalada y centrada en la página A4
                $pdf->useTemplate($templateId, 0, 0, $size['width'] * $scale, $size['height'] * $scale);

                // Mostrar las dimensiones del PDF en la esquina superior derecha
                $pdf->SetFont('Arial', '', 10); // Fuente Arial, tamaño 10
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY($A4_WIDTH_MM - 65, 15); // Posición superior derecha
                $pdf->Cell(0, 10, utf8_decode('Tamaño del PDF: ' . $A4_WIDTH_MM . ' mm de ancho por ' . $A4_HEIGHT_MM . ' mm de alto'), 0, 0, 'R');

                // Usar las coordenadas en milímetros de la tabla de configuraciones con respecto a la esquina superior izquierda del PDF
                $posX = $configuracion->pos_x; // Posición X en milímetros desde la esquina superior izquierda
                $posY = $configuracion->pos_y; // Posición Y en milímetros desde la esquina superior izquierda

                // Limitar las coordenadas dentro del rango permitido
                $posX = max(0, min($A4_WIDTH_MM, $posX));
                $posY = max(0, min($A4_HEIGHT_MM, $posY));

                // Ajustar la posición del nombre según la orientación y el centrado
                // Tener en cuenta la escala aplicada al contenido de la plantilla
                $adjustedPosX = $posX * $scale;
                $adjustedPosY = $posY * $scale;

                // Establecer la fuente, tamaño y estilo según la configuración
                $pdf->SetFont($configuracion->fuente, '', $configuracion->tamaño_fuente);
                $pdf->SetTextColor(0, 0, 0);

                // Escribir el nombre del alumno en la posición configurada
                $pdf->SetXY($adjustedPosX, $adjustedPosY);
                $pdf->Cell(0, 10, utf8_decode($alumno->nombre . ' ' . $alumno->apellido), 0, 1, 'L');

                // Mostrar las coordenadas del nombre en la parte superior derecha, debajo del tamaño del PDF
                $pdf->SetFont('Arial', '', 10); // Fuente Arial, tamaño 10 (igual que arriba)
                $pdf->SetXY($A4_WIDTH_MM - 65, 25);
                $pdf->Cell(0, 10, utf8_decode('Posición del nombre: X = ' . round($posX, 2) . ' mm, Y = ' . round($posY, 2) . ' mm'), 0, 0, 'R');

                // Descargar el PDF modificado con el nombre del alumno
                return response($pdf->Output('D', 'certificado_' . $alumno->dni . '.pdf'))->header('Content-Type', 'application/pdf');
            }
























            // Retornar la vista con la información del alumno y las opciones para ver o descargar el certificado
            return view('consulta.index', compact('alumno', 'certificado', 'pdfUrl', 'configuracion'));
        }

        // Retornar la vista sin datos si no hay búsqueda
        return view('consulta.index', compact('alumno'));
    }
}
