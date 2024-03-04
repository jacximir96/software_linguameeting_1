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

        Schema::create('country', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('iso2', 2);
            $table->string('iso3', 3);

            $table->string('code', 5);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('timezone', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('show');

            $table->string('description');

            $table->string('code', 10);
            $table->string('gmt');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('time', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('time_hour', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('time_id')->nullable();
            $table->foreign('time_id')->references('id')->on('time');

            $table->string('name');
            $table->time('start');
            $table->time('end');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('time_type', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('language', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->boolean('is_lingro')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('method_payment', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->boolean('for_coach')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('currency', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('code',3);

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('salary_type', function (Blueprint $table) {

            $table->id();
            $table->string('name');

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

        Schema::dropIfExists('type_incentive');
        Schema::dropIfExists('currency');
        Schema::dropIfExists('method_payment');
        Schema::dropIfExists('language');
        Schema::dropIfExists('time_hour');
        Schema::dropIfExists('time');
        Schema::dropIfExists('timezone');
        Schema::dropIfExists('country');
    }
};
