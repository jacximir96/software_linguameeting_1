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
        Schema::create('experience_level', function (Blueprint $table) {

            $table->id();
            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('experience', function (Blueprint $table) {
            $table->unsignedBigInteger('level_id')->nullable()->after('course_id');
            $table->foreign('level_id')->references('id')->on('experience_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
