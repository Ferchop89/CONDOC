<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Esc_Proc extends Model
{
    //
	protected $connection = 'mysql2';

    protected $fillable = [
		'id_esc_proc',
		'nombre_escproc',
		'nivel',
		'clave',
		'seleccion_fecha',
		'mes_anio',
		'inicio_periodo',
		'fin_periodo',
		'promedio',
		'num_cta',
		'irre_cert',
		'folio_cert',
		'sistema_escuela'
    ];

}
