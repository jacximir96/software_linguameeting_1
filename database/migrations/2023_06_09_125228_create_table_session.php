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
        Schema::create('session_status', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('session', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('course');

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->unsignedBigInteger('coach_session_status_id');
            $table->foreign('coach_session_status_id', 'coach_session_status')->references('id')->on('session_status');

            $table->unsignedBigInteger('timezone_id')->nullable();
            $table->foreign('timezone_id')->references('id')->on('timezone');
            $table->date('day');
            $table->time('start_time');
            $table->time('end_time');

            $table->boolean('is_blocked')->default(false);

            $table->text('comments')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('enrollment_session', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('session_id');
            $table->foreign('session_id')->references('id')->on('session');

            $table->unsignedBigInteger('enrollment_id');
            $table->foreign('enrollment_id')->references('id')->on('enrollment');

            $table->unsignedBigInteger('session_status_id');
            $table->foreign('session_status_id')->references('id')->on('session_status');

            $table->unsignedBigInteger('session_id_recovered')->nullable();
            $table->foreign('session_id_recovered')->references('id')->on('enrollment_session');

            $table->unsignedBigInteger('coaching_week_id');
            $table->foreign('coaching_week_id')->references('id')->on('coaching_week');

            $table->unsignedBigInteger('makeup_id')->nullable();
            $table->foreign('makeup_id')->references('id')->on('makeup');

            $table->unsignedBigInteger('extra_session_id')->nullable();
            $table->foreign('extra_session_id')->references('id')->on('extra_session');

            $table->unsignedBigInteger('timezone_id')->nullable();
            $table->foreign('timezone_id')->references('id')->on('timezone');
            $table->date('day');
            $table->time('start_time');
            $table->time('end_time');

            $table->smallInteger('session_order');

            $table->datetime('session_start')->nullable();
            $table->datetime('session_end')->nullable();

            $table->text('comments')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('session_start');
            $table->index('session_end');
            $table->index(['session_start', 'session_end']);

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollment_session');
        Schema::dropIfExists('coach_schedule_session');
        Schema::dropIfExists('session');
        Schema::dropIfExists('session_status');
    }
};
