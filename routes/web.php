<?php

use App\Models\Corte;
use App\Models\Solicitud;
use App\Models\AgunamNo;
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
  'roles' => ['Sria']
]);

// Route::get('/listas',[
//   'uses'=> 'ListadosController@listas',
//   'as'=> 'listas',
//   'middleware' => 'roles',
//   'roles' => ['Sria']
// ]);

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
  'roles' => ['Sria']
]);

Route::get('dropdowns',function(){
   return view('components/dropdowns');
 });

// Fin de rutas y cortes.
// Gestion de Listas AGUNAM -- INICIO
Route::get('agunam',[
  'uses'=> 'ListadosController@gestionAgunam',
  'as'=> 'gestion_agUnam',
  'middleware' => 'roles',
  'roles' => ['Admin','Sria']
]);
Route::get('agunamUpdate/{corte}/{listado}',[
  'uses'=> 'ListadosController@agunamUpdate',
  'as'=> 'agunamUpdate',
  'middleware' => 'roles',
  'roles' => ['Admin','Sria']
]);
Route::put('agunamUpdateOk',[
  'uses'=> 'ListadosController@agunamUpdateOk',
  'as'=> 'agunamUpdateOk',
  'middleware' => 'roles',
  'roles' => ['Admin','Sria']
]);
// Gestion de listas AGUNAM -- FIN

// Gestion de expedientes no encontrados en agunam
Route::get('agunam/lista_noagunam',[
    'uses' => 'AgunamNoController@expedientes',
    'as' => 'agunam/expedientes',
    'roles' => ['Admin']
]);//->name('users');

Route::get('agunam/{expediente}/editar', [
    'uses' => 'AgunamNoController@editar_noagunam',
    'as' => 'editar_noagunam',
    'roles' => ['Admin']
    ])->where('exped','[0-9]+');

Route::get('agunam/{expediente}/ver', [
    'uses' => 'AgunamNoController@ver_noagunam',
    'as' => 'ver_noagunam',
    'roles' => ['Admin']
    ])->where('exped','[0-9]+');

Route::put('agunam/alta', [
    'uses' => 'AgunamNoController@alta_noagunam',
    'as' => 'alta_noagunam',
    'roles' => ['Admin']
    ]);

Route::put('agunam/{expediente}/salvar', [
    'uses' => 'AgunamNoController@salvar_noagunam',
    'as' => 'salvar_noagunam',
    'roles' => ['Admin']
    ])->where('expediente','[0-9]+');

Route::delete('agunam/{expediente}}/borrar' ,[
    'uses'=> 'AgunamNoController@eliminar_noagunam',
    'as' => 'eliminar_noagunam',
    'roles' => ['Admin']
  ]);
// Fin Gestion de expedientes no encontrados.

// graficos
Route::get('graficas' ,[
    'uses'=> 'GrafiController@diario',
    'as' => 'grafico',
    'roles' => ['Admin']
  ]);
// fin graficos
