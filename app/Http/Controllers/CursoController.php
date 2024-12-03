<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Certificado;
use ZipArchive;
use Illuminate\Support\Collection;
use App\Models\Alumno;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;

class CursoController extends Controller
{
    // Método para mostrar la lista de cursos
    public function index()
    {
        // Cargar los cursos con el certificado relacionado y contar los alumnos por curso
        $cursos = Curso::with('certificado')
            ->withCount('alumnos') // Contar los alumnos relacionados con cada curso
            ->orderBy('created_at', 'desc') // Ordenar por los más recientes
            ->get();

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

        try {
            // Eliminar alumnos relacionados únicamente con este curso
            $curso->alumnos()->delete();

            // Eliminar el curso
            $curso->delete();

            return redirect()->route('curso.index')->with('success', 'Curso y sus alumnos eliminados correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al eliminar el curso: ' . $e->getMessage()]);
        }
    }


    public function alumnos(Request $request, $idcurso)
    {
        $curso = Curso::findOrFail($idcurso);

        // Realizar búsqueda si se proporciona un término
        $query = $curso->alumnos();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                    ->orWhere('apellido', 'like', "%$search%")
                    ->orWhere('correo', 'like', "%$search%")
                    ->orWhere('dni', 'like', "%$search%");
            });
        }

        // Paginación de 20 en 20
        $alumnos = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->query());
        // Contar activos e inactivos
        $activos = $curso->alumnos()->where('estado', 1)->count();
        $inactivos = $curso->alumnos()->where('estado', 0)->count();

        return view('curso.alumnos', compact('curso', 'alumnos', 'activos', 'inactivos'));
        }


    public function generarCertificadosMasivos($idcurso)
    {
        $curso = Curso::with(['alumnos' => function ($query) {
            $query->where('estado', 1); // Filtrar solo alumnos con estado activo
        }, 'certificado.configuracion'])->findOrFail($idcurso);


        if ($curso->alumnos->isEmpty()) {
            return redirect()->route('curso.alumnos', $idcurso)->with('error', 'No hay alumnos registrados en este curso.');
        }

        $zip = new ZipArchive();
        $zipFileName = 'certificados ' . $curso->nombre . '.zip';
        $zipPath = storage_path($zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($curso->alumnos as $alumno) {
                // Verificar si el alumno ya tiene un código
                if (!$alumno->codigo) {
                    // Generar código único de 12 caracteres si no existe
                    $codigo = $this->generarCodigoUnico();
                    $alumno->codigo = $codigo;
                    $alumno->save();
                } else {
                    // Usar el código existente
                    $codigo = $alumno->codigo;
                }

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


                // Convertir color hexadecimal a RGB y aplicarlo
                $rgbColor = $this->hexToRgb($configuracion->color);
                $pdf->SetTextColor($rgbColor['r'], $rgbColor['g'], $rgbColor['b']);


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

                // Guardar el PDF temporalmente con el código como nombre de archivo
                $tempPdfPath = storage_path("certificado_{$codigo}.pdf");
                $pdf->Output($tempPdfPath, 'F');

                // Agregar el PDF al ZIP
                $zip->addFile($tempPdfPath, "[{$codigo}].pdf");
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
        $curso = Curso::with('certificado.configuracion')->findOrFail($idcurso);
        $alumno = Alumno::findOrFail($idalumno);

         // Verificar si el alumno está activo
        if (!$alumno->estado) { // Suponiendo que 1 es activo y 0 es inactivo
            return redirect()->route('curso.alumnos', $idcurso)->with('error', 'El alumno no está activo, no se puede generar el certificado.');
        }

        // Verificar si el certificado y su configuración existen
        $certificado = $curso->certificado;
        $configuracion = $certificado->configuracion;

        if (!$certificado || !$configuracion) {
            return redirect()->route('curso.alumnos', $idcurso)->with('error', 'No se encontró configuración para el certificado.');
        }

        // Verificar si el alumno ya tiene un código
        if (!$alumno->codigo) {
            // Generar código único de 12 caracteres si no existe
            $codigo = $this->generarCodigoUnico();
            $alumno->codigo = $codigo;
            $alumno->save();
        } else {
            // Usar el código existente
            $codigo = $alumno->codigo;
        }

        // Ruta del PDF base
        $pdfPath = public_path('storage/certificados/' . $certificado->template);
        if (!file_exists($pdfPath)) {
            return redirect()->route('curso.alumnos', $idcurso)->with('error', 'La plantilla del certificado no existe.');
        }

        // Crear el PDF con FPDI
        $pdf = new Fpdi();
        $pdf->setSourceFile($pdfPath);
        $templateId = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($templateId);
        $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
        $pdf->AddPage($orientation, [$size['width'], $size['height']]);
        $pdf->useTemplate($templateId);

        // Configuración del texto (fuente, color, tamaño)
        $pdf->SetFont($configuracion->fuente, '', $configuracion->tamaño_fuente);


        // Convertir color hexadecimal a RGB y aplicarlo
        $rgbColor = $this->hexToRgb($configuracion->color);
        $pdf->SetTextColor($rgbColor['r'], $rgbColor['g'], $rgbColor['b']);

        // Nombre completo del alumno
        $nombreCompleto = utf8_decode($alumno->nombre . ' ' . $alumno->apellido);
        $textoAncho = $pdf->GetStringWidth($nombreCompleto);
        $textoAlto = $configuracion->tamaño_fuente;

        // Calcular las posiciones del texto centrado
        $posXCentro = $configuracion->pos_x;
        $posYCentro = $configuracion->pos_y;
        $posX = max(0, min($size['width'] - $textoAncho, $posXCentro - ($textoAncho / 2.12)));
        $posY = max(0, min($size['height'] - $textoAlto, $posYCentro - ($textoAlto / 3)));

        // Escribir el nombre en el certificado
        $pdf->SetXY($posX, $posY);
        $pdf->Cell($textoAncho, 35, $nombreCompleto, 0, 0, 'C');

        // Generar el nombre del archivo para la descarga basado en el código
        $fileName = "[{$codigo}].pdf";

        // Guardar el archivo en un buffer temporal
        $tempFilePath = storage_path($fileName);
        $pdf->Output($tempFilePath, 'F');

        // Forzar la descarga del archivo
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

private function generarCodigoUnico()
{
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle($caracteres), 0, 12);
}

private function hexToRgb($hexColor)
{
    $hexColor = ltrim($hexColor, '#');
    if (strlen($hexColor) === 3) {
        $hexColor = $hexColor[0] . $hexColor[0] . $hexColor[1] . $hexColor[1] . $hexColor[2] . $hexColor[2];
    }
    return [
        'r' => hexdec(substr($hexColor, 0, 2)),
        'g' => hexdec(substr($hexColor, 2, 2)),
        'b' => hexdec(substr($hexColor, 4, 2)),
    ];
}


public function enviarCertificado(Request $request, $idcurso)
{
    // Cargar el curso con los alumnos relacionados
    $curso = Curso::findOrFail($idcurso);

    $certificadosPath = storage_path('app/public/certificados_firmados');

    // Validar que el directorio exista
    if (!is_dir($certificadosPath)) {
        return redirect()->back()->with('error', 'No se encontraron certificados firmados en la ruta especificada.');
    }

    $files = scandir($certificadosPath);

    // Crear un array con los códigos de los certificados disponibles
    $certificadosFirmados = [];
    foreach ($files as $file) {
        if (preg_match('/^(\w{12})\.pdf$/', $file, $matches)) {
            $certificadosFirmados[] = $matches[1]; // Extraer el código
        }
    }

    // Obtener todos los alumnos del curso con certificados válidos
    $baseQuery = $curso->alumnos()
        ->whereIn('codigo', $certificadosFirmados)
        ->whereNotNull('codigo'); // Asegurarse de que el código no sea nulo

    // Calcular el total de certificados importados
    $contadorCertificados = $baseQuery->count();

    // Aplicar búsqueda si se proporciona un término
    $query = clone $baseQuery; // Clonar la consulta base para no afectar el contador
    if ($request->filled('search')) {
        $search = strtolower($request->input('search'));
        $query->where(function ($q) use ($search) {
            $q->where('nombre', 'like', "%$search%")
                ->orWhere('apellido', 'like', "%$search%")
                ->orWhere('dni', 'like', "%$search%")
                ->orWhere('correo', 'like', "%$search%")
                ->orWhere('codigo', 'like', "%$search%");
        });
    }

    // Paginación: se cargan solo 20 registros por página
    $alumnosFirmados = $query->paginate(20);

    return view('curso.enviarcertificado', [
        'idcurso' => $idcurso,
        'curso' => $curso,
        'alumnosFirmados' => $alumnosFirmados,
        'contadorCertificados' => $contadorCertificados, // Pasar el contador a la vista
    ]);
}


public function importarAlumnos(Request $request, $idcurso)
{
    $request->validate([
        'certificados' => 'required|file|mimes:zip,rar,7z,tar,gz,pdf', // Aceptar archivos comprimidos o PDF
    ]);

    $file = $request->file('certificados');
    $destinationPath = storage_path('app/public/certificados_firmados/');

    // Crear directorio si no existe
    if (!is_dir($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    $processedFiles = 0;
    $errors = [];
    $totalFiles = 0;

    if ($file->getClientOriginalExtension() === 'pdf') {
        // Caso 1: Subida de un único archivo PDF
        $totalFiles = 1;
        $fileName = $file->getClientOriginalName();

        if (preg_match('/\[(\w{12})\]\.pdf$/', $fileName, $matches)) {
            $codigo = $matches[1];

            // Buscar al alumno con el código
            $alumno = Alumno::where('codigo', $codigo)->first();

            if ($alumno) {
                $targetPath = $destinationPath . $codigo . '.pdf';

                // Guardar el archivo si no existe
                if (!file_exists($targetPath)) {
                    $file->move($destinationPath, $codigo . '.pdf');
                }
                $processedFiles++;
            } else {
                $errors[] = "El archivo {$fileName} no coincide con ningún alumno.";
            }
        } else {
            $errors[] = "El archivo {$fileName} no cumple con el formato [código].pdf.";
        }
    } else {
        // Caso 2: Subida de un archivo comprimido con múltiples PDFs
        $zip = new \ZipArchive();

        if ($zip->open($file->path()) === TRUE) {
            $totalFiles = $zip->numFiles;

            for ($i = 0; $i < $totalFiles; $i++) {
                $fileInfo = $zip->statIndex($i);
                $fileName = $fileInfo['name'];

                // Omitir directorios
                if (str_ends_with($fileName, '/')) {
                    continue;
                }

                // Verificar si el archivo cumple con el formato [código].pdf
                if (preg_match('/\[(\w{12})\]\.pdf$/', $fileName, $matches)) {
                    $codigo = $matches[1];

                    // Buscar al alumno con el código
                    $alumno = Alumno::where('codigo', $codigo)->first();

                    if ($alumno) {
                        $targetPath = $destinationPath . $codigo . '.pdf';

                        // Extraer y mover el archivo si no existe
                        if (!file_exists($targetPath)) {
                            $zip->extractTo($destinationPath, [$fileName]);
                            rename($destinationPath . $fileName, $targetPath);
                        }
                        $processedFiles++;
                    } else {
                        $errors[] = "El archivo {$fileName} no coincide con ningún alumno.";
                    }
                } else {
                    $errors[] = "El archivo {$fileName} no cumple con el formato [código].pdf.";
                }
            }

            $zip->close();
        } else {
            return response()->json(['error' => 'No se pudo descomprimir el archivo.']);
        }
    }

    return response()->json([
        'success' => true,
        'totalFiles' => $totalFiles,
        'processedFiles' => $processedFiles,
        'errors' => $errors,
    ]);
}



}
