<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registro_RE extends Model
{
    //
	protected $connection = 'mysql2';

	//protected $dates = ['expired_at'];

    protected $fillable = [
		'id_registro_re', 
		'actualizacion_nombre', 
		'actualizacion_fecha', 
		'jsec_nombre', 
		'jsec_fecha', 
		'jarea_nombre', 
		'jarea_fecha', 
		'jdepre_nombre', 
		'jdepre_fecha', 
		'jdeptit_nombre' , 
		'jdeptit_fecha', 
		'direccion_nombre', 
		'direccion_fecha', 
		'num_cta'
    ];

}
