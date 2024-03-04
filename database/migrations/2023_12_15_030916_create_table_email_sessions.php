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
        Schema::create('email_session', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_user_receiver');
            $table->foreign('id_user_receiver')->references('id')->on('user');

            $table->string('email_receiver');
            $table->string('subject_mail')->nullable();
            $table->longText('body_mail');

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
        Schema::dropIfExists('email_session');
    }
};
