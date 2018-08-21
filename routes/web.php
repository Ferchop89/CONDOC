<?php

use App\Models\Corte;
use App\Models\Solicitud;
use App\Models\AgunamNo;
use App\Http\Controllers\Admin\WSController;
use App\Models\Web_Service;
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
Auth::routes();

Route::get('/', 'UserController@index');

Route::get('/home', [
  'uses' => 'UserController@home',
  'as'   => 'home'
]);

Route::get('/rev',[
    'uses'=> 'InformesController@Revisiones',
    'as'=> 'Rev',
    'middleware' => 'roles',
    'roles' => ['Admin']
    ]);
Route::get('trayectoria', 'UserController@showTrayectoria');

Route::put('/WS/trayectorias', 'Admin\WSController@trayectorias')->name('trayectoria');

Route::get('login', function(){
    return view('auth/login');
})->name('login');

Route::get('recepcion', 'UserController@showrecepcionExpedientes')->name('recepcion');
Route::post('/recepcion-expedientes', 'UserController@post_numcta_Validate')->name('postRecepcion');

//Agregar escuela
Route::get('/agregar_esc/{num_cta}', 'RevEstudiosController@showAgregarEsc')
  ->where('num_cta','[0-9]+')
  ->name('agregar_esc');
Route::post('/agregar_esc/{num_cta}', 'RevEstudiosController@validarInformacion')
  ->where('num_cta','[0-9]+')
  ->name('agregar_esc');

//Quitar escuela
Route::get('/quitar_esc/{num_cta}', 'RevEstudiosController@showQuitarEsc')
  ->where('num_cta','[0-9]+')
  ->name('quitar_esc');
Route::post('/quitar_esc/{num_cta}', 'RevEstudiosController@validarQuitarInformacion')
  ->where('num_cta','[0-9]+')
  ->name('quitar_esc');

// Rutas de prueba para conexión a segunda BD local
Route::get('/c-c', function () {
    $users = DB::connection("mysql")->table("users")->get();
    dd($users);
});
Route::get('/c-c-2', function () {

    $sbs = DB::connection("mysql2")->table("paises")->where('pais_nombre', '=', 'AGUACALIENTES')->first();
    dd($sbs);
});

Route::get('/c-c-3', function () {
    $con = DB::connection("mysql2")->table("trayectorias")->get();
    dd($con);
});

Route::get('/prueba/{num_cta}', 'RevEstudiosController@prueba')
  ->where('num_cta','[0-9]+')
  ->name('prueba');

Route::get('prueba/menu', 'PruebasController@prueba');