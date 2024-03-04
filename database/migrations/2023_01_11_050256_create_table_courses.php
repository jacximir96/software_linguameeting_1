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


        Schema::create('session_type', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('code');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('conversation_package', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('session_type_id');
            $table->foreign('session_type_id', 'session_type')->references('id')->on('session_type');

            $table->string('name');
            $table->smallInteger('number_session');
            $table->smallInteger('duration_session');
            $table->string('isbn');
            $table->integer('amount_price');
            $table->string('currency_price', 3);
            $table->boolean('experiences')->default(false);
            $table->boolean('make_up')->default(false);
            $table->boolean('hight_school')->default(false);
            $table->boolean('code_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('conversation_package_offer', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('session_type_id');
            $table->foreign('session_type_id')->references('id')->on('session_type');

            $table->string('name');
            $table->smallInteger('number_session');
            $table->smallInteger('duration_session');
            $table->string('isbn');
            $table->integer('amount_price');
            $table->string('currency_price', 3);
            $table->boolean('make_up')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('service_type', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('name_short');
            $table->string('slug');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('experience_type', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('amount_price');
            $table->string('currency_price', 3);
            $table->smallInteger('num_experiences')->nullable();
            $table->boolean('is_unlimited')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('course', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('service_type_id');
            $table->foreign('service_type_id')->references('id')->on('service_type');

            $table->unsignedBigInteger('university_id');
            $table->foreign('university_id')->references('id')->on('university');

            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')->references('id')->on('university_level');

            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('language');

            $table->unsignedBigInteger('conversation_package_id')->nullable();
            $table->foreign('conversation_package_id')->references('id')->on('conversation_package');

            $table->unsignedBigInteger('conversation_guide_id')->nullable(); //textbook
            $table->foreign('conversation_guide_id')->references('id')->on('conversation_guide');

            $table->unsignedBigInteger('semester_id');
            $table->foreign('semester_id')->references('id')->on('semester');

            $table->unsignedBigInteger('creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('user');

            $table->unsignedBigInteger('experience_type_id')->nullable();
            $table->foreign('experience_type_id')->references('id')->on('experience_type');

            $table->smallInteger('year');
            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->string('name');
            $table->smallInteger('student_class');
            $table->smallInteger('duration');

            $table->boolean('is_flex')->default(false);

            $table->text('description')->nullable();
            $table->text('internal_comment')->nullable();

            $table->string('url_survey')->nullable();
            $table->boolean ('is_free')->default(false);
            $table->boolean('is_lingro')->default(false); //conversation_guides
            $table->boolean('buy_makeups')->default(false);
            $table->smallInteger('number_makeups')->default(0);
            $table->boolean('coaches_assigned')->default(false);

            $table->integer('amount_discount')->nullable();
            $table->string('currency_discount', 3)->nullable();

            $table->string('color');
            $table->boolean('complimentary_makeup')->default(false);
            $table->boolean('is_blocked')->default(false);
            $table->boolean('is_blocked_admin')->default(false);

            $table->dateTime('closed_date')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('created_at');
            $table->index('start_date');
            $table->index('end_date');

        });

        Schema::create('course_holiday', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('course');

            $table->date('date');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('course_coach', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('course');

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('course_coordinator', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('course');

            $table->unsignedBigInteger('coordinator_id');
            $table->foreign('coordinator_id')->references('id')->on('user');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('coaching_week', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('course');

            $table->smallInteger('session_order');
            $table->smallInteger('occupation_week');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_makeup')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('section', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('course');

            $table->unsignedBigInteger('instructor_id');
            $table->foreign('instructor_id')->references('id')->on('user');

            $table->string('name');
            $table->smallInteger('num_students');
            $table->string('code');
            $table->boolean('see_recordings')->default(false);
            $table->string('lingro_code')->nullable();

            $table->smallInteger('make_ups_inst_section');
            $table->smallInteger('make_ups_inst_section_used');

            $table->boolean('is_free')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->index('created_at');
            $table->index('code');
        });

        Schema::create('section_teacher_assistant', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('section');

            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('user');

            $table->timestamps();
            $table->softDeletes();

        });


        Schema::create('assignment', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('section');

            //normal course
            $table->unsignedBigInteger('week_id')->nullable();
            $table->foreign('week_id')->references('id')->on('coaching_week');
            //flex course
            $table->smallInteger('session_order')->nullable();

            $table->string('activity_name')->nullable();
            $table->text('activity_description')->nullable();

            $table->text('coach_note')->nullable(); //private

            $table->timestamps();
            $table->softDeletes();
        });

        //save content ids_chapters from course_documentation
        Schema::create('assignment_chapter', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('assignment_id');
            $table->foreign('assignment_id')->references('id')->on('assignment');

            $table->unsignedBigInteger('chapter_id')->nullable();
            $table->foreign('chapter_id', 'documentation_guide_chapter')->references('id')->on('conversation_guide_chapter');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('assignment_file', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('assignment_id');
            $table->foreign('assignment_id')->references('id')->on('assignment');

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
        Schema::dropIfExists('coaching_week');
        Schema::dropIfExists('course_coordinator');
        Schema::dropIfExists('course_coach');
        Schema::dropIfExists('course_holiday');
        Schema::dropIfExists('course');
        Schema::dropIfExists('conversation_package_offer');
        Schema::dropIfExists('conversation_package');
        Schema::dropIfExists('course');
    }
};
