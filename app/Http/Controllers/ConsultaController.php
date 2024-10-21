<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Certificado;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;
use Fpdf\Fpdf;
use PDF;  // Para generar PDFs desde vistas de Blade

class ConsultaController extends Controller
{
    /**
     * Muestra el formulario de búsqueda por DNI y los resultados si existen.
     */
    // public function index(Request $request)
    // {
    //     // Si hay una búsqueda, obtener el DNI
    //     $alumno = null;

    //     if ($request->has('dni')) {
    //         // Validar el DNI ingresado (asumiendo que tiene 8 dígitos)
    //         $request->validate([
    //             'dni' => 'required|digits:8',
    //         ]);

    //         // Mostrar el valor del DNI recibido para depuración
    //         Log::info("DNI recibido: " . $request->dni);

    //         // Buscar al alumno por DNI
    //         $alumno = Alumno::with('curso.certificado')->where('dni', $request->dni)->first();

    //         // Verificar si se encontró el alumno
    //         if (!$alumno) {
    //             Log::info("No se encontró un alumno con el DNI: " . $request->dni);
    //             return redirect()->route('consulta.index')->with('error', 'No se encontró un alumno con ese DNI.');
    //         }

    //         Log::info("Alumno encontrado: " . $alumno->nombre);

    //         // Verificar si la acción es 'download' para generar el PDF
    //         if ($request->has('action') && $request->action == 'download') {
    //             // Ruta del PDF base guardado en 'storage/app/public/certificados'
    //             $certificado = $alumno->curso->certificado;
    //             $pdfPath = public_path('storage/certificados/' . $certificado->template);

    //             // Verificar si el archivo PDF existe
    //             if (!file_exists($pdfPath)) {
    //                 return redirect()->route('consulta.index')->with('error', 'No se encontró el certificado en el sistema.');
    //             }

    //             // Usar FPDI para cargar el PDF base
    //             $pdf = new Fpdi();

    //             // Añadir una página con orientación horizontal (landscape)
    //             $pdf->AddPage('L');  // 'L' para Landscape (horizontal)

    //             // Cargar el archivo PDF existente
    //             $pdf->setSourceFile($pdfPath);
    //             $template = $pdf->importPage(1);  // Importar la primera página del PDF base
    //             $pdf->useTemplate($template, 10, 10, 280);  // Ajustar la plantilla en la página (ancho ajustado para landscape)

    //             // Establecer la fuente y estilo
    //             $pdf->SetFont('Arial', 'B', 16);
    //             $pdf->SetTextColor(0, 0, 0);  // Color negro

    //             // Escribir el nombre del alumno en el centro del certificado
    //             $pdf->SetXY(50, 100);  // Coordenadas X, Y (puedes ajustar según sea necesario)
    //             $pdf->Cell(180, 10, utf8_decode($alumno->nombre . ' ' . $alumno->apellido), 0, 1, 'C');

    //             // Descargar el PDF modificado con el nombre del alumno
    //             return response($pdf->Output('D', 'certificado.pdf'))->header('Content-Type', 'application/pdf');

    //         // Verificar si la acción es 'view' para mostrar en la vista
    //         } elseif ($request->has('action') && $request->action == 'view') {
    //             $certificado = $alumno->curso->certificado;
    //             return view('consulta.template', compact('alumno', 'certificado'));
    //         }
    //     }

    //     // Retornar la vista con el alumno o null si no hay búsqueda
    //     return view('consulta.index', compact('alumno'));
    // }
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

            // Si la acción es 'download', generar el PDF y forzar la descarga
            if ($request->has('action') && $request->action == 'download') {
                $certificado = $alumno->curso->certificado;
                $pdfPath = public_path('storage/certificados/' . $certificado->template);

                // Verificar si el archivo PDF existe
                if (!file_exists($pdfPath)) {
                    return redirect()->route('consulta.index')->with('error', 'No se encontró el certificado en el sistema.');
                }

                // Usar FPDI para cargar el PDF base y escribir el nombre del alumno
                $pdf = new Fpdi();

                // Añadir una página con orientación horizontal (landscape)
                $pdf->AddPage('L');  // 'L' para Landscape (horizontal)

                // Cargar el archivo PDF existente
                $pdf->setSourceFile($pdfPath);
                $template = $pdf->importPage(1);  // Importar la primera página del PDF base
                $pdf->useTemplate($template, 10, 10, 280);  // Ajustar la plantilla en la página (ancho ajustado para landscape)

                // Establecer la fuente y estilo
                $pdf->SetFont('Arial', 'B', 24);
                $pdf->SetTextColor(0, 0, 0);  // Color negro

                // Calcular la posición centrada en la página (horizontal y vertical)
                $pageWidth = 297; // Ancho de la página en mm
                $pageHeight = 210; // Alto de la página en mm
                $nameWidth = 180;  // Aproximadamente el espacio que ocupará el nombre (ajustable)
                $nameHeight = 10;  // Altura del texto

                // Coordenadas ajustadas para centrar el nombre
                $x = ($pageWidth - $nameWidth) / 2;
                $y = ($pageHeight / 2.1) + $nameHeight;

                // Escribir el nombre del alumno centrado
                $pdf->SetXY($x, $y);  // Coordenadas X, Y ajustadas para que se vea correctamente
                $pdf->Cell($nameWidth, $nameHeight, utf8_decode($alumno->nombre . ' ' . $alumno->apellido), 0, 1, 'C');

                // Descargar el PDF modificado con el nombre del alumno
                return response($pdf->Output('D', 'certificado_' . $alumno->dni . '.pdf'))->header('Content-Type', 'application/pdf');
            }

            // Si la acción es 'view', entonces genera el PDF con el nombre superpuesto y lo muestra
            if ($request->has('action') && $request->action == 'view') {
                $certificado = $alumno->curso->certificado;
                $pdfPath = public_path('storage/certificados/' . $certificado->template);

                // Verificar si el archivo PDF existe
                if (!file_exists($pdfPath)) {
                    return redirect()->route('consulta.index')->with('error', 'No se encontró el certificado en el sistema.');
                }

                // Usar FPDI para cargar el PDF base y escribir el nombre del alumno
                $pdf = new Fpdi();

                // Añadir una página con orientación horizontal (landscape)
                $pdf->AddPage('L');  // 'L' para Landscape (horizontal)

                // Cargar el archivo PDF existente
                $pdf->setSourceFile($pdfPath);
                $template = $pdf->importPage(1);  // Importar la primera página del PDF base
                $pdf->useTemplate($template, 10, 10, 280);  // Ajustar la plantilla en la página (ancho ajustado para landscape)

                // Establecer la fuente y estilo
                $pdf->SetFont('Arial', 'B', 24);
                $pdf->SetTextColor(0, 0, 0);  // Color negro

                // Calcular la posición centrada en la página (horizontal y vertical)
                $pageWidth = 297; // Ancho de la página en mm
                $pageHeight = 210; // Alto de la página en mm
                $nameWidth = 180;  // Aproximadamente el espacio que ocupará el nombre (ajustable)
                $nameHeight = 10;  // Altura del texto

                // Coordenadas ajustadas para centrar el nombre
                $x = ($pageWidth - $nameWidth) / 2;
                $y = ($pageHeight / 2.1) + $nameHeight;

                // Escribir el nombre del alumno centrado
                $pdf->SetXY($x, $y);  // Coordenadas X, Y ajustadas para que se vea correctamente
                $pdf->Cell($nameWidth, $nameHeight, utf8_decode($alumno->nombre . ' ' . $alumno->apellido), 0, 1, 'C');

                // Guardar el nuevo PDF con el nombre
                $newPdfPath = public_path('storage/certificados/certificado_' . $alumno->dni . '.pdf');
                $pdf->Output($newPdfPath, 'F');  // Guarda el archivo en el sistema de archivos

                // Pasar el nuevo PDF a la vista
                $pdfPath = asset('storage/certificados/certificado_' . $alumno->dni . '.pdf');
                return view('consulta.template', compact('alumno', 'certificado', 'pdfPath'));
            }
        }

        // Retornar la vista con el alumno o null si no hay búsqueda
        return view('consulta.index', compact('alumno'));
    }


}
