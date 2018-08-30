<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tramites', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_spanish_ci';

            $table->increments('id_tramite');
            $table->string('nombre_tramite')->nullable();
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
        Schema::dropIfExists('tramites');
    }
}
