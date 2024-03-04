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
        Schema::create('documentation_submit_log', function (Blueprint $table) {
            $table->id();

            $table->morphs('logable');

            $table->unsignedBigInteger('sender_id');
            $table->foreign('sender_id')->references('id')->on('user');

            $table->unsignedBigInteger('recipient_id');
            $table->foreign('recipient_id')->references('id')->on('user');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['logable_id', 'logable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentation_submit_log');
    }
};
