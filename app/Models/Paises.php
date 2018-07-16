<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model
{
    //
	protected $connection = 'condoc_old';

    protected $fillable = [
        'pais_cve',
        'pais_nombre',
    ];

}
