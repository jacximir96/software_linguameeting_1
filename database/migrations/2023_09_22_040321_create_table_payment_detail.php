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

        Schema::create('payment_detail', function (Blueprint $table) {
            $table->id();

            $table->morphs('payable'); //curso, makeup..

            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('payment');

            $table->timestamps();
            $table->softDeletes();

        });


        $payments = \App\Src\PaymentDomain\Payment\Model\Payment::all();

        foreach ($payments as $payment){
            $detail = new \App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail();
            $detail->payable_type = $payment->payable_type;
            $detail->payable_id = $payment->payable_id;
            $detail->payment_id = $payment->id;
            $detail->save();
        }

        Schema::table('payment', function (Blueprint $databaseTable) {
            $databaseTable->dropColumn('payable_type');
            $databaseTable->dropColumn('payable_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_payment_detail');
    }
};
