<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $casts = [
      'is_active' => 'boolean',
    ];

    protected $fillable = [
        'name', 'username', 'email',  'password', 'is_active',
      ];

      protected $hidden = [
          'password', 'remember_token',
      ];

      public function roles()
      {
        return $this->belongsToMany(Role::class)->withTimestamps();
      }

    public function hasAnyRole($roles)
    {
      if (is_array($roles))
      {
          foreach ($roles as $role) {
            if($this->hasRole($role)){
              return true;}
          }
        } else
        {
            if($this->hasRole($roles)){
              return true;}
        }
        return false;
      }

    /**
    * Check one role
    * $param string $role
    */
    public function hasRole($role)
    {
      if($this->roles()->where('nombre',$role)->first()) {
        return true;
      }
      return false;
    }

}
