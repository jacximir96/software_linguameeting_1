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
        Schema::table('user', function (Blueprint $table) {

            $table->unsignedBigInteger('timezone_id')->nullable()->after('id');
            $table->foreign('timezone_id')->references('id')->on('timezone');

            $table->unsignedBigInteger('country_id')->nullable()->after('timezone_id');
            $table->foreign('country_id')->references('id')->on('country');

            $table->unsignedBigInteger('country_live_id')->nullable()->after('country_id');
            $table->foreign('country_live_id')->references('id')->on('country');

            $table->text('internal_comment')->nullable();
            $table->string('url_photo')->nullable();
            $table->boolean('lingro_student')->default(0);
            $table->string ('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('skype')->nullable();

            $table->boolean('email_reception')->default(1);
            $table->boolean('email_marketing')->default(1);

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('hobby', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user')->references('id')->on('user');

            $table->string('description');

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
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
};
