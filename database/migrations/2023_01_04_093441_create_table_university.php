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

        Schema::create('university_level', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('university', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('university_level_id')->nullable();
            $table->foreign('university_level_id')->references('id')->on('university_level');

            $table->unsignedBigInteger('timezone_id')->nullable();
            $table->foreign('timezone_id')->references('id')->on('timezone');

            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('country');

            $table->string('name');
            $table->text('internal_comment')->nullable();

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
        Schema::dropIfExists('table_university');
    }
};
