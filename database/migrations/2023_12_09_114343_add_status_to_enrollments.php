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
            $table->unsignedBigInteger('status_id')->nullable()->after('origin_enrollment_id');
            $table->foreign('status_id')->references('id')->on('enrollment_status');
            $table->datetime('status_at')->nullable()->after('status_id');
        });

        $enrollments = \App\Src\StudentDomain\Enrollment\Model\Enrollment::withTrashed()->get();

        foreach ($enrollments as $enrollment){

            if ($enrollment->active){
                $enrollment->status_id = \App\Src\StudentDomain\EnrollmentStatus\Model\EnrollmentStatus::ACTIVE_ID;
                $enrollment->status_at = $enrollment->registered_at;
                $enrollment->save();
            }
            elseif ( ($enrollment->active == 0) AND !is_null($enrollment->origin_enrollment_id) ){
                $enrollment->status_id = \App\Src\StudentDomain\EnrollmentStatus\Model\EnrollmentStatus::CHANGED_ID;
                $enrollment->save();
            }
            elseif($enrollment->trashed()){
                $enrollment->status_id = \App\Src\StudentDomain\EnrollmentStatus\Model\EnrollmentStatus::ENDED_ID;
                $enrollment->save();
            }
        }

        Schema::table('enrollment', function (Blueprint $table) {
            $table->dropColumn('registered_at');
            $table->dropColumn('activated_at');
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
