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
        Schema::create('canvas_user_key', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');

            $table->char('consumer_key');
            $table->char('consumer_secret');

            $table->boolean('active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('canvas_course', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('course');

            $table->bigInteger('canvas_course_id');
            $table->bigInteger('user_id');

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
        Schema::dropIfExists('canvas_user_key');
    }
};
