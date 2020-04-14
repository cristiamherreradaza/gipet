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



Route::get('nota/listado', 'NotaController@listado');
Route::get('nota/detalle/{id}', 'NotaController@detalle');





Route::get('user/asignar', 'UserController@asignar');
//Route::get('nota/listado', 'NotaController@listado');
Route::get('nota/actualizar', 'NotaController@actualizar');
Route::get('nota/exportarexcel/{id}', 'NotaController@exportarexcel');
Route::post('nota/importarexcel', 'NotaController@importarexcel');
Route::get('nota/index', 'NotaController@index');
Route::post('nota/ajax_importar', 'NotaController@ajax_importar');
Route::get('nota/asignatura/{id}', 'NotaController@asignatura');
//Route::get('nota/exportarexcel/{id}', 'NotaController@exportarexcel');

Route::get('nota/show', 'NotaController@show');
Route::get('nota/detalle', 'NotaController@detalle');

Route::get('nota/show2', 'NotaController@show2');
Route::get('nota/detalle2', 'NotaController@detalle2');

Route::get('notaspropuesta/listado', 'NotasPropuestaController@listado');

//MIGRACIONES
Route::get('Migracion/inicia', 'MigracionController@inicia');

Route::get('Migracion/usuario', 'MigracionController@usuario');

Route::get('Migracion/asignatura', 'MigracionController@asignatura');