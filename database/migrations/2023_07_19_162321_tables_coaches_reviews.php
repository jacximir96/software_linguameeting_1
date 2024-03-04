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
        Schema::create('review_option', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coach_review', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('enrollment_session_id');
            $table->foreign('enrollment_session_id')->references('id')->on('enrollment_session');

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->tinyInteger('stars')->default(0);
            $table->text('comment')->nullable();

            $table->datetime('favorited_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('favorited_at');
        });

        Schema::create('coach_review_option', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('coach_review_id');
            $table->foreign('coach_review_id', 'session_review_option')->references('id')->on('coach_review');

            $table->unsignedBigInteger('review_option_id');
            $table->foreign('review_option_id')->references('id')->on('review_option');

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
        Schema::dropIfExists('coach_review_option');
        Schema::dropIfExists('coach_review');
        Schema::dropIfExists('review_option');
    }
};
