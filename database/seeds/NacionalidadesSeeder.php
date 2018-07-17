<?php

use Illuminate\Database\Seeder;
use App\Models\Nacionalidades as Nac;

class NacionalidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new Nac();
        $table->nacionalidad = 'MEXICANA';
        $table->save();

        $table = new Nac();
        $table->nacionalidad = 'NATURALIZADO';
        $table->save();

        $table = new Nac();
        $table->nacionalidad = 'EXTRANJERA';
        $table->save();
    }
}
