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

        Schema::create('accommodation_type', function (Blueprint $table) {

            $table->id();

            $table->string('description');
            $table->boolean('individual_session')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('accommodation', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('enrollment_id');
            $table->foreign('enrollment_id')->references('id')->on('enrollment');

            $table->unsignedBigInteger('accommodation_type_id');
            $table->foreign('accommodation_type_id')->references('id')->on('accommodation_type');

            $table->text('description');

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
        Schema::dropIfExists('accommodation');
        Schema::dropIfExists('accommodation_type');
    }
};
