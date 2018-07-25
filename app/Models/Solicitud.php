<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $primary_key = 'solicitud_id';
    protected $casts = [
      'pasoACorte' => 'boolean',
      'citatorio' => 'boolean',
      'cancelada' => 'boolean'
    ];

    public function procedencias(){
      // recupara las procedencias para un tipo de solicitud
      return $this->hasManyThrough(
        'App\Models\Procedencia',   // modelo final
        'App\Models\User',          // modelo intermedio
        'id',
        'id'
      );
    }

    public function NoAgunam(){
      return $this->hasManyThrough(
        'App\Models\AgunamNo',
        'App\Models\Corte',
        'solicitud_id',
        'corte_id'
      );
    }

    public function CorteLista(){
      return $this->hasOne('App\Models\Corte');
    }
}
