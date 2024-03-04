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
        Schema::create('guide_origin', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('conversation_guide', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->unsignedBigInteger('guide_origin_id');
            $table->foreign('guide_origin_id', 'guide_origin')->references('id')->on('guide_origin');

            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('language');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('conversation_guide_file', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('conversation_guide_id');
            $table->foreign('conversation_guide_id', 'guide_file')->references('id')->on('conversation_guide');

            $table->string('filename');
            $table->string('original_name');
            $table->string('mime');
            $table->string('description');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('conversation_guide_chapter', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('conversation_guide_id');
            $table->foreign('conversation_guide_id')->references('id')->on('conversation_guide');

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('conversation_guide_chapter_file', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('conversation_guide_chapter_id');
            $table->foreign('conversation_guide_chapter_id', 'conversation_chapter_file')->references('id')->on('conversation_guide_chapter');

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

    }
};
