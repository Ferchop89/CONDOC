<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model
{
    //
	protected $connection = 'mysql2';

    protected $fillable = [
        'pais_cve', 
        'pais_nombre',
    ];

}