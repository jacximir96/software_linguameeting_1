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
        Schema::create('payment_refund', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('payment');

            $table->integer('amount_value')->nullable();
            $table->string('currency_value', 3)->nullable();

            $table->string('transaction_id');
            $table->datetime('refund_at');
            $table->unsignedBigInteger('timezone_id')->nullable();
            $table->foreign('timezone_id')->references('id')->on('timezone');

            $table->timestamps();
            $table->softDeletes();

            $table->index('transaction_id');
            $table->index('refund_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_payment_refund');
    }
};
