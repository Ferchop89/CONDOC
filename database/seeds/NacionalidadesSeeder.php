<?php

use Illuminate\Database\Seeder;
use App\Models\Nacionalidades;

class NacionalidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = new Nacionalidades();
      $table->nacionalidad = 'MEXICANA';
      $table->save();

      $table = new Nacionalidades();
      $table->nacionalidad = 'NATURALIZADO';
      $table->save();

      $table = new Nacionalidades();
      $table->nacionalidad = 'EXTRANJERA';
      $table->save();
    }
}
