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
		'folio_certificado',
		'seleccion_fecha',
		'mes_anio',
		'inicio_periodo',
		'fin_periodo',
		'promedio',
		'pais_cve', 
		'num_cta',
		'irre_cert'
    ];

}