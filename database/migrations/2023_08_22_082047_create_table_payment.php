<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();

            $table->morphs('payable'); //curso, makeup..

            $table->unsignedBigInteger('payer_id')->nullable();
            $table->foreign('payer_id')->references('id')->on('user');

            $table->unsignedBigInteger('payer_public_id')->nullable();
            $table->foreign('payer_public_id')->references('id')->on('user_public');

            $table->unsignedBigInteger('method_payment_id');
            $table->foreign('method_payment_id')->references('id')->on('method_payment');

            $table->unsignedBigInteger('register_code_id')->nullable();
            $table->foreign('register_code_id')->references('id')->on('register_code');

            $table->integer('amount_value')->nullable();
            $table->string('currency_value', 3)->nullable();

            $table->string('transaction_id');
            $table->datetime('paid_at');
            $table->unsignedBigInteger('timezone_id');
            $table->foreign('timezone_id')->references('id')->on('timezone');

            $table->string('email');

            $table->timestamps();
            $table->softDeletes();

            $table->index('transaction_id');
            $table->index('paid_at');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
};
