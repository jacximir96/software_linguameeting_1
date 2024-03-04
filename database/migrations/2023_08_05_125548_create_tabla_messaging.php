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


        Schema::create('thread', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('writer_id');
            $table->foreign('writer_id')->references('id')->on('user');

            $table->string('subject');

            $table->timestamps();
            $table->softDeletes();

            $table->index('created_at');
            $table->index('updated_at');
        });

        Schema::create('thread_message', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('thread_id');
            $table->foreign('thread_id')->references('id')->on('thread');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');

            $table->unsignedBigInteger('timezone_id');
            $table->foreign('timezone_id')->references('id')->on('timezone');

            $table->text('content');

            $table->datetime('write_at');

            $table->timestamps();
            $table->softDeletes();

            $table->index('created_at');
            $table->index('updated_at');
        });

        Schema::create('thread_read', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('thread_id');
            $table->foreign('thread_id')->references('id')->on('thread');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');

            $table->unsignedBigInteger('timezone_id');
            $table->foreign('timezone_id')->references('id')->on('timezone');

            $table->datetime('read_at');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('thread_participant', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('thread_id');
            $table->foreign('thread_id')->references('id')->on('thread');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');

            $table->dateTime('read_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('message_file', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('message_id');
            $table->foreign('message_id')->references('id')->on('thread_message');

            $table->string('filename');
            $table->string('original_name');
            $table->string('mime');

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
        Schema::dropIfExists('message_file');
        Schema::dropIfExists('thread_participant');
        Schema::dropIfExists('thread_read');
        Schema::dropIfExists('thread_message');
        Schema::dropIfExists('thread');
    }
};
