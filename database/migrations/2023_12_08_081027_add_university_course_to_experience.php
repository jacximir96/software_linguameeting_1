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
        Schema::table('experience', function (Blueprint $table) {

            $table->unsignedBigInteger('university_id')->nullable()->after('code_offer_type_id');
            $table->foreign('university_id')->references('id')->on('university');

            $table->unsignedBigInteger('course_id')->nullable()->after('university_id');
            $table->foreign('course_id')->references('id')->on('course');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('experience', function (Blueprint $table) {
            //
        });
    }
};
