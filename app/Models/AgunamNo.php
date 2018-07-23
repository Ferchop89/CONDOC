<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgunamNo extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];
  protected $table = 'agunamno';
  public $timestamps = false;

  protected $fillable = [
    'solicitud_id', 'descripcion',
  ];

  public function corte()
  {
      return $this->hasOne('App\Models\Corte','id','corte_id');
  }
  public function solicitud(){
    return $this->querySolicitud();
  }

}
