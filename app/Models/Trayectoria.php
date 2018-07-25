<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trayectoria extends Model
{
    //
	protected $connection = 'mysql2';

    protected $fillable = [
		'id_trayectoria', 
		'generacion', 
		'num_planestudios', 
		'nombre_planestudios', 
		'num_cta',
		'avance_creditos',
		'cumple_requisitos',
		'id_nivel',
		'nombre_carrera'
    ];

}
