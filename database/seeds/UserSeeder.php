<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Procedencia;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          // Los usuarios de dan de alta en el Solicitud Seeder  en este procedimiento se asigna roles.
          // Agregamos tantos usuarios como procedencias

          // Usuario patrón administrador
          $user = User::find(1);
          // Asignamos el role de Admin al prime registro
          $role=Role::where('nombre','Admin')->first();
          $user->roles()->attach($role);

          // Arreglo de Roles
          $roles   = Role::all()->pluck('id')->toArray();

          // Asigmanos el role Facesc a los que no son de procedencia 1001 (Revison de Estudios)
          $users = User::all();
          $role = Role::where('nombre','FacEsc')->first();
          foreach ($users as $user) {
              if ($user->procedencia_id != '1001') {
                  $user->roles()->attach($role);
              }
          }
          // Arreglo con larga de roles descartamos Admin, FacEsc.
          $roles_w = [3,3,
                    4,4,
                    5,5,
                    6,6,6,6,6,6,
                    7,7,7,7,7,7,7,7,7,7,7,7,7,
                    8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,
                    9];
        // Les agregamos hasta cinco roles de forma aleatoria
        for ($i=0; $i < 2 ; $i++) {
            $users = User::all();
            foreach ($users as $user) {
                $RandRole = $roles_w[rand(0,count($roles_w)-1)];
                if ($user->roles()->where('role_id',$RandRole)->count()===0 && rand(0,1) ){
                    $user->roles()->attach($RandRole);
                }
            }
        }
    }
}
