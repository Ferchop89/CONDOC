<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
          'web_services',
          'procedencias',
          'solicitudes',
          'cancelacion_solicitud',
          'causas_cancelacion',
          'roles',
          'users',
          'role_user',
          'menus',
          'irregularidades_r_es',
          'cortes',
          'agunam',
          'agunam_no',
          // 'firmas'
      ]);
      // En este orden porque los roles deben existir antes que los usuarios
        $this->call(Web_Service_Seeder::class);
        $this->call(ProcedenciaSeeder::class);
        $this->call(CausasCancelacionSeeder::class);
        $this->call(SolicitudSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(IrregularidadesRESeeder::class);
        $this->call(CorteSeeder::class);
        $this->call(AgunamSeeder::class);
        $this->call(AgunamNoSeeder::class);
        // $this->call(FirmasRESeeder::class);
    }

    public function truncateTables(array $tables){
      DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
      foreach ($tables as $table) {
          DB::table($table)->truncate();
      }
      DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
