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
        Schema::create('lingro_register', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('lastname');
            $table->string('email');

            $table->string('code_section');
            $table->datetime('registered_at');
            $table->boolean('update_profile')->default(false);

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
        Schema::dropIfExists('table_lingro_register');
    }
};
