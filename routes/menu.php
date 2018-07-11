<?php

use App\Models\Corte;

Route::get('/m4',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm4',
  'middleware' => 'roles',
  'roles' => ['Ofisi','AgUnam']
  ]);

Route::get('/m6',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm6',
  'middleware' => 'roles',
  'roles' => ['JArea']
  ]);

Route::get('/m8',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm8',
  'middleware' => 'roles',
  'roles' => ['FacEsc', 'Ofisi']
  ]);
Route::get('/m9',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm9',
  'middleware' => 'roles',
  'roles' => ['Jud','Ofisi']
  ]);

Route::get('/cortes',[
    'uses'=> 'InformesController@cortes',
    'as'=> 'cortes',
    'middleware' => 'roles',
    'roles' => ['Sria']
  ]);

Route::get('/listas',[
  'uses'=> 'ListadosController@listas',
  'as'=> 'listas',
  'middleware' => 'roles',
  'roles' => ['Sria']
  ]);

/*Revisiones de Estudio*/
Route::get('/datos-personales',[
    'uses'=> 'RevEstudiosController@showSolicitudNC',
    'as'=> 'datos-personales',
    'middleware' => 'roles',
    'roles' => ['Ofisi', 'JSecc', 'JArea', 'Jud', 'Sria'] //Jefe depto. títulos y dirección
]);
Route::post('/datos-personales',[
    'uses'=> 'RevEstudiosController@postDatosPersonales',
    'as'=> 'datos-personales',
    'middleware' => 'roles',
    'roles' => ['Ofisi', 'JSecc', 'JArea', 'Jud', 'Sria']
]);
Route::get('/rev_est/{num_cta}',[
    'uses'=> 'RevEstudiosController@showDatosPersonales',
    'middleware' => 'roles',
    'roles' => ['Ofisi', 'JSecc', 'JArea', 'Jud', 'Sria']
])->where('num_cta','[0-9]+')
  ->name('rev_est');

Route::post('/rev_est/{num_cta}',[
    'uses'=> 'RevEstudiosController@verificaDatosPersonales',
    'middleware' => 'roles',
    'roles' => ['Ofisi', 'JSecc', 'JArea', 'Jud', 'Sria']
])->where('num_cta','[0-9]+')
  ->name('rev_est_post');

/*Solicitud de Revisión de Estudios*/
    Route::get('/FacEsc/solicitud_RE', 'RevEstudiosController@showSolicitudRE');
    Route::post('/FacEsc/solicitud_RE', 'RevEstudiosController@postSolicitudRE');
    Route::get('/FacEsc/solicitud_RE/{num_cta}', 'RevEstudiosController@showInfoSolicitudRE')
        ->where('num_cta','[0-9]+')
        ->name('solicitud_RE');

/*Recepción de Expedientes por Alumno*/
Route::get('recepcion', [
  'uses' => 'UserController@showrecepcionExpedientes',
  'as' => 'recepcion',
  'middleware' => 'roles',
  'roles' => ['Sria']
]);
Route::post('/recepcion-expedientes', [
    'uses' => 'UserController@post_numcta_Validate',
    'as' => 'postRecepcion',
    'middleware' => 'roles',
    'roles' => ['Sria']
]);
