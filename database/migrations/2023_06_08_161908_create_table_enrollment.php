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
        Schema::create('enrollment', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('user');

            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('section');

            $table->boolean('active')->default(false);
            $table->datetime('registered_at')->nullable();
            $table->datetime('activated_at')->nullable();
            $table->datetime('finished_at')->nullable();

            $table->boolean('intro_session')->default(false);

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
        Schema::dropIfExists('enrollment');
    }
};
