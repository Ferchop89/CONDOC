<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgunamNo extends Model
{
  use SoftDeletes;
  
  protected $dates = ['deleted_at'];
  protected $table = 'agunamno';
  public $timestamps = false;
  protected $casts = [
    'encontrado' => 'boolean'
  ];

  protected $fillable = [
    'solicitud_id', 'descripcion', 'encontrado',
  ];

  public function corte()
  {
      return $this->hasOne('App\Models\Corte','id','corte_id');
  }

}
