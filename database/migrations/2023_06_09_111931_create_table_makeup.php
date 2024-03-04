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
        Schema::create('makeup_type', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('makeup', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('makeup_type_id');
            $table->foreign('makeup_type_id')->references('id')->on('makeup_type');

            $table->unsignedBigInteger('allocator_id');
            $table->foreign('allocator_id')->references('id')->on('user');

            $table->unsignedBigInteger('enrollment_id');
            $table->foreign('enrollment_id')->references('id')->on('enrollment');

            $table->boolean('is_free')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('extra_session_type', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('extra_session', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('extra_session_type_id');
            $table->foreign('extra_session_type_id', 'extra_session_type')->references('id')->on('extra_session_type');

            $table->unsignedBigInteger('allocator_id');
            $table->foreign('allocator_id')->references('id')->on('user');

            $table->unsignedBigInteger('enrollment_id');
            $table->foreign('enrollment_id')->references('id')->on('enrollment');

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
        Schema::dropIfExists('makeup_type');
        Schema::dropIfExists('makeup');
        Schema::dropIfExists('extra_session_type');
        Schema::dropIfExists('extra_session');
    }
};
