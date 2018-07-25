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
            ->select('listado_corte','listado_id')
            ->groupBy('listado_corte','listado_id')
            ->orderByRaw('CONCAT(SUBSTR(listado_corte,7,4),SUBSTR(listado_corte,4,2),SUBSTR(listado_corte,1,2),listado_id) asc')
            ->get()->toArray();
        foreach ($data as $value) {
            $regis = new Agunam();
            $regis->listado_corte = $value->listado_corte;
            $regis->listado_id    = $value->listado_id;
            $regis->user_id = 1;
            $regis->Solicitado_at = null;
            $regis->Recibido_at = null;
            $regis->save();
        }
    }
}
