<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->double('amount_paid')->default(0.00);
            $table->double('total_amount')->default(0.00);
            $table->double('total_amount_cancelled')->default(0.00);
            $table->string('payment_method')->default('Cash on Delivery');
            $table->string('delivery_status')->default('Pending');
            $table->timestamp('datetime_delivered')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
