<?php

use Illuminate\Database\Seeder;
use App\Models\Solicitud;
use App\Models\Corte;
use App\Models\AgunamNo;

class AgunamNoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $cantidad = 4; // cantidad de solicitudes
      $cortes = Corte::all();
      // Randomizamos y tomamos registros
      $aleatorias = $cortes->shuffle()->slice(0,$cantidad);
      // Agregamos los registros aleatorios a la tabla de agunamno
      foreach ($aleatorias as $corte) {
         $noUnam = new AgunamNo();
         $noUnam->corte_id = $corte->id;
         $noUnam->save();
      }
    }
}
