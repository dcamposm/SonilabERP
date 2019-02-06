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
    return redirect("/login");
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/usuaris/interns/index', 'UserController@getIndex') ->name('indexUsuariIntern')->middleware('role: 1, 4' );
Route::get('/usuaris/interns/show/{id}', 'UserController@getShow')->name('veureUsuariIntern');
Route::get('/usuaris/interns/crear', 'UserController@viewRegistre');
Route::post('/usuaris/interns/crear', 'UserController@crearUsuario')->name('crearUsuariIntern');
Route::get('/usuaris/interns/editar/{id}', 'UserController@viewEditarUsuario')->name('editarUsuariIntern');
Route::post('/usuaris/interns/editar/{id}', 'UserController@editarUsuario')->name('editarUsuariIntern');
Route::post('/usuaris/interns/esborrar', 'UserController@esborrarUsuari')->name('esborrarUsuariIntern');

Route::get('/empleats', 'EmpleatExternController@index')->name('empleatIndex');
Route::get('/empleats/buscar', 'EmpleatExternController@find')->name('empleatFind');
Route::get('/empleats/mostrar/{id}', 'EmpleatExternController@show')->name('empleatShow');
Route::get('/empleats/crear', 'EmpleatExternController@insertView')->name('empleatInsertView');
Route::post('/empleats/crear', 'EmpleatExternController@insert')->name('empleatInsert');
Route::get('/empleats/modificar/{id}', 'EmpleatExternController@updateView')->name('empleatUpdateView');
Route::post('/empleats/modificar/{id}', 'EmpleatExternController@update')->name('empleatUpdate');
Route::post('/empleats/esborrar', 'EmpleatExternController@delete')->name('empleatDelete');

Route::get('/registreEntrada', 'RegistreEntradaController@index')->name('indexRegistreEntrada');
Route::get('/registreEntrada/crear', 'RegistreEntradaController@insertView')->name('registreEntradaInsertView');
Route::get('/registreEntrada/mostrar', 'RegistreEntradaController@index')->name('mostrarRegistreEntrada');  // FIXME: Especificar la función correspondiente cuando esté creada.
Route::get('/registreEntrada/modificar/{id}', 'RegistreEntradaController@updateView')->name('registreEntradaUpdateView');
Route::post('/registreEntrada/modificar', 'RegistreEntradaController@update')->name('registreEntradaUpdate');
Route::post('/registreEntrada/esborrar', 'RegistreEntradaController@delete')->name('esborrarRegistreEntrada');
