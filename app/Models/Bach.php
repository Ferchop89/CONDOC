<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bach extends Model
{
    //
	protected $connection = 'condoc_old';

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
