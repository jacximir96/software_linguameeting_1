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
        Schema::create('coach_schedule', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->unsignedBigInteger('timezone_id')->nullable();
            $table->foreign('timezone_id')->references('id')->on('timezone');

            $table->unsignedBigInteger('session_id')->nullable();
            $table->foreign('session_id', 'coach_schedule_session_sess')->references('id')->on('session');

            $table->date('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('day_of_week');

            $table->boolean('blocked_ses')->default(false);

            //$table->boolean('blocked_ses')->default(false);

            /*
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('course');

            $table->boolean('actual_occ')->default(false);
            $table->smallInteger('occ_max')->default(0);
            $table->boolean('attended')->default(false);
            */

            $table->timestamps();
            $table->softDeletes();

            $table->index(['coach_id', 'day']);
            $table->index('day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coach_schedule');
    }
};
