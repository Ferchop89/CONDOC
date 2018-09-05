<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tramites extends Model
{
    protected $table = 'tramites';
    //
    protected $fillable = [
		'id_tramite',
		'nombre_tramite'
    ];

}
