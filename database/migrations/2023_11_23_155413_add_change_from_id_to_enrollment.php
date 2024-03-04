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
        Schema::table('enrollment', function (Blueprint $table) {

            //clave foránea a la misma tabla para saber cuando se cambia un estudiante de curso...saber cual fue el curso de origen (nos sirve para conocer el pago que hizo)
            $table->unsignedBigInteger('origin_enrollment_id')->nullable()->after('section_id');
            $table->foreign('origin_enrollment_id', 'origin_enrollment_id')->references('id')->on('enrollment');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
