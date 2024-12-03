<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Certificado;


use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AlumnoImport;

class AlumnoController extends Controller
{
    // Mostrar la lista de alumnos
    public function index(Request $request)
    {
        $query = Alumno::with('curso');

        // Filtro por búsqueda
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nombre', 'like', "%$search%")
                  ->orWhere('apellido', 'like', "%$search%")
                  ->orWhere('dni', 'like', "%$search%");
        }

        $alumnos = $query->paginate(10); // Paginación de 10 elementos

        return view('alumno.index', compact('alumnos'));
    }


    // Mostrar el formulario para crear un nuevo alumno
    public function create()
    {
        $cursos = Curso::where('estado', 1)->get(); // Obtener solo los cursos con estado 1
        return view('alumno.create', compact('cursos'));
    }


    // Almacenar un nuevo alumno
    public function store(Request $request)
{
    // Validar los datos del formulario
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'dni' => 'required|string|max:15', // Eliminado el unique
        'correo' => 'required|email|max:255', // Validación para correo único
        'idcurso' => 'required|exists:curso,idcurso',
        'estado' => 'required|boolean',
    ]);

    // Crear un nuevo registro en la base de datos
    Alumno::create($validated);

    // Redirigir a la lista de alumnos con un mensaje de éxito
    return redirect()->route('alumno.index')->with('success', 'Alumno creado correctamente.');
}


    // Mostrar el formulario de edición para un alumno
    public function edit($id)
    {
        $alumno = Alumno::findOrFail($id); // Obtener el alumno por ID
        $cursos = Curso::where('estado', 1)->get(); // Obtener solo los cursos con estado 1
        return view('alumno.edit', compact('alumno', 'cursos'));
    }

    // Actualizar los datos de un alumno
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:15', // Eliminado el unique
            'correo' => 'required|email|max:255', // Validar correo único, excepto para el registro actual
            'idcurso' => 'required|exists:curso,idcurso',
            'estado' => 'required|boolean',
        ]);

        // Actualizar el registro en la base de datos
        $alumno = Alumno::findOrFail($id);
        $alumno->update($validated);

        // Redirigir a la lista de alumnos con un mensaje de éxito
        return redirect()->route('alumno.index')->with('success', 'Alumno actualizado correctamente.');
    }


    // Eliminar un alumno
    public function destroy($id)
    {
        $alumno = Alumno::findOrFail($id);
        $alumno->delete();

        // Redirigir a la lista de alumnos con un mensaje de éxito
        return redirect()->route('alumno.index')->with('success', 'Alumno eliminado correctamente.');
    }

    //ver pagina para importar alumnos
    public function show()
    {
        $cursos = Curso::where('estado', 1)->get();
        $certificados = Certificado::all();

        return view('alumno.importaralumno', compact('cursos', 'certificados'));
    }


    // //ahora un metodo para importar alumnos
    // public function importar(Request $request)
    // {
    //     $file = $request->file('file');
    //     $data = Excel::toArray(new AlumnoImport(), $file);
    //     $alumnos = [];
    //     foreach ($data[0] as $alumno) {

    //         $alumnos[] = [
    //             'nombre' => $alumno['nombre'],
    //             'apellido' => $alumno['apellido'],
    //             'dni' => $alumno['dni'],
    //             'idcurso' => $alumno['idcurso'],
    //             'estado' => $alumno['estado'],
    //             ];
    //             }
    //             Alumno::insert($alumnos);
    //             return redirect()->route('alumno.index')->with('success', 'Alumnos importados correctamente.');
    //             }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'idcurso' => 'required|exists:curso,idcurso',
        ]);

        $file = $request->file('file');
        $idCurso = $request->idcurso;

        try {
            // Obtener el certificado asociado al curso
            $curso = Curso::with('certificado')->findOrFail($idCurso);

            // Verificar si el curso tiene un certificado asociado
            if (!$curso->certificado) {
                return redirect()->route('alumno.index')->with('error', 'El curso seleccionado no tiene un certificado asociado.');
            }

            // Importar los datos del Excel
            Excel::import(new AlumnoImport($idCurso), $file);

            return redirect()->route('alumno.index')->with('success', 'Alumnos importados correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('alumno.index')->with('error', 'Error durante la importación: ' . $e->getMessage());
        }
    }



public function descargarPlantilla()
{
    $path = public_path('plantillas/plantilla_alumnos.xlsx'); // Asegúrate de tener este archivo en tu directorio
    return response()->download($path, 'plantilla_alumnos.xlsx');
}


}
