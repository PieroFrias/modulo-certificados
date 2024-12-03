<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\EnvioCertificado;
use App\Models\Alumno;

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

        // Enviar el correo
        Mail::to($alumno->correo)->send(new EnvioCertificado($alumno, $certificadoPath));

        // Actualizar columnas enviado y vecesenviado
        $alumno->update([
            'enviado' => 1,
            'vecesenviado' => $alumno->vecesenviado + 1,
        ]);

        return redirect()->back()->with('success', "Correo enviado correctamente al alumno {$alumno->nombre}.");
    }

    // Enviar correos masivos
    public function enviarCorreosMasivos($idcurso)
    {
        $alumnos = Alumno::where('idcurso', $idcurso)->whereNotNull('correo')->get();
        $errores = [];

        foreach ($alumnos as $alumno) {
            $certificadoPath = storage_path("app/public/certificados_firmados/{$alumno->codigo}.pdf");

            if (file_exists($certificadoPath)) {
                Mail::to($alumno->correo)->send(new EnvioCertificado($alumno, $certificadoPath));

                // Actualizar columnas enviado y vecesenviado
                $alumno->update([
                    'enviado' => 1,
                    'vecesenviado' => $alumno->vecesenviado + 1,
                ]);
            } else {
                $errores[] = "No se encontró el certificado del alumno con código {$alumno->codigo}.";
            }
        }

        if (count($errores) > 0) {
            return redirect()->back()->with('error', 'Algunos correos no fueron enviados: ' . implode(', ', $errores));
        }

        return redirect()->back()->with('success', 'Todos los correos se enviaron correctamente.');
    }
}
