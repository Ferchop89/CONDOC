<?php

use Illuminate\Database\Seeder;
use App\Models\{CancelacionSolicitud, User}

class CancelacionSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::count();

        $table = new CancelacionSolicitud();
        $table->causa_id = rand(1,2);
        $table->user_id = rand(1, $users);
        $table->save();

    }
}
