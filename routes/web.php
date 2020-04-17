<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('logueo', function () {
    return view('layouts.index');
});

Route::get('/', 'Auth\LoginController@inicio');

// Route::get('user/{id}', function($id){
//     return 'Bienvenido '.$id_demo;
// });

// Route::get('users/{id}', function ($id) {
    
// });

Route::get('prueba/inicia', 'PruebaController@inicia'); 

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('prueba/tabla', 'CarreraController@tabla'); 

Route::post('carrera/store', 'CarreraController@store'); 

Route::get('persona/nuevo', 'PersonaController@nuevo'); 
Route::post('persona/guarda', 'PersonaController@guarda');
Route::get('persona/listado', 'PersonaController@listado');
Route::get('persona/ajax_datos', 'PersonaController@ajax_datos');
// Route::get('persona/ajax_datos', function () {
    // return datatables()->query(DB::table('personas'))->toJson();
// });
Route::get('persona/exportarexcel', 'PersonaController@exportarExcel')->name('personas.exportarexcel');


//NOTAS
Route::get('nota/listado', 'NotaController@listado');
Route::get('nota/detalle/{id}', 'NotaController@detalle');
Route::post('nota/ajax_importar', 'NotaController@ajax_importar');
Route::post('nota/importarexcel', 'NotaController@importarexcel');
Route::get('user/asignar', 'UserController@asignar');
Route::get('nota/actualizar', 'NotaController@actualizar');
Route::get('nota/exportarexcel/{id}', 'NotaController@exportarexcel');
Route::get('nota/index', 'NotaController@index');
Route::get('nota/asignatura/{id}', 'NotaController@asignatura');
Route::get('nota/show', 'NotaController@show');
Route::get('nota/detalle', 'NotaController@detalle');
Route::get('nota/show2', 'NotaController@show2');
Route::get('nota/detalle2', 'NotaController@detalle2');
//Route::get('notaspropuesta/listado', 'NotasPropuestaController@listado');

//NOTAS PROPUESTA
Route::get('notaspropuesta/listado', 'NotasPropuestaController@listado');
Route::get('notaspropuesta/actualizar', 'NotasPropuestaController@actualizar');
Route::get('notaspropuesta/exportarexcel/{id}', 'NotasPropuestaController@exportarexcel');
Route::post('notaspropuesta/ajax_importar', 'NotasPropuestaController@ajax_importar');

//MIGRACIONES
Route::get('Migracion/inicia', 'MigracionController@inicia');

Route::get('Migracion/usuario', 'MigracionController@usuario');

Route::get('Migracion/asignatura', 'MigracionController@asignatura');

Route::get('Migracion/notas_propuestas', 'MigracionController@notas_propuestas');

//INSCRIPCIONES
Route::get('Inscripcion/inscripcion', 'InscripcionController@inscripcion');

Route::get('Inscripcion/contabilidad', 'InscripcionController@contabilidad');

Route::get('Inscripcion/secretariado', 'InscripcionController@secretariado');

Route::get('Inscripcion/auxiliar', 'InscripcionController@auxiliar');

Route::get('Inscripcion/busca_asignatura', 'InscripcionController@busca_asignatura');

Route::get('Inscripcion/busca_carrera', 'InscripcionController@busca_carrera');

Route::get('Inscripcion/lista', 'InscripcionController@lista');

Route::get('Inscripcion/ajax_datos', 'InscripcionController@ajax_datos');

Route::get('Inscripcion/re_inscripcion/{id}', 'InscripcionController@re_inscripcion');

Route::get('Inscripcion/asignaturas_a_tomar', 'InscripcionController@asignaturas_a_tomar');

// ADMINISTRACION
Route::get('Carrera/listado', 'CarreraController@listado');
Route::get('Carrera/ajax_lista_asignaturas', 'CarreraController@ajax_lista_asignaturas');
Route::post('Carrera/guarda', 'CarreraController@guarda');
// Route::get('Carrera/ajax_lista_asignaturas', 'CarreraController@ajax_lista_asignaturas');
// Route::post('Carrera/listado', 'CarreraController@listado');
Route::get('Asignatura/listado_malla/{carrera_id}', 'AsignaturaController@listado_malla');