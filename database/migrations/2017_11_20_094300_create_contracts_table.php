<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('contractor_id')->unsigned();
            $table->foreign('contractor_id')->references('id')->on('accounts');
            $table->integer('contractee_id')->unsigned();
            $table->foreign('contractee_id')->references('id')->on('accounts');
            $table->date('lifespan_start');
            $table->date('lifespan_end');
            $table->string('type');
            $table->string('structure', 1000);
            $table->double('maximum_amount');
            $table->double('holdback_amount');
            $table->string('mode_of_payment');
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
        Schema::dropIfExists('contracts');
    }
}
