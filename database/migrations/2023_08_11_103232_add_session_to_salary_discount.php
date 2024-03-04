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
        Schema::table('salary_discount', function (Blueprint $table) {

            $table->unsignedBigInteger('session_id')->nullable()->after('type_id');
            $table->foreign('session_id')->references('id')->on('session');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_discount', function (Blueprint $table) {
            //
        });
    }
};
