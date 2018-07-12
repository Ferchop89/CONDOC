<?php

use Illuminate\Database\Seeder;
use App\Models\Corte;
use App\Models\Agunam;
use Illuminate\Support\Facades\Auth;

class AgunamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Agrupamiento y ordenamiento de cortes y listados
      $data = DB::table('cortes')
               ->selectRaw('CONCAT(SUBSTR(listado_corte,4,2),"/",SUBSTR(listado_corte,1,2),"/",SUBSTR(listado_corte,7,4),"-",Listado_id) as g_corte')
               ->groupBy('g_corte','listado_id')
               ->orderBy('g_corte')
               ->get()->toArray();
               // dd($data);
      foreach ($data as $value) {
          $regis = new Agunam();
          $corte_id = explode('-',$value->g_corte);
          $regis->listado_corte = $corte_id[0];
          $regis->listado_id    = $corte_id[1];
          $regis->user_id = 1;
          $regis->Solicitado_at = null;
          $regis->Recibido_at = null;
          $regis->save();
      }
      // dd($data);
    }
}
