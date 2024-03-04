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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('nickname')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->boolean('active')->default(false);
            $table->boolean('locked')->default(false);

            $table->index('lastname');
        });

        Schema::create('profile_image', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');

            $table->string('filename');
            $table->string('original_name');
            $table->string('mime');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_public', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('school');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['lastname', 'name', 'email']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_public');
        Schema::dropIfExists('users');
    }
};
