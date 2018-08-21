<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('cuenta');
            $table->text('nombre');
            $table->string('CURP', 20)->nullable();
            $table->date('fecha_nac');
            $table->string('genero', 20);
            $table->string('nivel', 1);
            $table->string('generacion', 5);
            $table->unsignedDecimal('avance',8,2);
            $table->unsignedInteger('plantel_id');
            $table->unsignedInteger('carrera_id');
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('tipo');
            $table->boolean('citatorio')->defaul(false);
            $table->boolean('pasoACorte')->default(false);
            $table->boolean('cancelada')->default(false);
            $table->unsignedInteger('cancelada_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->string('sistema', 20);

            $table->timestamps();
            // Llaves foraneas
            $table->index(['pasoACorte']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cancelada_id')->references('id')->on('cancelacion_solicitud');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudes', function(Blueprint $table){
            $table->dropForeign([
              'user_id',
            ]);
        });
        Schema::dropIfExists('solicitudes');
    }
}
