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


        Schema::create('code_offer_type', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();

        });


        Schema::create('experience', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->unsignedBigInteger('language_id')->nullable();
            $table->foreign('language_id')->references('id')->on('language');

            $table->unsignedBigInteger('code_offer_type_id')->nullable();
            $table->foreign('code_offer_type_id', 'code_offer')->references('id')->on('code_offer_type');

            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');

            /*
            $table->date('day');
            $table->time('start_time');
            $table->time('end_time');
*/

            $table->string('coach_name')->nullable();
            $table->string('coach_lastname')->nullable();

            $table->string('url_join')->nullable();
            $table->string('url_host')->nullable();

            $table->boolean('is_public')->default(false);
            $table->boolean('is_paid_public')->default(false);
            $table->boolean('is_donate_public')->default(true);
            $table->boolean('is_private')->default(true);
            $table->boolean('is_paid_private')->default(true);
            $table->boolean('is_donate_private')->default(false);

            $table->smallInteger('max_students');

            $table->integer('amount_price')->nullable();
            $table->string('currency_price', 3)->nullable();

            $table->string('zoom_video')->nullable();
            $table->string('meeting_id')->nullable();


            $table->timestamps();
            $table->softDeletes();

            $table->index('start');
            $table->index('end');
        });


        Schema::create('experience_file_type', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('experience_file', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('experience_id');
            $table->foreign('experience_id')->references('id')->on('experience');

            $table->unsignedBigInteger('experience_file_type_id');
            $table->foreign('experience_file_type_id', 'experience_file_type')->references('id')->on('experience_file_type');

            $table->string('filename');
            $table->string('original_name');
            $table->string('mime');

            $table->smallInteger('order');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('experience_university', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('experience_id');
            $table->foreign('experience_id')->references('id')->on('experience');

            $table->unsignedBigInteger('university_id');
            $table->foreign('university_id')->references('id')->on('university');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('experience_comment', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('experience_id');
            $table->foreign('experience_id')->references('id')->on('experience');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('user');

            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();

            $table->text('comment');
            $table->smallInteger('stars')->default(5);

            $table->datetime ('commented_at');
            $table->unsignedBigInteger('timezone_id');
            $table->foreign('timezone_id')->references('id')->on('timezone');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('experience_register', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('experience_id');
            $table->foreign('experience_id')->references('id')->on('experience');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');

            $table->datetime('registered_at');


            $table->datetime('joined_at')->nullable();


            $table->boolean ('attendance')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('experience_register_public', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('experience_id');
            $table->foreign('experience_id')->references('id')->on('experience');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user_public');

            $table->datetime('registered_at');
            $table->datetime('joined_at')->nullable();

            $table->boolean ('attendance')->default(false);

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
        Schema::dropIfExists('experience_register_public');
        Schema::dropIfExists('experience_register');
        Schema::dropIfExists('experience_comment');
        Schema::dropIfExists('experience_university');
        Schema::dropIfExists('experience_file');
        Schema::dropIfExists('experience_file_type');
        Schema::dropIfExists('experience');
        Schema::dropIfExists('code_offer_type');
    }
};
