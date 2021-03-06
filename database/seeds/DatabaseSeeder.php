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
          'users',
          'roles',
          'procedencias',
          'role_user',
          'menus'
      ]);
      // En este orden porque los roles deben existir antes que los usuarios
        $this->call(RoleSeeder::class);
        $this->call(ProcedenciaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MenuSeeder::class);
    }

    public function truncateTables(array $tables){
      DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
      foreach ($tables as $table) {
          DB::table($table)->truncate();
      }
      DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }

}
