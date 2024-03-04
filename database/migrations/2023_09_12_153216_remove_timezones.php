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
       $tables = [
           'manager_evaluation',
           'instructor_evaluation',
           'payment',
           'session',
           'enrollment_session',
           'coach_schedule',
           'experience_comment',
           'thread_message',
           'thread_read',
           'payment_refund',
       ];

       foreach ($tables as $table){

            if (Schema::hasColumn($table, 'timezone_id')){

                $key = $table.'_timezone_id_foreign';

                Schema::table($table, function (Blueprint $databaseTable) use ($key) {
                    $databaseTable->dropForeign($key);
                    $databaseTable->dropColumn('timezone_id');
                });
            }

           if (Schema::hasColumn($table, 'registered_timezone_id')){
               $key = $table.'_registered_timezone_id_foreign';

               Schema::table($table, function (Blueprint $databaseTable) use ($key) {
                   $databaseTable->dropForeign($key);
                   $databaseTable->dropColumn('registered_timezone_id');
               });
           }

           if (Schema::hasColumn($table, 'joined_timezone_id')){
               $key = $table.'_joined_timezone_id_foreign';

               Schema::table($table, function (Blueprint $databaseTable) use ($key) {
                   $databaseTable->dropForeign($key);
                   $databaseTable->dropColumn('joined_timezone_id');
               });
           }
       }
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
