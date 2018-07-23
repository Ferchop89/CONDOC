<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateAgunamNoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agunamNo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('corte_id');
            $table->text('descripcion')->nullable();
            $table->dateTime('encontrado_at')->nullable();
            $table->softDeletes();  // columna de soft-delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agunamNo');
    }
}
