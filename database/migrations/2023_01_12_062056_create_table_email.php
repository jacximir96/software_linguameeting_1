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
        Schema::create('email', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('receiver_id');
            $table->foreign('receiver_id')->references('id')->on('user');

            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('body');
            $table->string('attach')->nullable();
            $table->datetime('date_send_mes');
            $table->string('type_message');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('email_next', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('receiver_id');
            $table->foreign('receiver_id')->references('id')->on('user');

            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('body');
            $table->string('attach')->nullable();
            $table->datetime('date_send_mes');
            $table->string('type_message');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('email_notattendance', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('receiver_id');
            $table->foreign('receiver_id')->references('id')->on('user');

            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('body');
            $table->string('attach')->nullable();
            $table->datetime('date_send_mes');
            $table->string('type_message');

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
        Schema::dropIfExists('email');
    }
};
