<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgunamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agunam', function (Blueprint $table) {
            $table->increments('id');
            $table->char('listado_corte',10);
            $table->unsignedInteger('listado_id');
            $table->unsignedInteger('user_id');
            $table->dateTime('Solicitado_at')->nullable();
            $table->dateTime('Recibido_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agunam');
    }
}
