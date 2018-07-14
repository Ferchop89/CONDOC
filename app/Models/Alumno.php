<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    //
	protected $connection = 'mysql2';

    protected $fillable = [
		'num_cta', 
		'curp',
		'foto', 
		'nombre_alumno', 
		'primer_apellido', 
		'segundo_apellido', 
		'sexo', 
		'fecha_nacimiento',  
		'id_nacionalidad', 
		'pais_cve',
		'sistema',
		'irre_act',
		'sistema'
    ];
    
}