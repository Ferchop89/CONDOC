<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trayectoria extends Model
{
    //
	protected $connection = 'condoc_old';

    protected $fillable = [
		'id_trayectoria',
		'generacion',
		'num_planestudios',
		'nombre_planestudios',
		'num_cta',
		'avance_creditos',
		'cumple_requisitos',
		'id_nivel',
    ];

}
