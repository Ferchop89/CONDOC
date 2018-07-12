<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nacionalidades extends Model
{
    //
	protected $connection = 'mysql2';

    protected $fillable = [
		'id_nacionalidad', 
		'nacionalidad'
    ];

}