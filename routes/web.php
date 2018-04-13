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
      ->name('users')
      ->middleware('auth');

Route::get('/usuarios/{user}','UserController@show')
      ->where('user','[0-9]+')
      ->name('users.show');

Route::get('/usuarios/nuevo',[
  'uses'=> 'UserController@create',
  'as'=> 'users.create',
  'middleware' => 'roles',
  'roles' => ['Admin']
  ]);

  Route::get('/usuarios/{user}/editar',[
    'uses'=> 'UserController@edit',
    'as'=> 'users.edit',
    'middleware' => 'roles',
    'roles' => ['Admin']
    ]);

Route::put('/usuarios/{user}','UserController@update');

Route::post('/usuarios','UserController@store');


Route::delete('/usuarios/{user}',[
      'uses' => 'UserController@destroy',
      'as'   => 'users.destroy'
    ]);

Auth::routes();

Route::get('/home', [
  'uses' => 'HomeController@index',
  'as'   => 'home'
]);

Route::get('/FacEsc/consulta_re', 'FacEscController@index')->name('consulta_re');

Route::post('/FacEsc/consulta_re', 'FacEscController@store');

Route::get('/m1',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm1',
  'middleware' => 'roles',
  'roles' => ['FacEsc','Jud']
  ]);
Route::get('/m2',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm2',
  'middleware' => 'roles',
  'roles' => ['Jud','Sria','JSecc']
  ]);
Route::get('/m3',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm3',
  'middleware' => 'roles',
  'roles' => ['JArea','Ofisi','FacEsc']
  ]);
Route::get('/m4',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm4',
  'middleware' => 'roles',
  'roles' => ['Ofisi','AgUnam']
  ]);
Route::get('/m5',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm5',
  'middleware' => 'roles',
  'roles' => ['FacEsc','Jud','Sria']
  ]);
Route::get('/m6',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm6',
  'middleware' => 'roles',
  'roles' => ['JArea']
  ]);
Route::get('/m7',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm7',
  'middleware' => 'roles',
  'roles' => ['Jud','Sria','JSecc']
  ]);
Route::get('/m8',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm8',
  'middleware' => 'roles',
  'roles' => ['FacEsc','Ofisi']
  ]);
Route::get('/m9',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm9',
  'middleware' => 'roles',
  'roles' => ['Jud','Ofisi']
  ]);
