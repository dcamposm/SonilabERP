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

//------------------Rutes usuaris------------------
Route::middleware(['role: 1, 4'])->group(function () {//Middleware para dar acceso a los roles indicados,  en este caso 1 (Dis.Estudi) i 4 (Administracion)
    Route::get('/usuaris/interns/index', 'UserController@getIndex') ->name('indexUsuariIntern');
    Route::get('/usuaris/interns/buscar', 'UserController@find')->name('usuariFind');
    Route::get('/usuaris/interns/show/{id}', 'UserController@getShow')->name('veureUsuariIntern');
    Route::get('/usuaris/interns/crear', 'UserController@viewRegistre');
    Route::post('/usuaris/interns/crear', 'UserController@crearUsuario')->name('crearUsuariIntern');
    Route::get('/usuaris/interns/editar/{id}', 'UserController@viewEditarUsuario')->name('editarUsuariIntern');
    Route::post('/usuaris/interns/editar/{id}', 'UserController@editarUsuario')->name('editarUsuariIntern');
    Route::post('/usuaris/interns/esborrar', 'UserController@esborrarUsuari')->name('esborrarUsuariIntern');
});
//-------------------Rutes empleats externs-------------------
Route::middleware(['role: 1, 2, 4'])->group(function () {
    Route::get('/empleats', 'EmpleatExternController@index')->name('empleatIndex');
    Route::get('/empleats/buscar', 'EmpleatExternController@find')->name('empleatFind');
    Route::get('/empleats/mostrar/{id}', 'EmpleatExternController@show')->name('empleatShow');
    Route::get('/empleats/crear', 'EmpleatExternController@insertView')->name('empleatInsertView');
    Route::post('/empleats/crear', 'EmpleatExternController@insert')->name('empleatInsert');
    Route::get('/empleats/modificar/{id}', 'EmpleatExternController@updateView')->name('empleatUpdateView');
    Route::post('/empleats/modificar/{id}', 'EmpleatExternController@update')->name('empleatUpdate');
    Route::post('/empleats/esborrar', 'EmpleatExternController@delete')->name('empleatDelete');
});
//------------------Rutes registres entrada------------------
Route::middleware(['role: 1, 2, 4'])->group(function () {
    Route::get('/registreEntrada', 'RegistreEntradaController@index')->name('indexRegistreEntrada');
    Route::get('/registreEntrada/buscar', 'RegistreEntradaController@find')->name('registreEntradaFind');
    Route::get('/registreEntrada/mostrar/{id}', 'RegistreEntradaController@show')->name('mostrarRegistreEntrada');
    Route::middleware(['role: 1, 4'])->group(function () {
        Route::get('/registreEntrada/crear', 'RegistreEntradaController@insertView')->name('registreEntradaInsertView');
        Route::post('/registreEntrada/crear', 'RegistreEntradaController@insert')->name('registreEntradaInsert');
        Route::get('/registreEntrada/modificar/{id}', 'RegistreEntradaController@updateView')->name('registreEntradaUpdateView');
        Route::post('/registreEntrada/modificar/{id}', 'RegistreEntradaController@update')->name('registreEntradaUpdate');
        Route::post('/registreEntrada/esborrar', 'RegistreEntradaController@delete')->name('esborrarRegistreEntrada');
    });
});
//-----------------------Rutes clients-----------------------
Route::middleware(['role: 1, 2, 4'])->group(function () {
    Route::get('/clients', 'ClientController@index')->name('indexClient');
    Route::get('/clients/mostrar/{id}', 'ClientController@show')->name('mostrarClient');
    Route::middleware(['role: 1, 4'])->group(function () {
        Route::get('/clients/crear', 'ClientController@insertView')->name('clientInsertView');
        Route::post('/clients/crear', 'ClientController@insert')->name('clientInsert');
        Route::get('/clients/modificar/{id}', 'ClientController@updateView')->name('clientUpdateView');
        Route::post('/clients/modificar/{id}', 'ClientController@update')->name('clientUpdate');
        Route::post('/clients/esborrar', 'ClientController@delete')->name('esborrarClient');
    });
});
//-----------------------Rutes idiomes-----------------------
Route::get('/idiomes', 'IdiomaController@index')->name('indexIdioma');
Route::get('/idiomes/mostrar/{id}', 'IdiomaController@show')->name('idiomaShow');
Route::get('/idiomes/crear', 'IdiomaController@insertView')->name('idiomaInsertView');
Route::post('/idiomes/crear', 'IdiomaController@insert')->name('idiomaInsert');
Route::get('/idiomes/modificar/{id}', 'IdiomaController@updateView')->name('idiomaUpdateView');
Route::post('/idiomes/modificar/{id}', 'IdiomaController@update')->name('idiomaUpdate');
Route::post('/idiomes/esborrar', 'IdiomaController@delete')->name('idiomaDelete');
//------------------Rutes registre producció------------------
Route::get('/projectes', 'ProjectesController@getIndex')->name('indexProjectes');
//------------------Rutes estadillo------------------
Route::get('/estadillos', 'EstadilloController@index')->name('indexEstadillos');
Route::get('/estadillos/mostrar/{id}/{id_setmana?}', 'EstadilloController@show')->name('estadilloShow');
Route::get('/estadillos/mostrar/setmana/{id}/{id_setmana}', 'EstadilloController@showSetmana')->name('estadilloShowSetmana');
Route::post('/estadillos/import', 'EstadilloController@import')->name('estadilloImport');
Route::get('/estadillos/crear', 'EstadilloController@insertView')->name('estadilloInsertView');
Route::get('/estadillos/actor/crear/{id}/{setmana}', 'EstadilloController@insertActorView')->name('estadilloActorInsertView');
Route::post('/estadillos/crear', 'EstadilloController@insert')->name('estadilloInsert');
Route::post('/estadillos/actor/crear/', 'EstadilloController@insertActor')->name('estadilloActorInsert');
Route::get('/estadillos/modificar/{id}', 'EstadilloController@updateView')->name('estadilloUpdateView');
Route::get('/estadillos/modificar/actor/{id}/{id_actor}', 'EstadilloController@updateActorView')->name('estadilloActorUpdateView');
Route::post('/estadillos/modificar/{id}', 'EstadilloController@update')->name('estadilloUpdate');
Route::post('/estadillos/modificar/actor/{id}/{id_actor}', 'EstadilloController@updateActor')->name('estadilloActorUpdate');
Route::post('/estadillos/esborrar', 'EstadilloController@delete')->name('esborrarEstadillo');
Route::post('/estadillos/esborrar/actor', 'EstadilloController@deleteActor')->name('esborrarEstadilloActor');