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

        Schema::create('coach_level', function (Blueprint $table) {

            $table->id();
            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('coach_info', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');

            $table->unsignedBigInteger('coach_level_id')->nullable();
            $table->foreign('coach_level_id')->references('id')->on('coach_level');

            $table->text('description')->nullable();

            $table->boolean('is_trainee')->default(false);
            $table->boolean('is_payer')->default(false);
            $table->decimal('mean_stars', 5, 3)->default(0);

            $table->string('url_video')->nullable();

            $table->smallInteger('ranking')->default(0);
            $table->smallInteger('preference')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('account_type', function (Blueprint $table) {

            $table->id();
            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coach_billing_info', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');

            $table->unsignedBigInteger('method_payment_id')->nullable();
            $table->foreign('method_payment_id')->references('id')->on('method_payment');

            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currency');

            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('country');

            $table->unsignedBigInteger('account_type_id')->nullable();
            $table->foreign('account_type_id')->references('id')->on('account_type');

            $table->string('full_name');
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->text ('bank_observations')->nullable();
            $table->string('ind')->nullable();
            $table->string('swift')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('route_number')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('salary_coach', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->unsignedBigInteger('salary_type_id');
            $table->foreign('salary_type_id')->references('id')->on('salary_type');

            $table->integer('amount_value');
            $table->string('currency_value', 3);

            $table->integer('amount_extra_coordinator')->nullable();
            $table->string('currency_extra_coordinator', 3)->nullable();

            $table->text('comments');

            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('salary_incentive_type', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->text('description');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('salary_incentive_frequency', function (Blueprint $table) {

            $table->id();
            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('salary_incentive', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->unsignedBigInteger('frequency_id');
            $table->foreign('frequency_id', 'salary_incentive_frequency')->references('id')->on('salary_incentive_frequency');

            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id', 'salary_incentive_type')->references('id')->on('salary_incentive_type');

            $table->integer('amount_value');
            $table->string('currency_value', 3);

            $table->date('date');
            $table->text('comments');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('salary_discount_type', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->text('description');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('salary_discount', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id', 'salary_discount_type')->references('id')->on('salary_discount_type');

            $table->integer('amount_value');
            $table->string('currency_value', 3);

            $table->date('date');
            $table->text('comments');

            $table->timestamps();
            $table->softDeletes();

        });

        /*
        Schema::create('coach_discount', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');

            $table->decimal('discount', 7,2);
            $table->date('date_discount');

            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('coach_incentive', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');

            $table->unsignedBigInteger('type_incentive_id');
            $table->foreign('type_incentive_id')->references('id')->on('type_incentive');

            $table->decimal('incentive', 6,2);
            $table->date('date_incentive');

            $table->timestamps();
            $table->softDeletes();

        });
*/

        Schema::create('coach_occupation', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user');

            $table->unsignedBigInteger('semester_id');
            $table->foreign('semester_id')->references('id')->on('semester');

            $table->smallInteger('year');
            $table->decimal('percentage', 5,2);

            $table->timestamps();
            $table->softDeletes();
        });
        

        Schema::create('coach_coordinator', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('coordinator_id');
            $table->foreign('coordinator_id')->references('id')->on('user');

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coach_substitution', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->unsignedBigInteger('substitute_id');
            $table->foreign('substitute_id')->references('id')->on('user');

            $table->date('date_subsitution');
            $table->smallInteger('number_session');
            $table->smallInteger('min_session');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('manager_evaluation', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->unsignedBigInteger('evaluator_id');
            $table->foreign('evaluator_id')->references('id')->on('user');

            $table->unsignedBigInteger('timezone_id');
            $table->foreign('timezone_id')->references('id')->on('timezone');

            $table->datetime('evaluation_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('manager_evaluation_file', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('evaluation_id');
            $table->foreign('evaluation_id', 'manager_evaluation_file')->references('id')->on('manager_evaluation');

            $table->string('filename');
            $table->string('original_name');
            $table->string('mime');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('instructor_evaluation', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('user');

            $table->unsignedBigInteger('instructor_id');
            $table->foreign('instructor_id')->references('id')->on('user');

            $table->unsignedBigInteger('timezone_id');
            $table->foreign('timezone_id')->references('id')->on('timezone');

            $table->datetime ('evaluation_at');
            $table->text('content');

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
    }
};
