<?php

use Illuminate\Database\Seeder;
use App\Models\Tramites;

class TramitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = new Tramites();
      $table->nombre_tramite = 'Corrección dígito';
      $table->save();

      $table = new Tramites();
      $table->nombre_tramite = 'Alta carrera';
      $table->save();

      $table = new Tramites();
      $table->nombre_tramite = 'Corrección nombre';
      $table->save();

      $table = new Tramites();
      $table->nombre_tramite = 'Corrección no. de cuenta';
      $table->save();

      $table = new Tramites();
      $table->nombre_tramite = 'Cambio de carrera';
      $table->save();

      $table = new Tramites();
      $table->nombre_tramite = 'Validar';
      $table->save();

      $table = new Tramites();
      $table->nombre_tramite = 'Corrección dato';
      $table->save();

      $table = new Tramites();
      $table->nombre_tramite = 'Oficio dcto.';
      $table->save();
    }
}
