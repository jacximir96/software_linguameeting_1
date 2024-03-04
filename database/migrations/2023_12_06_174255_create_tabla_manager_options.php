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
        Schema::table('config', function (Blueprint $table) {

            $table->boolean('enable_chat')->default(false)->after('paid_info');
            $table->time('start_chat_at')->nullable()->after('enable_chat');
            $table->time('end_chat_at')->nullable()->after('start_chat_at');

            $table->bigInteger('emails_sent')->nullable()->after('end_chat_at');
            $table->date('emails_date')->nullable()->after('emails_sent');

            $table->bigInteger('emails_sessions_sent')->nullable()->after('emails_date');
            $table->date('emails_sessions_date')->nullable()->after('emails_sessions_sent');

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
