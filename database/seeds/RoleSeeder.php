<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
      public function run()
      {
         $Admin =    new Role();$Admin->nombre = 'Admin';$Admin->descripcion = 'Administrador';$Admin->save();
         $FacEsc =   new Role();$FacEsc->nombre = 'FacEsc';$FacEsc->descripcion = 'Facultad o Escuela';$FacEsc->save();
         $AgUnam =   new Role();$AgUnam->nombre = 'AgUnam';$AgUnam->descripcion = 'Archivo Gral. UNAM';$AgUnam->save();
         $Jud =      new Role();$Jud->nombre = 'Jud';$Jud->descripcion = 'DCerConDoc';$Jud->save();
         $Sria =     new Role();$Sria->nombre = 'Sria';$Sria->descripcion = 'DCerConDoc';$Sria->save();
         $JSecc =    new Role();$JSecc->nombre = 'JSecc';$JSecc->descripcion = 'DCerConDoc';$JSecc->save();
         $JArea =    new Role();$JArea->nombre = 'JArea';$JArea->descripcion = 'DCerConDoc';$JArea->save();
         $Ofnista03 =  new Role();$Ofnista03->nombre = 'Ofisi03';$Ofnista03->descripcion = 'DCerConDoc Ofi03';$Ofnista03->save();
         $Ofnista08 =  new Role();$Ofnista08->nombre = 'Ofisi08';$Ofnista08->descripcion = 'DCerConDoc Ofi08';$Ofnista08->save();
         $Invitado = new Role();$Invitado->nombre = 'Invit';$Invitado->descripcion = 'Invitado';$Invitado->save();
       }
}
