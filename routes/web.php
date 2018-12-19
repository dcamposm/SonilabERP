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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/usuaris/interns/crear', 'UserController@mostrarFormulariRegistre');
Route::post('/usuaris/interns/crear', 'UserController@registrar')->name('crearUsuariIntern');
Route::post('/usuaris/interns/editar/{id}', 'UserController@editarUsuario')->with('id', $id)->name('crearUsuariIntern');
