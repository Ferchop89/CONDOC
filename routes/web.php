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
Auth::routes();

Route::get('/', 'UserController@index');

Route::get('/home', [
  'uses' => 'UserController@home',
  'as'   => 'home'
]);

Route::get('/FacEsc/solicitud_RE', 'FacEscController@showSolicitudRE');
Route::post('/FacEsc/solicitud_RE', 'FacEscController@postSolicitudRE');
Route::get('/FacEsc/solicitud_RE/{num_cta}', 'FacEscController@showInfoSolicitudRE')
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

Route::get('/recepcion-expedientes', 'UserController@showrecepcionExpedientes')->name('Recepcion.Expedientes');

    // $encrypted = Crypt::encryptString('Hello world.');
    //
    // $decrypted = Crypt::decryptString($encrypted);
// });
