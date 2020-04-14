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

Route::get('user/{id}', function($id){
    return 'Bienvenido '.$id_demo;
});

Route::get('users/{id}', function ($id) {
    
});

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

Route::get('nota/listado', 'NotaController@listado');
Route::get('nota/index', 'NotaController@index');
Route::get('nota/asignaturas', 'NotaController@asignaturas');

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

Route::get('Inscripcion/re_inscripcion/{id}', 'InscripcionController@re_inscripcion');

Route::get('Inscripcion/asignaturas_a_tomar', 'InscripcionController@asignaturas_a_tomar');