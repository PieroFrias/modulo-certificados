<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnvioCertificadoController;


// Rutas de login
//pon la ruta de inicio en la raiz de login llamalo atravez de AuthController
Route::get('/', [AuthController::class, 'index'])->name('login');




Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Ruta protegida (solo para usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::resources([
        'inicio' => AdminController::class,
        'certificados' => CertificadoController::class,
        'curso' => CursoController::class,
        'alumno' => AlumnoController::class,
        'configuraciones' => ConfiguracionController::class,
    ]);

});

// Ruta protegida para la vista de inicio de administrador con auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/inicio', [AdminController::class, 'index'])->name('inicio.index')->middleware('auth');
});
// Route::get('/inicio', [AdminController::class, 'index'])->name('inicio.index');





// Route::get('/', [CertificadoController::class, 'index']);


Route::resource('certificados', CertificadoController::class)->middleware('auth');
//Ruta [certificados.view] para mostrar el certificado
// Route::get('certificados/{id}/view', [CertificadoController::class, 'view'])->name('certificados.view');

// ruta de create
Route::get('certificados/create', [CertificadoController::class, 'create'])->name('certificados.create')->middleware('auth');
// ruta de store
Route::post('certificados', [CertificadoController::class, 'store'])->name('certificados.store')->middleware('auth');
// ruta de show
Route::get('certificados/{id}', [CertificadoController::class, 'show'])->name('certificados.view')->middleware('auth');
// ruta de edit
Route::get('certificados/{id}/edit', [CertificadoController::class, 'edit'])->name('certificados.edit')->middleware('auth');
// Ruta [certificados.download] para descargar el certificado
Route::get('certificados/{id}/download', [CertificadoController::class, 'download'])->name('certificados.download')->middleware('auth');
// Ruta [certificados.generate] para generar el certificado
Route::get('certificados/{id}/generate', [CertificadoController::class, 'generate'])->name('certificados.generate')->middleware('auth');
// Ruta [certificados.send] para enviar el certificado por correo
Route::get('certificados/{id}/send', [CertificadoController::class, 'send'])->name('certificados.send')->middleware('auth');
// Ruta [certificados.print] para imprimir el certificado
Route::get('certificados/{id}/print', [CertificadoController::class, 'print'])->name('certificados.print')->middleware('auth');
// Ruta [certificados.delete] para eliminar el certificado
Route::delete('certificados/{id}', [CertificadoController::class, 'destroy'])->name('certificados.delete')->middleware('auth');
// Ruta [certificados.delete] para eliminar el certificado
Route::get('certificados/{id}/delete', [CertificadoController::class, 'delete'])->name('certificados.delete')->middleware('auth');






// RUTA PARA CURSOS ------------------------------------------------------------------------
Route::resource('curso', CursoController::class)->middleware('auth');
// Ruta para crear un nuevo curso
Route::get('curso/create', [CursoController::class, 'create'])->name('curso.create')->middleware('auth');
// Ruta para almacenar un nuevo curso
Route::post('curso', [CursoController::class, 'store'])->name('curso.store')->middleware('auth');
// Ruta para mostrar un curso específico
Route::get('curso/{id}', [CursoController::class, 'show'])->name('curso.view')->middleware('auth');
// Ruta para editar un curso
Route::get('curso/{id}/edit', [CursoController::class, 'edit'])->name('curso.edit')->middleware('auth');
// Ruta para actualizar un curso
Route::put('curso/{id}', [CursoController::class, 'update'])->name('curso.update')->middleware('auth');
// Ruta para eliminar un curso
Route::delete('curso/{id}', [CursoController::class, 'destroy'])->name('curso.delete')->middleware('auth');

Route::get('/curso/{idcurso}/alumnos', [CursoController::class, 'alumnos'])->name('curso.alumnos')->middleware('auth');

// Route::get('/curso/{idcurso}/certificados/masivos', [CursoController::class, 'generarCertificadosMasivos'])->name('curso.generar_certificados_masivos');
Route::get('/curso/{idcurso}/certificado/{idalumno}', [CursoController::class, 'generarCertificado'])->name('curso.generar_certificado')->middleware('auth');

Route::get('/curso/{idcurso}/certificados/masivos', [CursoController::class, 'generarCertificadosMasivos'])->name('curso.generar_certificados_masivos')->middleware('auth');




// RUTA PARA ALUMNOS ------------------------------------------------------------------------
Route::resource('alumno', AlumnoController::class)->middleware('auth');
// Ruta para crear un nuevo alumno
Route::get('alumno/create', [AlumnoController::class, 'create'])->name('alumno.create')->middleware('auth');
// Ruta para almacenar un nuevo alumno
Route::post('alumno', [AlumnoController::class, 'store'])->name('alumno.store')->middleware('auth');
// Ruta para editar un alumno
Route::get('alumno/{id}/edit', [AlumnoController::class, 'edit'])->name('alumno.edit')->middleware('auth');
// Ruta para actualizar un alumno
Route::put('alumno/{id}', [AlumnoController::class, 'update'])->name('alumno.update')->middleware('auth');
// Ruta para eliminar un alumno
Route::delete('alumno/{id}', [AlumnoController::class, 'destroy'])->name('alumno.delete')->middleware('auth');

//ruta para importar alumnos
Route::get('alumno/import', [AlumnoController::class, 'import'])->name('alumno.import')->middleware('auth');

// Route::get('/alumno/{id}', [AlumnoController::class, 'show'])->name('alumno.show');

Route::get('/alumno/importar', function () {return view('importaralumno');})->name('alumno.importar')->middleware('auth');

Route::post('/alumno/importar', [AlumnoController::class, 'import'])->name('alumno.importar')->middleware('auth');

Route::get('/alumno/plantilla', [AlumnoController::class, 'descargarPlantilla'])->name('alumno.plantilla')->middleware('auth');







// RUTA PARA CONSULTAS ------------------------------------------------------------------------
// Rutas manuales para evitar el problema del método `show`
Route::get('consulta', [ConsultaController::class, 'index'])->name('consulta.index');
//ruta para ver el certificado
Route::get('consulta/{id}', [ConsultaController::class, 'viewCertificado'])->name('consulta.template');



// RUTA PARA CONFIGURACIONES DE CERTIFICADOS
Route::resource('configuraciones', ConfiguracionController::class)->middleware('auth')->middleware('auth');
Route::get('configuraciones/configuracioncertificado', [ConfiguracionController::class, 'index'])->name('configuracion.configuracioncertificado')->middleware('auth');
Route::get('configuraciones/{idcertificado}/edit', [ConfiguracionController::class, 'edit'])->name('configuracion.editarconfiguracion')->middleware('auth');
Route::put('configuraciones/{idcertificado}', [ConfiguracionController::class, 'update'])->name('configuracion.update')->middleware('auth');



// RUTA PARA ENVIAR CERTIFICADO  ------------------------------------------------------------------------

//RUTA curso enviar certificado con la vista enviarcertificado
Route::get('curso/{idcurso}/enviarcertificado', [CursoController::class, 'enviarCertificado'])->name('curso.enviarcertificado')->middleware('auth');
 //RUTA PARA IMPORTAR ALUMNOS EN LA VISTA DE enviarcertificado los alumnos se importan en archivo pdf
Route::post('curso/{idcurso}/enviarcertificado', [CursoController::class, 'importarAlumnos'])->name('curso.importaralumnos')->middleware('auth');


// Route::post('curso/{idcurso}/enviar-todos', [CursoController::class, 'enviarTodosCertificados'])->name('curso.enviarTodosCertificados');
// Route::post('curso/{idcurso}/enviar-correo/{idalumno}', [CursoController::class, 'enviarCorreoIndividual'])->name('curso.enviarCorreoIndividual');

Route::post('curso/{idcurso}/enviar-correo/{idalumno}', [EnvioCertificadoController::class, 'enviarCorreoIndividual'])->name('curso.enviarCorreoIndividual')->middleware('auth');
Route::post('curso/{idcurso}/enviar-todos', [EnvioCertificadoController::class, 'enviarCorreosMasivos'])->name('curso.enviarTodosCertificados')->middleware('auth');


Route::get('/consulta/descargar/{codigo}', [ConsultaController::class, 'descargarCertificado'])->name('consulta.descargarCertificado');
Route::post('/curso/{idcurso}/reenviar-faltantes', [EnvioCertificadoController::class, 'reenviarFaltantes'])->name('curso.reenviarFaltantes');
Route::post('/curso/{idcurso}/reenviar-faltantes-configurados', [EnvioCertificadoController::class, 'reenviarFaltantesConfigurados'])->name('curso.reenviarFaltantesConfigurados');

// Route::get('/curso/{idcurso}/enviar-certificados', [EnvioCertificadoController::class, 'enviarCertificados'])->name('curso.enviarcertificado');
// Route::post('/curso/{idcurso}/enviar-todos', [EnvioCertificadoController::class, 'enviarCorreosMasivos'])->name('curso.enviarTodosCertificados');

// Route::get('/curso/{idcurso}/enviar-certificados', [EnvioCertificadoController::class, 'enviarCertificados'])->name('curso.enviarcertificado');
