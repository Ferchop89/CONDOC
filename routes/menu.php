<?php

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
  'roles' => ['Sria','JArea','Ofisi','FacEsc']
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
  'roles' => ['FacEsc', 'Ofisi']
  ]);
Route::get('/m9',[
  'uses'=> 'RutasController@Menu1',
  'as'=> 'm9',
  'middleware' => 'roles',
  'roles' => ['Jud','Ofisi']
  ]);
Route::get('/datos_personales',[
  'uses'=> 'RevEstudiosController@showSolicitudNC',
  'as'=> 'datos_personales',
  'middleware' => 'roles',
  'roles' => ['Ofisi']
  ]);
Route::post('/datos_personales',[
  'uses'=> 'RevEstudiosController@postDatosPersonales',
  'as'=> 'datos_personales',
  'middleware' => 'roles',
  'roles' => ['Ofisi']
  ]);
/*Route::get('/rev_est',[
  'uses'=> 'RevEstudiosController@showDatosPersonales',
  'middleware' => 'roles',
  'roles' => ['Ofisi']
  ]);
Route::post('/rev_est',[
  'uses'=> 'RevEstudiosController@verificaDatosPersonales',
  'middleware' => 'roles',
  'roles' => ['Ofisi']
  ]);
*/