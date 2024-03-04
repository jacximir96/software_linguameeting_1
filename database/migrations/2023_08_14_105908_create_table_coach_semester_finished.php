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
        Schema::create('coach_semester_finished', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->boolean('semester_1')->default(false);
            $table->boolean('semester_2')->default(false);

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
        Schema::dropIfExists('coach_semester_finished');
    }
};
