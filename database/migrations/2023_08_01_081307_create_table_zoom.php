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
        Schema::create('zoom_user', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id'); //only for coach
            $table->foreign('user_id')->references('id')->on('user');

            $table->string('host_id')->nullable();
            $table->string('user_zoom_id');
            $table->string('zoom_email');
            $table->string('pmi')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('user_zoom_id');
            $table->index('zoom_email');
        });


        Schema::create('zoom_meeting', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id'); //only for coach
            $table->foreign('user_id')->references('id')->on('user');

            $table->string('zoom_id');
            $table->string('uuid');
            $table->text('start_url');
            $table->string('join_url');

            $table->boolean ('is_active')->default(true);

            $table->date('start_date')->nullable();
            $table->date('start_end')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('zoom_id');
            $table->index('uuid');
        });


        Schema::create('zoom_recording', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('zoom_user_id');
            $table->foreign('zoom_user_id')->references('id')->on('zoom_user');

            $table->unsignedBigInteger('session_id')->nullable();
            $table->foreign('session_id')->references('id')->on('session');

            $table->string('uuid');
            $table->string('recording_zoom_id');
            $table->datetime('start');
            $table->datetime('end');
            $table->string('timezone');
            $table->string('file_type');
            $table->string('play_url');
            $table->string('download_url');
            $table->string('chat_file')->nullable();
            $table->string('status');

            $table->timestamps();
            $table->softDeletes();

            $table->index('uuid');
            $table->index('recording_zoom_id');
            $table->index('start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zoom_recording');
        Schema::dropIfExists('zoom_meeting');
        Schema::dropIfExists('zoom_user');
    }
};
