<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\EnvioCertificado;
use App\Models\Alumno;
use App\Models\Certificado;
use App\Models\Curso;



class EnvioCertificadoController extends Controller
{

// Enviar correo individual
public function enviarCorreoIndividual($idcurso, $idalumno)
{
    $alumno = Alumno::where('id', $idalumno)->where('idcurso', $idcurso)->first();

    if (!$alumno || !$alumno->correo) {
        return redirect()->back()->with('error', 'El alumno no tiene un correo asignado o no pertenece a este curso.');
    }

    $certificadoPath = storage_path("app/public/certificados_firmados/{$alumno->codigo}.pdf");

    if (!file_exists($certificadoPath)) {
        return redirect()->back()->with('error', 'No se encontró el certificado del alumno.');
    }

    try {
        // Enviar el correo
        Mail::to($alumno->correo)->send(new EnvioCertificado($alumno, $certificadoPath));

        // Actualizar columnas enviado y vecesenviado
        $alumno->update([
            'enviado' => 1,
            'vecesenviado' => $alumno->vecesenviado + 1,
        ]);

        return redirect()->back()->with('success', "Correo enviado correctamente al alumno {$alumno->nombre}.");
    } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
        // Si el error está relacionado con el límite diario
        if (strpos($e->getMessage(), 'Daily user sending limit exceeded') !== false) {
            return redirect()->back()->with('error', 'Límite diario de envío de correos alcanzado. Intenta nuevamente mañana.');
        }

        // Manejar otros errores de transporte
        return redirect()->back()->with('error', "Error al enviar el correo: {$e->getMessage()}");
    } catch (\Exception $e) {
        // Manejar cualquier otro error genérico
        return redirect()->back()->with('error', "Ocurrió un error inesperado: {$e->getMessage()}");
    }
}


    public function enviarCorreosMasivos($idcurso)
    {
        set_time_limit(0);
        // Obtener los alumnos del curso con correos válidos
        $alumnos = Alumno::where('idcurso', $idcurso)
            ->whereNotNull('correo')
            ->get();

        // Contar los certificados pendientes de envío
        $cantidadFaltantes = $alumnos->filter(function ($alumno) {
            $certificadoPath = storage_path("app/public/certificados_firmados/{$alumno->codigo}.pdf");
            return file_exists($certificadoPath) && $alumno->enviado == 0;
        })->count();

        // Si hay más de 200 certificados pendientes, regresar con error
        if ($cantidadFaltantes > 200) {
            return redirect()->route('curso.enviarCertificado', ['idcurso' => $idcurso, 'cantidadFaltantes' => $cantidadFaltantes])
                ->with('error', 'No se pueden enviar más de 200 certificados a la vez.');
        }

        // Proceso de envío (mismo que ya tienes)
        $errores = [];
        $enviados = 0;

        foreach ($alumnos as $alumno) {
            // Si ya se han enviado más de 200 certificados, detener el proceso
            if ($enviados >= 200) {
                break;
            }

            $certificadoPath = storage_path("app/public/certificados_firmados/{$alumno->codigo}.pdf");

            // Validar correo y existencia del archivo
            if (filter_var($alumno->correo, FILTER_VALIDATE_EMAIL) && file_exists($certificadoPath)) {
                try {
                    Mail::to($alumno->correo)->send(new EnvioCertificado($alumno, $certificadoPath));

                    // Actualizar columnas enviado y vecesenviado
                    $alumno->update([
                        'enviado' => 1,
                        'vecesenviado' => $alumno->vecesenviado + 1,
                    ]);

                    $enviados++; // Incrementar el contador de enviados
                } catch (\Exception $e) {
                    $errores[] = "Error al enviar a {$alumno->nombre}: {$e->getMessage()}";
                }
            } else {
                $errores[] = "Correo inválido o certificado no encontrado para {$alumno->nombre}.";
            }
        }

        // Redirigir a la vista con el resultado
        return redirect()->route('curso.enviarCertificado', ['idcurso' => $idcurso, 'cantidadFaltantes' => $cantidadFaltantes])
            ->with('success', "Se enviaron {$enviados} certificados correctamente.");
    }


    public function reenviarFaltantes($idcurso)
    {
        set_time_limit(0);
        $alumnosNoEnviados = Alumno::where('idcurso', $idcurso)
            ->where('enviado', 0)
            ->whereNotNull('correo')
            ->get();

        if ($alumnosNoEnviados->isEmpty()) {
            return redirect()->back()->with('error', 'No hay certificados pendientes por enviar.');
        }

        $errores = [];
        foreach ($alumnosNoEnviados as $alumno) {
            $certificadoPath = storage_path("app/public/certificados_firmados/{$alumno->codigo}.pdf");

            if (filter_var($alumno->correo, FILTER_VALIDATE_EMAIL) && file_exists($certificadoPath)) {
                try {
                    // Enviar correo
                    Mail::to($alumno->correo)->send(new EnvioCertificado($alumno, $certificadoPath));

                    // Actualizar columnas enviado y vecesenviado
                    $alumno->update([
                        'enviado' => 1,
                        'vecesenviado' => $alumno->vecesenviado + 1,
                    ]);
                } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
                    if (strpos($e->getMessage(), 'Daily user sending limit exceeded') !== false) {
                        return redirect()->back()->with('error', 'Límite diario de envío de correos alcanzado. Intenta nuevamente mañana.');
                    }
                    $errores[] = "Error al enviar a {$alumno->nombre}: {$e->getMessage()}";
                } catch (\Exception $e) {
                    $errores[] = "Error al enviar a {$alumno->nombre}: {$e->getMessage()}";
                }
            } else {
                $errores[] = "Correo inválido o certificado no encontrado para {$alumno->nombre}.";
            }
        }

        if (!empty($errores)) {
            return redirect()->back()->with('error', implode('<br>', $errores));
        }

        return redirect()->back()->with('success', 'Todos los certificados faltantes se enviaron correctamente.');
    }


public function reenviarFaltantesConfigurados(Request $request, $idcurso)
{
    set_time_limit(0);
    $request->validate([
        'cantidad' => 'required|integer|min:1',
    ]);

    $cantidad = $request->input('cantidad');

    // Obtener alumnos del curso con estado enviado = 0
    $alumnosNoEnviados = Alumno::where('idcurso', $idcurso)
        ->where('enviado', 0)
        ->whereNotNull('correo') // Solo alumnos con correo
        ->take($cantidad)
        ->get();

    if ($alumnosNoEnviados->isEmpty()) {
        return redirect()->back()->with('error', 'No hay certificados pendientes por enviar.');
    }

    $errores = [];
    $enviados = 0;

    foreach ($alumnosNoEnviados as $alumno) {
        $certificadoPath = storage_path("app/public/certificados_firmados/{$alumno->codigo}.pdf");

        if (file_exists($certificadoPath)) {
            try {
                // Enviar correo
                Mail::to($alumno->correo)->send(new EnvioCertificado($alumno, $certificadoPath));

                // Actualizar columnas enviado y vecesenviado
                $alumno->update([
                    'enviado' => 1,
                    'vecesenviado' => $alumno->vecesenviado + 1,
                ]);

                $enviados++;
            } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
                // Si el error está relacionado con el límite diario
                if (strpos($e->getMessage(), 'Daily user sending limit exceeded') !== false) {
                    $errores[] = "Límite diario de envío alcanzado. Se enviaron {$enviados} correos.";
                    break; // Detener el proceso si se alcanza el límite diario
                } else {
                    $errores[] = "Error al enviar a {$alumno->nombre}: {$e->getMessage()}";
                }
            }
        } else {
            $errores[] = "No se encontró el certificado para el alumno {$alumno->nombre}.";
        }
    }

    // Mostrar los errores si los hay
    if (!empty($errores)) {
        return redirect()->back()->with('error', implode('<br>', $errores));
    }

    return redirect()->back()->with('success', "Se enviaron {$enviados} certificados faltantes correctamente.");
}


// public function enviarCertificados($idcurso)
// {
//     $curso = Curso::findOrFail($idcurso);

//     // Contar los certificados que deberían existir (total esperados)
//     $cantidadFaltantes = Alumno::where('idcurso', $idcurso)
//         ->where('enviado', 0)
//         ->whereNotNull('correo')
//         ->count();

//     // Contar los certificados importados (archivos que ya existen)
//     $certificadosImportados = Alumno::where('idcurso', $idcurso)
//         ->whereNotNull('codigo')
//         ->get()
//         ->filter(function ($alumno) {
//             $certificadoPath = storage_path("app/public/certificados_firmados/{$alumno->codigo}.pdf");
//             return file_exists($certificadoPath);
//         })
//         ->count();

//     // Total de alumnos en el curso
//     $contadorCertificados = Alumno::where('idcurso', $idcurso)->count();

//     $alumnosFirmados = Alumno::where('idcurso', $idcurso)->paginate(10);


//     return view('curso.enviarcertificado', compact(
//         'curso',
//         'alumnosFirmados',
//         'cantidadFaltantes',
//         'contadorCertificados',
//         'certificadosImportados',
//         'idcurso'
//     ));
// }


}
