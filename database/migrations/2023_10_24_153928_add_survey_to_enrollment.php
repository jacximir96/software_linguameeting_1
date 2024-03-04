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
        Schema::table('enrollment', function (Blueprint $table) {
            Schema::create('enrollment_survey', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('enrollment_id');
                $table->foreign('enrollment_id')->references('id')->on('enrollment');

                $table->unsignedBigInteger('survey_id')->nullable();
                $table->foreign('survey_id')->references('id')->on('survey');

                $table->datetime('surveyed_at');

                $table->timestamps();
                $table->softDeletes();

            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enrollment', function (Blueprint $table) {
            //
        });
    }
};
