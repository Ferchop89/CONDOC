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

/* Ejemplo de ruta
Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/',function(){
  return view("auth.login");
});

Route::get('/usuarios','UserController@index')
      ->name('users');
// Route::get('/usuarios/detalles/{id}','UserController@show')
// hicimos un cambio y de ruta, pero como hacemos referencia por nombre, OK.
Route::get('/usuarios/{user}','UserController@show') // antes tenia id, pero como cambiamos esto en UserModuleTest por el Route Model Bindig
      ->where('user','[0-9]+')
      ->name('users.show');

Route::get('/usuarios/nuevo','UserController@create')
      ->name('users.create');

// Route::get('/usuarios/{user}/editar','UserController@edit')
//       ->name('users.edit');

Route::get('/usuarios/{user}/editar',[
  'uses'=> 'UserController@edit',
  'as'=> 'users.edit',
  'middleware' => 'roles',
  'roles' => ['FacEsc']
  ]);

Route::put('/usuarios/{user}','UserController@update');

// Route::post('/usuarios/crear','UserController@store'); / se pueden crear dos rutas con el mismo nombre si son get y post
Route::post('/usuarios','UserController@store');

Route::get('/saludo/{name}/{nickname?}','WelcomeUserController')
      ->name('users.nick');

Route::delete('/usuarios/{user}','UserController@destroy')
      ->name('users.destroy');

Route::get('/prueba','UserController@prueba')->name('prueba');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
