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
        /*
        Schema::create('accommodation', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('enrollment_id');
            $table->foreign('enrollment_id')->references('id')->on('enrollment');

            $table->text('description');

            $table->timestamps();
            $table->softDeletes();

        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('accommodation');
    }
};
