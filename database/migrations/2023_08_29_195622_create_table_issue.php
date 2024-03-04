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
        Schema::create('issue', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');

            $table->unsignedBigInteger('issue_type_id');
            $table->foreign('issue_type_id')->references('id')->on('issue_type');

            $table->string('summary');
            $table->text('description')->nullable();

            $table->datetime('sent_at');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('issue_file', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('issue_id');
            $table->foreign('issue_id')->references('id')->on('issue');

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
        Schema::dropIfExists('issue_file');
        Schema::dropIfExists('issue');
    }
};
