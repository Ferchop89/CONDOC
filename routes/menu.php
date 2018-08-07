<?php

use App\Models\Corte;
use App\Models\Solicitud;
use App\Models\AgunamNo;

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
  'roles' => ['FacEsc', 'Ofisi', 'Sria']
  ]);
Route::get('/m9',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm9',
  'middleware' => 'roles',
  'roles' => ['Jud','Ofisi']
  ]);

/* Rutas de listas y cortes.*/
Route::get('/cortes',[
    'uses'=> 'InformesController@cortes',
    'as'=> 'cortes',
    'middleware' => 'roles',
    'roles' => ['Sria', 'Admin']
  ]);

Route::get('/cortesV',[
    'uses'=> 'InformesController@cortesVista',
    'as'=> 'cortesV',
    'middleware' => 'roles',
    'roles' => ['Sria','Admin']
  ]);

Route::put('/creaListas',[
    'uses'=> 'InformesController@creaListas',
    'as'=> 'creaListas',
    'middleware' => 'roles',
    'roles' => ['Sria']
    ]);

Route::get('/listas',[
  'uses'=> 'ListadosController@listas',
  'as'=> 'listas',
  'middleware' => 'roles',
  'roles' => ['Sria']
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
  /*Impresión de Listas*/
  Route::get('imprimePDF',[
    'uses'=> 'ListadosController@Pdfs',
    'as'=> 'imprimePDF',
    'middleware' => 'roles',
    'roles' => ['Sria']
  ]);
  /*Impresión de Vales*/
  Route::get('imprimeVale',[
    'uses'=> 'ListadosController@Vales',
    'as'=> 'imprimeVale',
    'middleware' => 'roles',
    'roles' => ['Sria']
  ]);
  /*Impresión de Etiquetas*/
  Route::get('imprimeEtiqueta',[
    'uses'=> 'ListadosController@Etiquetas',
    'as'=> 'imprimeEtiqueta',
    'middleware' => 'roles',
    'roles' => ['Sria']
  ]);
 // Fin de rutas y cortes.
/*Revisiones de Estudio*/
Route::get('/datos-personales',[
    'uses'=> 'RevEstudiosController@showSolicitudNC',
    'as'=> 'datos-personales',
    'middleware' => 'roles',
    'roles' => ['Ofisi', 'Sria']
]);
Route::post('/datos-personales',[
    'uses'=> 'RevEstudiosController@postDatosPersonales',
    'as'=> 'datos-personales',
    'middleware' => 'roles',
    'roles' => ['Ofisi', 'Sria']
]);
Route::get('/rev_est/{num_cta}',[
    'uses'=> 'RevEstudiosController@showDatosPersonales',
    'middleware' => 'roles',
    'roles' => ['Ofisi', 'Sria']
])->where('num_cta','[0-9]+')
  ->name('rev_est');
Route::post('/rev_est/{num_cta}',[
    'uses'=> 'RevEstudiosController@verificaDatosPersonales',
    'middleware' => 'roles',
    'roles' => ['Ofisi', 'Sria']
])->where('num_cta','[0-9]+')
  ->name('rev_est_post');

/*Solicitud de Revisión de Estudios*/
Route::get('/facesc/solicitud_RE', [
  'uses' => 'SolicitudController@showSolicitudRE',
  'as' => 'FacEsc/solicitud_RE',
  'middleware' => 'roles',
  'roles' => ['FacEsc','Admin']
]);

Route::post('/facesc/solicitud_RE', 'SolicitudController@postSolicitudRE');

Route::get('/facesc/solicitud_RE/{num_cta}', 'SolicitudController@showInfoSolicitudRE')
        ->where('num_cta','[0-9]+')
        ->name('solicitud_RE');

Route::post('/facesc/solicitud_RE/{num_cta}/solicita', 'SolicitudController@createSolicitud')
        ->where('num_cta','[0-9]+')
        ->name('solicita_RE');

Route::get('/facesc/solicitud_RE/{num_cta}/cancelacion', 'SolicitudController@cancelSolicitud')
                ->where('num_cta','[0-9]+')
                ->name('cancela_RE');
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
// Gestion de Listas AGUNAM -- INICIO
Route::get('AGUNAM',[
  'uses'=> 'ListadosController@gestionAgunam',
  'as'=> 'AGUNAM',
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
Route::get('agunam/expedientes_noagunam',[
    'uses' => 'AgunamNoController@expedientes',
    'as' => 'agunam/expedientes_noagunam',
    'roles' => ['Admin', 'Sria']
]);//->name('users');

Route::get('agunam/{expediente}/editar', [
    'uses' => 'AgunamNoController@editar_noagunam',
    'as' => 'editar_noagunam',
    'roles' => ['Admin', 'Sria']
    ])->where('exped','[0-9]+');

Route::get('agunam/{expediente}/ver', [
    'uses' => 'AgunamNoController@ver_noagunam',
    'as' => 'ver_noagunam',
    'roles' => ['Admin']
    ])->where('exped','[0-9]+');

Route::put('agunam/alta', [
    'uses' => 'AgunamNoController@alta_noagunam',
    'as' => 'alta_noagunam',
    'roles' => ['Admin', 'Sria']
    ]);

Route::put('agunam/{expediente}/salvar', [
    'uses' => 'AgunamNoController@salvar_noagunam',
    'as' => 'salvar_noagunam',
    'roles' => ['Admin', 'Sria']
    ])->where('expediente','[0-9]+');

Route::delete('agunam/{expediente}}/borrar' ,[
    'uses'=> 'AgunamNoController@eliminar_noagunam',
    'as' => 'eliminar_noagunam',
    'roles' => ['Admin', 'Sria']
  ]);
// Fin Gestion de expedientes no encontrados.
// Route::get('/m4',[
//   'uses'=> 'RutasController@Menu1',
//   'as'=> 'm4',
//   'middleware' => 'roles',
//   'roles' => ['Admin','AgUnam']
//   ]);
/*Tablero de Control*/
Route::get('graficas' ,[
    'uses'=> 'GrafiController@solicitudes',
    'as' => 'graficas',
    'roles' => ['Admin']
]);
/*Fin de Tablero de Control*/

/*Ruta de trazabilidad una o varias solicitudes*/
Route::get('traza' ,[
    'uses'=> 'TrazabilidadController@traza',
    'as' => 'traza',
    'roles' => ['Admin','Sria']
]);

/*Ruta de trazabilidad detalle por solicitud*/
Route::get('trazabilidad/{cuenta}/{carrera}/{plan}' ,[
    'uses'=> 'TrazabilidadController@TrazaConsulta',
    'as' => 'trazabilidad',
    'roles' => ['Admin','Sria']
]);
/*Fin uta trazabilidad*/
