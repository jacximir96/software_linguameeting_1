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
        Schema::create('coach_help_type', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coach_help', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('coach_help_type_id');
            $table->foreign('coach_help_type_id', 'coach_help_type')->references('id')->on('coach_help_type');

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
        //
    }
};
