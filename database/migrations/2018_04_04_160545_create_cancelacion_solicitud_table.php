<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancelacionSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancelacion_solicitud', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('causa_id');
            $table->unsignedInteger('user_id');
            // Llaves foraneas
            $table->foreign('causa_id')->references('id')->on('causas_cancelacion');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cancelacion_solicitud');
    }
}
