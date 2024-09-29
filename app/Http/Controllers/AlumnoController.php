<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Curso;

class AlumnoController extends Controller
{
    // Mostrar la lista de alumnos
    public function index()
    {
        $alumnos = Alumno::with('curso')->get(); // Obtener los alumnos con su curso relacionado
        return view('alumno.index', compact('alumnos'));
    }

    // Mostrar el formulario para crear un nuevo alumno
    public function create()
    {
        $cursos = Curso::all(); // Obtener todos los cursos para el select
        return view('alumno.create', compact('cursos'));
    }

    // Almacenar un nuevo alumno
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|size:8|unique:alumno,dni',
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
        $cursos = Curso::all(); // Obtener todos los cursos para el select
        return view('alumno.edit', compact('alumno', 'cursos'));
    }

    // Actualizar los datos de un alumno
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|size:8|unique:alumno,dni,' . $id,
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
}
