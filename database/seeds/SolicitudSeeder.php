<?php

use Illuminate\Database\Seeder;
use App\Models\Solicitud;
use App\Models\User;
use Carbon\Carbon;

class SolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Agrega desde el inicio de 2018 hasta el dia actual, de 8 hasta las 19 horas 150 solicitudes cada 1, 2, o tres minutos
        // factory(Solicitud::class,10)->create();
        $ctaUsuarios = user::all()->count();
        $inicio = Carbon::create(2018, 4, 1, 0, 0, 0, 'America/Mexico_City');
        for ($i=0; $i < $inicio->diffIndays(Carbon::now()) ; $i++) {
            if ( !($inicio->isSaturday() or $inicio->isSunday()) ) {
              $laburo = $inicio;
              $laburo->addHours(8);
              for ($y=0; $y < 50; $y++) {
                  if ($inicio->diffInHours($laburo)<18) {
                     $laburo->addMinutes(rand(1,3));
                     $sol_rev = new Solicitud();
                     $xcuenta = '';for ($i = 0; $i<9; $i++) { $xcuenta .= mt_rand(0,9);}
                     $sol_rev->cuenta = $xcuenta;
                     $sol_rev->user_id = rand(1,$ctaUsuarios);
                     $sol_rev->status_id = rand(1,4);
                     $sol_rev->created_at = $laburo;
                     $sol_rev->updated_at = $laburo;
                     $sol_rev->save();
                  }
                }
            }
            $inicio->addDays(1);
        }
    }
}
