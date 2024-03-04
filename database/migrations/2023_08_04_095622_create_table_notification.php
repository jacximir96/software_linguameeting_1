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

        Schema::create('notification_level', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('color');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('notification_type', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('notification_level_id');
            $table->foreign('notification_level_id', 'notification_type_level')->references('id')->on('notification_level');

            $table->string('name');
            $table->string('description');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('notification', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('notification_type_id');
            $table->foreign('notification_type_id', 'notification_type')->references('id')->on('notification_type');

            $table->unsignedBigInteger('notifier_id')->nullable();
            $table->foreign('notifier_id', 'notifier')->references('id')->on('user');

            $table->text('content');
            $table->json('extra')->nullable();
            $table->datetime('notification_at');

            $table->timestamps();
            $table->softDeletes();

            $table->index('notification_at');
        });


        Schema::create('notification_recipient', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('notification_id');
            $table->foreign('notification_id')->references('id')->on('notification');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('user');

            $table->datetime('read_at')->nullable();

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
        Schema::dropIfExists('notification_recipient');
        Schema::dropIfExists('notification');
        Schema::dropIfExists('notification_type');
        Schema::dropIfExists('notification_level');
    }
};
