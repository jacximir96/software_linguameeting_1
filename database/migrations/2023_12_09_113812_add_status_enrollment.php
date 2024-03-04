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
        Schema::create('enrollment_status', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('slug');

            $table->timestamps();
            $table->softDeletes();

        });

        $this->create('Active', 'active');
        $this->create('Ended', 'ended');
        $this->create('Refunded', 'refunded');
        $this->create('Changed', 'changed'); //cambio de curso.

    }

    private function create (string $name, string $slug){

        $status = new \App\Src\StudentDomain\EnrollmentStatus\Model\EnrollmentStatus();
        $status->name = $name;
        $status->slug = $slug;
        $status->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
