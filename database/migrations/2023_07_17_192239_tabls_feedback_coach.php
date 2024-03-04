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
        Schema::create('feedback_type', function (Blueprint $table) {
            $table->id();

            $table->text('es_title');
            $table->text('eng_title');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('feedback_subtype', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('feedback_type');

            $table->text('es_title');
            $table->text('eng_title');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('feedback_suggestions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('feedback_type');

            $table->unsignedBigInteger('subtype_id')->nullable();
            $table->foreign('subtype_id')->references('id')->on('feedback_subtype');

            $table->text('es_title');
            $table->text('eng_title');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('feedback_observations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('feedback_type');

            $table->unsignedBigInteger('subtype_id')->nullable();
            $table->foreign('subtype_id')->references('id')->on('feedback_subtype');

            $table->text('es_title');
            $table->text('eng_title');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coach_feedback', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('language');

            $table->datetime('moment')->index();
            $table->string('recording_url')->nullable();
            $table->text('observations')->nullable();

            $table->json('feedbacks')->nullable();

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
        Schema::dropIfExists('coach_feedback');
        Schema::dropIfExists('feedback_observations');
        Schema::dropIfExists('feedback_suggestions');
        Schema::dropIfExists('feedback_subtype');
        Schema::dropIfExists('feedback_type');
    }
};
