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

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/{id}', function($id){
    return 'Bienvenido '.$id_demo;
});

Route::get('users/{id}', function ($id) {
    
});

Route::get('prueba/inicia', 'PruebaController@inicia'); 
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
