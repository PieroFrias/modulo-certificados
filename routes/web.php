<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ConfiguracionController;

Route::get('/', [AdminController::class, 'index']);

// Route::get('/', [CertificadoController::class, 'index']);


Route::resource('certificados', CertificadoController::class);
//Ruta [certificados.view] para mostrar el certificado
// Route::get('certificados/{id}/view', [CertificadoController::class, 'view'])->name('certificados.view');

// ruta de create
Route::get('certificados/create', [CertificadoController::class, 'create'])->name('certificados.create');
// ruta de store
Route::post('certificados', [CertificadoController::class, 'store'])->name('certificados.store');
// ruta de show
Route::get('certificados/{id}', [CertificadoController::class, 'show'])->name('certificados.view');
// ruta de edit
Route::get('certificados/{id}/edit', [CertificadoController::class, 'edit'])->name('certificados.edit');
// Ruta [certificados.download] para descargar el certificado
Route::get('certificados/{id}/download', [CertificadoController::class, 'download'])->name('certificados.download');
// Ruta [certificados.generate] para generar el certificado
Route::get('certificados/{id}/generate', [CertificadoController::class, 'generate'])->name('certificados.generate');
// Ruta [certificados.send] para enviar el certificado por correo
Route::get('certificados/{id}/send', [CertificadoController::class, 'send'])->name('certificados.send');
// Ruta [certificados.print] para imprimir el certificado
Route::get('certificados/{id}/print', [CertificadoController::class, 'print'])->name('certificados.print');
// Ruta [certificados.delete] para eliminar el certificado
Route::delete('certificados/{id}', [CertificadoController::class, 'destroy'])->name('certificados.delete');
// Ruta [certificados.delete] para eliminar el certificado
Route::get('certificados/{id}/delete', [CertificadoController::class, 'delete'])->name('certificados.delete');






// RUTA PARA CURSOS ------------------------------------------------------------------------
Route::resource('curso', CursoController::class);
// Ruta para crear un nuevo curso
Route::get('curso/create', [CursoController::class, 'create'])->name('curso.create');
// Ruta para almacenar un nuevo curso
Route::post('curso', [CursoController::class, 'store'])->name('curso.store');
// Ruta para mostrar un curso específico
Route::get('curso/{id}', [CursoController::class, 'show'])->name('curso.view');
// Ruta para editar un curso
Route::get('curso/{id}/edit', [CursoController::class, 'edit'])->name('curso.edit');
// Ruta para actualizar un curso
Route::put('curso/{id}', [CursoController::class, 'update'])->name('curso.update');
// Ruta para eliminar un curso
Route::delete('curso/{id}', [CursoController::class, 'destroy'])->name('curso.delete');


// RUTA PARA ALUMNOS ------------------------------------------------------------------------
Route::resource('alumno', AlumnoController::class);
// Ruta para crear un nuevo alumno
Route::get('alumno/create', [AlumnoController::class, 'create'])->name('alumno.create');
// Ruta para almacenar un nuevo alumno
Route::post('alumno', [AlumnoController::class, 'store'])->name('alumno.store');
// Ruta para editar un alumno
Route::get('alumno/{id}/edit', [AlumnoController::class, 'edit'])->name('alumno.edit');
// Ruta para actualizar un alumno
Route::put('alumno/{id}', [AlumnoController::class, 'update'])->name('alumno.update');
// Ruta para eliminar un alumno
Route::delete('alumno/{id}', [AlumnoController::class, 'destroy'])->name('alumno.delete');



// RUTA PARA CONSULTAS ------------------------------------------------------------------------
// Rutas manuales para evitar el problema del método `show`
Route::get('consulta', [ConsultaController::class, 'index'])->name('consulta.index');
//ruta para ver el certificado
Route::get('consulta/{id}', [ConsultaController::class, 'viewCertificado'])->name('consulta.template');



// RUTA PARA CONFIGURACIONES DE CERTIFICADOS
// Route::resource('configuraciones', ConfiguracionController::class);
// RUTA PARA CONFIGURACIONES DE CERTIFICADOS
Route::get('configuraciones/configuracioncertificado', [ConfiguracionController::class, 'index'])->name('configuracion.configuracioncertificado');
Route::get('configuraciones/{idcertificado}/edit', [ConfiguracionController::class, 'edit'])->name('configuracion.editarconfiguracion');
Route::put('configuraciones/{idcertificado}', [ConfiguracionController::class, 'update'])->name('configuracion.update');





