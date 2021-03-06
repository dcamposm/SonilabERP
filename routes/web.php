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
Route::middleware(['role: 1, 5'])->group(function () { //Middleware para dar acceso a los roles indicados,  en este caso 1 (Dis.Estudi) i 5 (Sistemes&IT)
    Route::get('/usuaris/index', 'UserController@getIndex')->name('indexUsuariIntern');
    Route::get('/usuaris/buscar', 'UserController@find')->name('usuariFind');
    Route::get('/usuaris/show/{id}', 'UserController@getShow')->name('veureUsuariIntern');
    Route::get('/usuaris/crear', 'UserController@viewRegistre');
    Route::post('/usuaris/crear', 'UserController@crearUsuario')->name('crearUsuariIntern');
    Route::get('/usuaris/editar/{id}', 'UserController@viewEditarUsuario')->name('editarUsuariIntern');
    Route::post('/usuaris/editar/{id}', 'UserController@editarUsuario')->name('editarUsuariIntern');
    Route::post('/usuaris/esborrar', 'UserController@esborrarUsuari')->name('esborrarUsuariIntern');
    Route::get('/usuaris/search', 'UserController@search')->name('usuariSearch');
});
//-------------------Rutes empleats externs-------------------
Route::middleware(['role: 1, 2, 4, 5'])->group(function () {
    Route::get('/empleats', 'EmpleatExternController@index')->name('empleatIndex');
    Route::get('/empleats/buscar', 'EmpleatExternController@find')->name('empleatFind');
    Route::get('/empleats/mostrar/{id}', 'EmpleatExternController@show')->name('empleatShow');
    Route::get('/empleats/crear', 'EmpleatExternController@insertView')->name('empleatInsertView');
    Route::post('/empleats/crear', 'EmpleatExternController@insert')->name('empleatInsert');
    Route::get('/empleats/modificar/{id}', 'EmpleatExternController@updateView')->name('empleatUpdateView');
    Route::post('/empleats/modificar/{id}', 'EmpleatExternController@update')->name('empleatUpdate');
    Route::post('/empleats/esborrar', 'EmpleatExternController@delete')->name('empleatDelete');
    Route::get('/empleats/search', 'EmpleatExternController@search')->name('empleatSearch');
    Route::post('/empleats/check', 'EmpleatExternController@check')->name('empleatCheck');
    
});
//------------------Rutes registres entrada------------------
Route::middleware(['role: 1, 2, 4, 5'])->group(function () {
    Route::get('/registreEntrada', 'RegistreEntradaController@index')->name('indexRegistreEntrada');
    Route::get('/registreEntrada/buscar', 'RegistreEntradaController@find')->name('registreEntradaFind');
    Route::get('/registreEntrada/mostrar/{id}', 'RegistreEntradaController@show')->name('mostrarRegistreEntrada');
    Route::middleware(['role: 1, 5'])->group(function () {
        Route::get('/registreEntrada/crear', 'RegistreEntradaController@insertView')->name('registreEntradaInsertView');
        Route::post('/registreEntrada/crear', 'RegistreEntradaController@insert')->name('registreEntradaInsert');
        Route::get('/registreEntrada/modificar/{id}', 'RegistreEntradaController@updateView')->name('registreEntradaUpdateView');
        Route::post('/registreEntrada/modificar/{id}', 'RegistreEntradaController@update')->name('registreEntradaUpdate');
        Route::post('/registreEntrada/esborrar', 'RegistreEntradaController@delete')->name('esborrarRegistreEntrada');
    });
    Route::get('/registreEntrada/search', 'RegistreEntradaController@search')->name('registreEntradaSearch');
});
//-----------------------Rutes clients-----------------------
Route::middleware(['role: 1, 2, 4, 5'])->group(function () {
    Route::get('/clients', 'ClientController@index')->name('indexClient');
    Route::get('/clients/mostrar/{id}', 'ClientController@show')->name('mostrarClient');
    Route::middleware(['role: 1, 5'])->group(function () {
        Route::get('/clients/crear', 'ClientController@insertView')->name('clientInsertView');
        Route::post('/clients/crear', 'ClientController@insert')->name('clientInsert');
        Route::get('/clients/modificar/{id}', 'ClientController@updateView')->name('clientUpdateView');
        Route::post('/clients/modificar/{id}', 'ClientController@update')->name('clientUpdate');
        Route::post('/clients/esborrar', 'ClientController@delete')->name('esborrarClient');
    });
});
//------------------Rutes registre producció------------------
Route::middleware(['role: 1,2,3,4,5'])->group(function () {
    Route::get('/registreProduccio', 'RegistreProduccioController@getIndex')->name('indexRegistreProduccio');
    Route::get('/registreProduccio/buscar', 'RegistreProduccioController@find')->name('registreProduccioFind');
    Route::get('/registreProduccio/crear', 'RegistreProduccioController@createView')->name('createRegistreProduccio');
    Route::get('/registreProduccio/modificar/{id}', 'RegistreProduccioController@updateView')->name('updateRegistreProduccio');
    Route::get('/registreProduccio/mostrar/{id}', 'RegistreProduccioController@show')->name('mostrarRegistreProduccio');

    Route::post('/registreProduccio/crearBasic', 'RegistreProduccioController@createBasic')->name('createRegistreBasic');
    Route::post('/registreProduccio/crearComanda', 'RegistreProduccioController@createComanda')->name('createRegisteComanda');
    Route::post('/registreProduccio/crearPreparacio', 'RegistreProduccioController@createPreparacio')->name('createRegistrePreparacio');
    Route::post('/registreProduccio/crearConvocatoria', 'RegistreProduccioController@createConvocatoria')->name('createRegistreConvocatoria');

    Route::post('/registreProduccio/modificarBasic/{id}', 'RegistreProduccioController@updateBasic')->name('updateRegistreBasic');
    Route::post('/registreProduccio/modificarComanda/{id}', 'RegistreProduccioController@updateComanda')->name('updateRegistreComanda');
    Route::post('/registreProduccio/modificarPreparacio/{id}', 'RegistreProduccioController@updatePreparacio')->name('updateRegistrePreparacio');
    Route::post('/registreProduccio/modificarConvocatoria/{id}', 'RegistreProduccioController@updateConvocatoria')->name('updateRegistreConvocatoria');
    Route::post('/registreProduccio/modificarAll/{id}', 'RegistreProduccioController@update')->name('updateRegistreProduccioAll');

    Route::post('/registreProduccio/delete', 'RegistreProduccioController@delete')->name('deleteRegistre');

    Route::get('/registreProduccio/search', 'RegistreProduccioController@search')->name('registreProduccioSearch');
});

//------------------Rutes estadillo------------------
Route::middleware(['role: 1,2,4,5'])->group(function () {
    Route::get('/estadillos', 'EstadilloController@index')->name('indexEstadillos');
    Route::get('/estadillos/buscar', 'EstadilloController@find')->name('estadilloFind');
    Route::get('/estadillos/buscar/actor/{id}/{id_setmana?}', 'EstadilloController@findActor')->name('actorFind');

    Route::get('/estadillos/mostrar/{id}/{id_setmana?}', 'EstadilloController@show')->name('estadilloShow');
    Route::get('/estadillos/mostrar/setmana/{id}/{id_setmana}', 'EstadilloController@showSetmana')->name('estadilloShowSetmana');

    Route::post('/estadillos/import', 'EstadilloController@import')->name('estadilloImport');

    Route::get('/estadillos/crear', 'EstadilloController@insertView')->name('estadilloInsertView');
    Route::get('/estadillos/actor/crear/{id}/{setmana?}', 'EstadilloController@insertActorView')->name('estadilloActorInsertView');
    Route::post('/estadillos/crear', 'EstadilloController@insert')->name('estadilloInsert');
    Route::post('/estadillos/actor/crear/{setmana?}', 'EstadilloController@insertActor')->name('estadilloActorInsert');

    Route::get('/estadillos/modificar/{id}', 'EstadilloController@updateView')->name('estadilloUpdateView');
    Route::get('/estadillos/modificar/actor/{id}/{id_actor}/{setmana?}', 'EstadilloController@updateActorView')->name('estadilloActorUpdateView');
    Route::post('/estadillos/modificar/{id}', 'EstadilloController@update')->name('estadilloUpdate');
    Route::post('/estadillos/modificar/actor/{id}/{id_actor}/{setmana?}', 'EstadilloController@updateActor')->name('estadilloActorUpdate');

    Route::post('/estadillos/esborrar', 'EstadilloController@delete')->name('esborrarEstadillo');
    Route::post('/estadillos/esborrar/actor', 'EstadilloController@deleteActor')->name('esborrarEstadilloActor');
    
    Route::get('/estadillos/actors', 'EstadilloController@getActors')->name('getActors');
});

//------------------Rutes vec------------------
Route::middleware(['role: 1,2,4,5'])->group(function () {
    Route::get('/vec/{ref?}', 'CostController@index')->name('indexVec');

    Route::get('/vec/mostrar/{id}/{data?}', 'CostController@show')->name('mostrarVec');
    Route::get('/vec/mostrar/pack/{id}/{data?}', 'CostController@showPack')->name('vecShowPack');

    Route::get('/vec/generar/{id}', 'CostController@generar')->name('vecGenerar');
    Route::get('/vec/setmana/{id}/{setmana}', 'CostController@generarSetmana')->name('vecGenerarSetmana');
    Route::post('/vec/crear', 'CostController@insert')->name('vecInsert');
    Route::get('/vec/actualitzar/{id}/{setmana?}', 'CostController@actualitzar')->name('vecActualitzar');
    Route::get('/vec/modificar/{id}', 'CostController@updateView')->name('vecUpdateView');

    Route::post('/vec/esborrar', 'CostController@delete')->name('esborrarVec');
    
    Route::post('/vec/setPreuVenda', 'CostController@setPreuVenda')->name('setPreuVenda');
});

//------------------Rutes calendari------------------
Route::middleware(['role: 1,2,3,4,5'])->group(function () {
    Route::get('/calendari', 'CalendariController@showCalendari')->name('showCalendari');
    Route::get('/calendari/{year}/{week}', 'CalendariController@showCalendari')->name('showCalendariByDate');

    Route::get('/calendari/crear', 'CalendariController@createCalendari')->name('createCalendari');
    Route::post('/calendari/crear', 'CalendariController@create')->name('createCalendari');
    Route::post('/calendari/setDiaFestiu', 'CalendariController@setDiaFestiu')->name('setDiaFestiu');
    Route::post('/calendari/editar/{id}', "CalendariController@update")->name('updateCalendari');
    Route::post('/calendari/esborrar/{id}', 'CalendariController@delete')->name('deleteCalendari');

    Route::post('/calendari/cambiarCargo', 'CalendariController@cambiarCargo')->name('cambiarCargoCalendari');

    Route::post('/calendari/crearCalendariCarrecs', 'CalendariController@calendariCarrecInsertar')->name('createCalendariCarrecs');
    Route::put('/calendari/editarCalendariCarrecs/{id}', 'CalendariController@calendariCarrecEditar')->name('updateCalendariCarrecs');
    Route::post('/calendari/esborrarCalendariCarrecs/{id}', 'CalendariController@calendariCarrecDelete')->name('deleteCalendariCarrecs');
    
    Route::post('/calendari/cogerCalendarioActor', 'CalendariController@cogerCalendarioActor')->name('cogerCalendarioActor');
    Route::post('/calendari/postActors', 'CalendariController@postActors')->name('postActors');
    Route::post('/calendari/postDades', 'CalendariController@postDades')->name('postDades');
    Route::post('/calendari/actorsPerDia', 'CalendariController@actorsPerDia')->name('actorsPerDia');
    Route::get('/calendari/day', 'CalendariController@getDay')->name('getDay');
    
    Route::get('/calendari/getPeliculas', 'CalendariController@getPeliculas');
});
    
