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
        Schema::create('replaced_coach', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('session_id');
            $table->foreign('session_id')->references('id')->on('session');

            $table->unsignedBigInteger('replaced_coach_id');
            $table->foreign('replaced_coach_id')->references('id')->on('user');

            $table->unsignedBigInteger('new_coach_id');
            $table->foreign('new_coach_id')->references('id')->on('user');

            $table->dateTime('replaced_at');

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
        Schema::dropIfExists('replaced_coach');
    }
};
