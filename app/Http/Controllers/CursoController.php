<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Certificado;

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
    ]);

    // Crear un nuevo registro en la base de datos
    Curso::create([
        'nombre' => $validated['nombre'],
        'estado' => $validated['estado'],
        'idcertificado' => $validated['idcertificado'], // Almacenar la relación con el certificado
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
           ]);

           $curso = Curso::findOrFail($id);
           $curso->update([
               'nombre' => $validated['nombre'],
               'estado' => $validated['estado'],
               'idcertificado' => $validated['idcertificado'],
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
}
