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

        Schema::table('coach_billing_info', function (Blueprint $table) {
            $table->text('paid_info')->nullable()->after('route_number');
        });



        Schema::create('coach_invoice', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->integer('number');
            $table->date('date');
            $table->tinyInteger('month');
            $table->smallInteger('year');
            $table->string('currency', 3);

            $table->text('info_from');
            $table->text('info_to');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coach_invoice_detail', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('coach_invoice');

            $table->string('description');
            $table->tinyInteger('quantity');
            $table->integer('amount_unit_price');
            $table->string('currency_unit_price', 3);
            $table->boolean('is_payer')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('config', function (Blueprint $table) {
            $table->id();

            $table->text('paid_info');

            $table->timestamps();
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coach_invoice_detail');
        Schema::dropIfExists('coach_invoice');
    }
};
