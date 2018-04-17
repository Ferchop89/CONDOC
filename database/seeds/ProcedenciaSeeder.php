<?php

use Illuminate\Database\Seeder;
use App\Models\Procedencia;

class ProcedenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // factory(Procedencia::class,5)->create();
     $Admin = new Procedencia();   $Admin->procedencia =    'Administrador';$Admin->save();
     $FacEsc = new Procedencia();  $FacEsc->procedencia =   'Facultad o Escuela';$FacEsc->save();
     $AgUnam = new Procedencia();  $AgUnam->procedencia =   'Archivo Gral. UNAM';$AgUnam->save();
     $Jud = new Procedencia();     $Jud->procedencia =      'DCERCONDOC';$Jud->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Invitado';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Escuela 1';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Escuela 2';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Escuela 3';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Escuela 4';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Escuela 5';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Escuela 6';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Escuela 7';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Facultad 1';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Facultad 2';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Facultad 3';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Facultad 4';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Facultad 5';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Facultad 6';$Invitado->save();
     $Invitado = new Procedencia();$Invitado->procedencia = 'Facultad 7';$Invitado->save();
    }
}
