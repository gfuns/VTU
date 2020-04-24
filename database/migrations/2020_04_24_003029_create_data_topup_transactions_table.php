<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTopupTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_topup_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('username');
            $table->string('ref_number');
            $table->string('biller');
            $table->string('biller_code');
            $table->double('dataplan_size');
            $table->string('data_plan');
            $table->double('buying_price');
            $table->double('amount');
            $table->string('number_recharged');
            $table->string('email')->nullable();
            $table->string('voucher_code')->nullable();
            $table->string('orderid')->nullable();
            $table->string('status_code')->nullable();
            $table->string('api_status')->nullable();
            $table->string('api_remark')->nullable();
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
        Schema::dropIfExists('data_topup_transactions');
    }
}
