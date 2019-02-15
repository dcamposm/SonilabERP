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

Route::middleware(['role: 1, 4'])->group(function () {
    Route::get('/usuaris/interns/index', 'UserController@getIndex') ->name('indexUsuariIntern');
    Route::get('/usuaris/interns/buscar', 'UserController@find')->name('usuariFind');
    Route::get('/usuaris/interns/show/{id}', 'UserController@getShow')->name('veureUsuariIntern');
    Route::get('/usuaris/interns/crear', 'UserController@viewRegistre');
    Route::post('/usuaris/interns/crear', 'UserController@crearUsuario')->name('crearUsuariIntern');
    Route::get('/usuaris/interns/editar/{id}', 'UserController@viewEditarUsuario')->name('editarUsuariIntern');
    Route::post('/usuaris/interns/editar/{id}', 'UserController@editarUsuario')->name('editarUsuariIntern');
    Route::post('/usuaris/interns/esborrar', 'UserController@esborrarUsuari')->name('esborrarUsuariIntern');
});

Route::get('/empleats', 'EmpleatExternController@index')->name('empleatIndex');
Route::get('/empleats/buscar', 'EmpleatExternController@find')->name('empleatFind');
Route::get('/empleats/mostrar/{id}', 'EmpleatExternController@show')->name('empleatShow');
Route::get('/empleats/crear', 'EmpleatExternController@insertView')->name('empleatInsertView');
Route::post('/empleats/crear', 'EmpleatExternController@insert')->name('empleatInsert');
Route::get('/empleats/modificar/{id}', 'EmpleatExternController@updateView')->name('empleatUpdateView');
Route::post('/empleats/modificar/{id}', 'EmpleatExternController@update')->name('empleatUpdate');
Route::post('/empleats/esborrar', 'EmpleatExternController@delete')->name('empleatDelete');

Route::get('/registreEntrada', 'RegistreEntradaController@index')->name('indexRegistreEntrada');
Route::get('/registreEntrada/buscar', 'RegistreEntradaController@find')->name('registreEntradaFind');
Route::get('/registreEntrada/crear', 'RegistreEntradaController@insertView')->name('registreEntradaInsertView');
Route::post('/registreEntrada/crear', 'RegistreEntradaController@insert')->name('registreEntradaInsert');
Route::get('/registreEntrada/mostrar/{id}', 'RegistreEntradaController@show')->name('mostrarRegistreEntrada');
Route::get('/registreEntrada/modificar/{id}', 'RegistreEntradaController@updateView')->name('registreEntradaUpdateView');
Route::post('/registreEntrada/modificar/{id}', 'RegistreEntradaController@update')->name('registreEntradaUpdate');
Route::post('/registreEntrada/esborrar', 'RegistreEntradaController@delete')->name('esborrarRegistreEntrada');

Route::get('/clients', 'ClientController@index')->name('indexClient');
Route::get('/clients/mostrar/{id}', 'ClientController@show')->name('mostrarClient');
Route::get('/clients/crear', 'ClientController@insertView')->name('clientInsertView');
Route::post('/clients/crear', 'ClientController@insert')->name('clientInsert');
Route::get('/clients/modificar/{id}', 'ClientController@updateView')->name('clientUpdateView');
Route::post('/clients/modificar/{id}', 'ClientController@update')->name('clientUpdate');
Route::post('/clients/esborrar', 'ClientController@delete')->name('esborrarClient');

Route::get('/projectes', 'ProjectesController@getIndex')->name('indexProjectes');
