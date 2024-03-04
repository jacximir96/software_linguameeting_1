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
        Schema::create('bookstore_request', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('university_id');
            $table->foreign('university_id')->references('id')->on('university');

            $table->unsignedBigInteger('conversation_package_id');
            $table->foreign('conversation_package_id')->references('id')->on('conversation_package');

            $table->smallInteger('num_codes');
            $table->date('date_request');

            $table->timestamps();
            $table->softDeletes();

            $table->index('date_request');
        });

        Schema::create('bookstore_request_file', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('bookstore_request_id');
            $table->foreign('bookstore_request_id', 'code_request_file')->references('id')->on('bookstore_request');

            $table->string('filename');
            $table->string('original_name');
            $table->string('mime');

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
        Schema::dropIfExists('bookstore_code');
        Schema::dropIfExists('bookstore_request_file');
        Schema::dropIfExists('bookstore_request');
    }
};
