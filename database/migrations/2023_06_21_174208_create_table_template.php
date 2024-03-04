<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('template', function (Blueprint $table) {
            $table->id();

            $table->string ('description');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('template_file', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('template_id');
            $table->foreign('template_id')->references('id')->on('template');

            $table->string('filename');
            $table->string('original_name');
            $table->string('mime');

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::dropIfExists('template_file');
        Schema::dropIfExists('template');
    }
};
