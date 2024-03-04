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
        Schema::create('student_help_type', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('student_help', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_help_type_id');
            $table->foreign('student_help_type_id', 'student_help_type')->references('id')->on('student_help_type');

            $table->string('description');
            $table->string('url');

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
        Schema::dropIfExists('table_student_help');
    }
};
