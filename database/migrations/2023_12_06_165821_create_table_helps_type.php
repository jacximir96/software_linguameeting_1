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
        Schema::create('instructor_help_type', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('instructor_help', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('instructor_help_type_id');
            $table->foreign('instructor_help_type_id', 'instructor_help_type')->references('id')->on('instructor_help_type');

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
        Schema::dropIfExists('instructor_help');
        Schema::dropIfExists('table_instructor_help');
    }
};
