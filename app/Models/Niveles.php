<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveles extends Model
{
    //
	protected $connection = 'mysql2';

    protected $fillable = [
		'id_nivel', 
		'nombre_nivel'
    ];

}