<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Firmas extends Model
{
    //Para bd local
	protected $connection = 'mysql2';

    protected $fillable = [
		'firm_cve', 
		'firm_nombre', 
		'firm_cargo', 
		'firm_cve_capt', 
		'firm_nivel', 
		'firm_ofic', 
		'firm_obs', 
		'firm_firma', 
		'firm_cve1',
    ];

}
