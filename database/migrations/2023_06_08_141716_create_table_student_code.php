<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('register_code', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('bookstore_request_id')->nullable();
            $table->foreign('bookstore_request_id')->references('id')->on('bookstore_request');

            $table->string('code');
            $table->boolean('is_used')->default(false);
            $table->dateTime('used_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
        });
    }


    public function down()
    {
        Schema::dropIfExists('register_code');
    }
};
