<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bach extends Model
{
    //
	protected $connection = 'mysql2';

    protected $fillable = [
        'ncta', 
        'per', 
        'prom', 
        'cve', 
        'nom', 
        'ubic', 
        'tipo',  
        'marca',
    ];

}
