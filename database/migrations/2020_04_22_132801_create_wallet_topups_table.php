<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_topups', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('username');
            $table->string('paystack_ref')->nullable();
            $table->string('ref_number');
            $table->double('amount');
            $table->string('payment_method')->default("Online Payment");
            $table->string('status')->default("Initiated");
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
        Schema::dropIfExists('wallet_topups');
    }
}
