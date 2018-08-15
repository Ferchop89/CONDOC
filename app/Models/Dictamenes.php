<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dictamenes extends Model
{
    //
	protected $connection = 'mysql2';

    protected $fillable = [
		'id_dictamen',
		'id_tramite',
		'fecha_solicitud',
		'id_oficina',
		'fecha_dictamen',
		'num_cta'
    ];

}