<?php

use App\Models\Corte;
use App\Models\Solicitud;

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

Route::get('/FacEsc/solicitud_RE', 'RevEstudiosController@showSolicitudRE');
Route::post('/FacEsc/solicitud_RE', 'RevEstudiosController@postSolicitudRE');
Route::get('/FacEsc/solicitud_RE/{num_cta}', 'RevEstudiosController@showInfoSolicitudRE')
    ->where('num_cta','[0-9]+')
    ->name('solicitud_RE');



Route::get('/rev',[
    'uses'=> 'InformesController@Revisiones',
    'as'=> 'Rev',
    'middleware' => 'roles',
    'roles' => ['Admin']
    ]);
Route::get('trayectoria', 'UserController@showTrayectoria');

Route::put('/WS/trayectorias', 'Admin\WSController@trayectorias')->name('trayectoria');

Route::get('login', function(){
    return view('Auth/login');
})->name('login');

Route::get('recepcion', 'UserController@showrecepcionExpedientes')->name('recepcion');
Route::post('/recepcion-expedientes', 'UserController@post_numcta_Validate')->name('postRecepcion');

Route::get('/agregar_esc/{num_cta}', 'RevEstudiosController@showAgregarEsc')
  ->where('num_cta','[0-9]+')
  ->name('agregar_esc');
Route::post('/agregar_esc/{num_cta}', 'RevEstudiosController@validarInformacion')
  ->where('num_cta','[0-9]+')
  ->name('agregar_esc');

    // $encrypted = Crypt::encryptString('Hello world.');
    //
    // $decrypted = Crypt::decryptString($encrypted);
// });

//Route::get('/datos_personales', 'RevEstudiosController@showSolicitudNC');

//Route::post('/datos_personales', 'RevEstudiosController@postDatosPersonales');
Route::get('/c-c', function () {
    $users = DB::connection("mysql")->table("users")->get();
    dd($users);
});

Route::get('/c-c-2', function () {

    $sbs = DB::connection("mysql2")->table("paises")->where('pais_nombre', '=', 'AGUACALIENTES')->first();
    dd($sbs);
});

Route::get('/c-c-3', function () {
    $con = DB::connection("mysql2")->table("firmas")->get();
    dd($con);
});

// rutas de listas y cortes.

Route::get('/cortes',[
  'uses'=> 'InformesController@cortes',
  'as'=> 'cortes',
  'middleware' => 'roles',
  'roles' => ['Admin']
]);

Route::put('/creaListas',[
  'uses'=> 'InformesController@creaListas',
  'as'=> 'creaListas',
  'middleware' => 'roles',
  'roles' => ['Admin']
]);

Route::get('/listas',[
  'uses'=> 'ListadosController@listas',
  'as'=> 'listas',
  'middleware' => 'roles',
  'roles' => ['Admin']
]);

Route::get('solicitudes', function(){
  $data = DB::table('solicitudes')
           ->select(db::raw('DATE_FORMAT(created_at, "%d.%m.%Y") as listado_corte'),
             DB::raw('count(*) as total'))
           ->where('pasoACorte',false)
           ->where('cancelada',false)
           ->orderBy('created_at','asc')
           ->groupBy('listado_corte')
           ->pluck('total','listado_corte')->all();
  return $data;
});

Route::get('grupoListas', function(){
  $data = DB::table('cortes')
           ->select('listado_corte as corte',
                    DB::raw('count(*) as cuenta'),
                    DB::raw('count(DISTINCT listado_id) as listas'))
           ->groupBy('corte')
           ->get();
  return $data;
});

Route::get('fechaCorte',function(){
   $fCorte = Corte::all()->last()->listado_corte;
   return $fCorte;
});

Route::get('imprimePDF',[
  'uses'=> 'ListadosController@Pdfs',
  'as'=> 'imprimePDF',
  'middleware' => 'roles',
  'roles' => ['Admin']
]);

Route::get('pdf', 'PdfController@invoice');

Route::get('dropdowns',function(){
   return view('components/dropdowns');
 });

// Fin de rutas y cortes.
