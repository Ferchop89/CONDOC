<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // public function  users(){
    //   this->belongsToMany('App\Models\User','user_role','role_id','user_id');
    // }
    protected $fillable = [
      'nombre',
      'descripcion',
      ];
      public function users()
      {
          return $this->belongsToMany('Users');
      }

      public function procedencias()
      {
          return $this-hasMany('procedencias');
      }

}
