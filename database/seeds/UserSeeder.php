<?php

use App\Models\User;
use App\Models\Role;
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
          // Usuario patrón
          $user= new User();
          $user->name = 'Administrador';
          $user->username = 'Administrador';
          $user->email = 'Admon@correo.com';
          $user->password = bcrypt('111111');
          $user->is_active = true;
          $user->save();
          // $role=Role::where('nombre',['Admin'])->first();
          $role=Role::where('nombre','Admin')->first();
          $user->roles()->attach($role);

          // Agregamos 10 usuarios fake
          factory(User::class,50)->create();
          // Les agregamos roles de forma aleatoria
          for ($i=0; $i < 5 ; $i++) {
            $users = User::all();
            foreach ($users as $user) {
              $RandRole = rand(1,9);
              if ($user->roles()->where('role_id',$RandRole)->count()===0 && rand(0,1) ){
                $user->roles()->attach($RandRole);
              }
            }
          }

          // $user->roles()->attach($role_Invitado);
          // factory(User::class)->create();
    }
}
