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

        Schema::create('participation_type', function (Blueprint $table) {
            $table->id();

            $table->string ('description');
            $table->string('description_student');
            $table->string('description_instructor');
            $table->string('description_report');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('prepared_class_type', function (Blueprint $table) {
            $table->id();

            $table->string ('description');
            $table->string('description_student');
            $table->string('description_instructor');
            $table->string('description_report');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('puntuality_type', function (Blueprint $table) {
            $table->id();

            $table->string ('description');
            $table->string('description_student');
            $table->string('description_instructor');
            $table->string('description_report');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('student_review', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('enrollment_session_id');
            $table->foreign('enrollment_session_id')->references('id')->on('enrollment_session');

            $table->unsignedBigInteger('participation_type_id')->nullable();
            $table->foreign('participation_type_id')->references('id')->on('participation_type');

            $table->unsignedBigInteger('prepared_class_type_id')->nullable();
            $table->foreign('prepared_class_type_id')->references('id')->on('prepared_class_type');

            $table->unsignedBigInteger('puntuality_type_id')->nullable();
            $table->foreign('puntuality_type_id')->references('id')->on('puntuality_type');

            $table->text('observations')->nullable();

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
        Schema::dropIfExists('student_review');
        Schema::dropIfExists('puntuality_type');
        Schema::dropIfExists('prepared_class_type');
        Schema::dropIfExists('participation_type');
    }
};
