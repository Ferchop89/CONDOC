<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveles extends Model
{
    //
	protected $connection = 'condoc_old';

    protected $fillable = [
		'id_nivel',
		'nombre_nivel'
    ];

}
