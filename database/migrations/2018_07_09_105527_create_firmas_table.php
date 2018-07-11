<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmas', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_spanish_ci';

            $table->text('firm_cve', 6);
            $table->text('firm_nombre')->nullable();
            $table->text('firm_cargo')->nullable();
            $table->text('firm_cve_capt', 6)->nullable();
            $table->text('firm_nivel', 2)->nullable();
            $table->text('firm_ofic', 2)->nullable();
            $table->text('firm_obs', 20)->nullable();
            $table->text('firm_cve1', 10)->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `firmas` ADD `firm_firma` LONGBLOB NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firmas');
    }
}
