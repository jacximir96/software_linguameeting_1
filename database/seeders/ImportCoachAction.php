<?php


namespace Database\Seeders;


use App\Src\_Old\Model\CoachBillingInfo;
use App\Src\_Old\Model\CoachDiscount;
use App\Src\_Old\Model\CoachesCoor;
use App\Src\_Old\Model\CoachEvaluation;
use App\Src\_Old\Model\CoachEvaluationManager;
use App\Src\_Old\Model\CoachIncentive;
use App\Src\_Old\Model\CoachOccTerm;
use App\Src\_Old\Model\CoachPayment;
use App\Src\_Old\Model\CoachSubstitution;
use App\Src\_Old\Model\Hobbies;
use App\Src\_Old\Model\SalaryCoaches;
use App\Src\_Old\Model\Users;
use App\Src\CoachDomain\BillingInfo\Model\BillingInfo;
use App\Src\CoachDomain\CoachCoordinator\Model\CoachCoordinator;
use App\Src\CoachDomain\CoachInfo\Model\CoachInfo;
use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluation\Model\ManagerEvaluation;
use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluationFile\Model\ManagerEvaluationFile;
use App\Src\CoachDomain\Occupation\Model\Occupation;
use App\Src\CoachDomain\SalaryDomain\Discount\Model\Discount;
use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;
use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\UserDomain\Hobby\Model\Hobby;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class ImportCoachAction
{

    use TraitImport;

    private LinguaMoney $linguaMoney;

    public function handle(Users $itemOld, User $user){

        $this->linguaMoney = new LinguaMoney();

        $this->createCoachInfo($itemOld, $user);

        $this->importHobbies($itemOld, $user);

        $this->createBillingInfo ($user);

        $this->createDiscountInfo($user);

        $this->createIncentiveInfo($user);

        $this->createSalary($user);

        $this->createOccupationInfo($user);

        //$this->createPaymentInfo($user);

        $this->addEvaluationManager($user);
    }

    /* run at end when all users are migrated */
    public function associateCoordinatorCoach (User $user){

        $itemsOld = CoachesCoor::where('id_user_coor', $user->id)->get();

        if ( ! $itemsOld->count()){
            return;
        }

        foreach ($itemsOld as $itemOld){

            //todo quitar esta comprobación, solo está pq en las pruebas importo únicamente 500 usuarios
            $coachExists = User::find($itemOld->id_user_coach);

            if (is_null($coachExists)){
                continue;
            }

            $newItem = new CoachCoordinator();
            $newItem->coordinator_id = $itemOld->id_user_coor;
            $newItem->coach_id = $itemOld->id_user_coach;
            $newItem->save();
        }
    }

    /* run at end when all users are migrated */
    public function associateSubstitutionCoach (User $user){

        $itemsOld = CoachSubstitution::where('id_coach', $user->id)->get();

        if ( ! $itemsOld->count()){
            return;
        }

        foreach ($itemsOld as $itemOld){

            //todo quitar esta comprobación, solo está pq en las pruebas importo únicamente 500 usuarios
            $coachExists = User::find($itemOld->id_sust);

            if (is_null($coachExists)){
                continue;
            }


            $newItem = new \App\Src\CoachDomain\Substitution\Model\Substitution();
            $newItem->coach_id = $itemOld->id_coach;
            $newItem->substitute_id = $itemOld->id_sust;
            $newItem->date_subsitution = $itemOld->day_sust;
            $newItem->number_session = $itemOld->sessions_sust;
            $newItem->min_session = $itemOld->min_session;
            $newItem->save();
        }
    }

    /* run at end when all users are migrated */
    public function createEvaluation (User $user){

        $itemsOld = CoachEvaluation::where('id_coach', $user->id)->get();

        if ( ! $itemsOld->count()){
            return;
        }

        foreach ($itemsOld as $itemOld){

            //todo quitar esta comprobación, solo está pq en las pruebas importo únicamente 500 usuarios
            $instructorExists = User::find($itemOld->id_user_feedback);

            if (is_null($instructorExists)){
                continue;
            }

            $coachExists = User::find($itemOld->id_coach);

            if (is_null($coachExists)){
                continue;
            }

            $newItem = new \App\Src\CoachDomain\FeedbackDomain\InstructorEvaluation\Model\InstructorEvaluation();
            $newItem->id = $itemOld->id_evaluation_other;
            $newItem->instructor_id = $itemOld->id_user_feedback;
            $newItem->coach_id = $itemOld->id_coach;

            $coach = User::find($itemOld->id_coach);

            $newItem->content = $itemOld->evaluation_inst;
            $newItem->evaluation_at = $itemOld->date_evaluation_other ? Carbon::parse($itemOld->date_evaluation_other, 'Europe/Madrid')->setTimezone('UTC') : null;
            $newItem->save();
        }
    }

    private function createCoachInfo (Users $itemOld, User $user){

        $coach = new CoachInfo();
        $coach->user_id = $user->id;
        $coach->coach_level_id = $itemOld->coach_level;
        $coach->description = $itemOld->description;
        $coach->is_trainee = $itemOld->coach_trainee;
        $coach->is_payer = $itemOld->coach_pagador;
        $coach->mean_stars = $itemOld->mean_stars;
        $coach->ranking = $itemOld->coach_ranking;
        $coach->preference = $itemOld->coach_pref;
        $coach->url_video = $itemOld->coach_video;

        $coach->save();
    }

    public function importHobbies (Users $itemOld, User $user){

        $hobbies = Hobbies::where('id_user', $itemOld->id_user)->get();

        foreach ($hobbies as $oldHobby){

            $new = new Hobby();
            $new->user_id = $user->id;
            $new->description = $oldHobby->description_hobby;
            $new->save();
        }

    }

    private function createBillingInfo (User $user){

        $itemOldBillingInfo = CoachBillingInfo::where('id_user', $user->id)->first();

        if (is_null($itemOldBillingInfo)){
            //echo "\r\n Coach sin billing info: ".$user->id;
            return;
        }

        $billingInfo = new BillingInfo();
        $billingInfo->user_id = $user->id;
        $billingInfo->method_payment_id = $this->obtainMethodPayment($itemOldBillingInfo->other_type_pay);
        $billingInfo->currency_id = $itemOldBillingInfo->currency;

        $billingInfo->full_name = $itemOldBillingInfo->full_name;
        $billingInfo->bank_name = $itemOldBillingInfo->bank_name;
        $billingInfo->bank_account = $itemOldBillingInfo->bank_account;
        $billingInfo->bank_observations = $itemOldBillingInfo->bank_observations;

        $billingInfo->ind = $itemOldBillingInfo->ind;
        $billingInfo->swift = $itemOldBillingInfo->swift;
        $billingInfo->address = $itemOldBillingInfo->address;
        $billingInfo->postal_code = $itemOldBillingInfo->postal_code;
        $billingInfo->city = $itemOldBillingInfo->city;
        $billingInfo->paypal_email = $itemOldBillingInfo->paypal_email;

        $billingInfo->save();
    }

    private function createDiscountInfo (User $user){

        $itemsOldDiscountInfo = CoachDiscount::where('id_coach', $user->id)->get();

        if ( ! $itemsOldDiscountInfo->count()){
            //echo "\r\n Coach sin discount info: ".$user->id;
            return;
        }

        foreach ($itemsOldDiscountInfo as $itemOldDiscountInfo){

            $discount = new Discount();
            $discount->coach_id = $user->id;
            $discount->type_id = 1;
            $discount->value = $this->linguaMoney->buildFromFloat($itemOldDiscountInfo->discount);
            $discount->date = $itemOldDiscountInfo->date_discount;
            $discount->comments = '';

            $discount->save();
        }
    }

    private function createSalary (User $user){

        $itemsOldSalaries = SalaryCoaches::where('id_coach', $user->id)->get();

        if ( ! $itemsOldSalaries->count()){
            //echo "\r\n Coach sin salary info: ".$user->id;
            return;
        }

        foreach ($itemsOldSalaries as $itemOldSalary){

            $salary = new Salary();
            $salary->id = $itemOldSalary->id_salary_coach;
            $salary->coach_id = $user->id;
            $salary->salary_type_id = $itemOldSalary->fixed_salary ? 1 : 2;
            $salary->value = $this->linguaMoney->buildFromFloat($itemOldSalary->salary_hour);
            $salary->comments = '';

            $salary->save();
        }
    }

    private function createIncentiveInfo (User $user){

        $itemsOldIncentiveInfo = CoachIncentive::where('id_coach', $user->id)->get();

        if ( ! $itemsOldIncentiveInfo->count()){
            //echo "\r\n Coach sin incentive info: ".$user->id;
            return;
        }

        foreach ($itemsOldIncentiveInfo as $itemOldIncentiveInfo){

            $incentive = new Incentive();
            $incentive->coach_id = $user->id;
            $incentive->type_id = 1;
            $incentive->frequency_id = $itemOldIncentiveInfo->type_incentive;
            $incentive->value = $this->linguaMoney->buildFromFloat($itemOldIncentiveInfo->incentive);
            $incentive->date = $itemOldIncentiveInfo->date_incentive;
            $incentive->comments = '';

            $incentive->save();
        }
    }

    private function createOccupationInfo (User $user){

        $itemsOldOccupationInfo = CoachOccTerm::where('coach_id', $user->id)->get();

        if ( ! $itemsOldOccupationInfo->count()){
            //echo "\r\n Coach sin occupation info: ".$user->id;
            return;
        }

        foreach ($itemsOldOccupationInfo as $itemOldOccupationInfo){

            $newItem = new Occupation();

            $newItem->user_id = $user->id;
            $newItem->semester_id = $itemOldOccupationInfo->semester_id;
            $newItem->year = $itemOldOccupationInfo->year;
            $newItem->percentage = $itemOldOccupationInfo->percentage;

            $newItem->save();
        }
    }

    private function createPaymentInfo (User $user){

        $money = new LinguaMoney();
        $itemsOldInfo = CoachPayment::where('id_coach', $user->id)->get();

        if ( ! $itemsOldInfo->count()){
            //echo "\r\n Coach sin occupation info: ".$user->id;
            return;
        }

        foreach ($itemsOldInfo as $itemOldInfo){

            $newItem = new \App\Src\CoachDomain\Payment\Model\Payment();

            $newItem->user_id = $user->id;
            $newItem->year = $itemOldInfo->year;
            $newItem->month = $itemOldInfo->month;
            $newItem->is_paid = $itemOldInfo->is_paid;

            if ( ! is_null($itemOldInfo->value)){

                if ( ! $itemOldInfo->value){
                    $value = $money->buildZero();
                }
                else{
                    $value = $money->buildFromFloat($itemOldInfo->value);
                }

                $newItem->value = $value;
            }

            $newItem->save();
        }
    }

    private function addEvaluationManager (User $user){


        $itemsOldInfo = CoachEvaluationManager::where('id_coach', $user->id)->get();

        if ( ! $itemsOldInfo->count()){
            //echo "\r\n Coach sin incentive info: ".$user->id;
            return;
        }

        foreach ($itemsOldInfo as $itemOld){

            $evaluation = new ManagerEvaluation();
            $evaluation->id = $itemOld->id_evaluation;
            $evaluation->coach_id = $itemOld->id_coach;
            $evaluation->evaluator_id = 3; //carmen por defecto

            if ( ! empty($itemOld->evaluation_1)){

                $evaluation->evaluation_at = $itemOld->date_evaluation_1 ? Carbon::parse($itemOld->date_evaluation_1, 'Europe/Madrid')->setTimezone('UTC') : null;
                $evaluation->save();

                $file = new ManagerEvaluationFile();
                $file->evaluation_id = $itemOld->id_evaluation;
                $file->filename = basename($itemOld->evaluation_1);
                $file->original_name = basename ($itemOld->evaluation_1);


                $pathInfo = pathInfo($itemOld->evaluation_1);
                $mime = '';
                if ($pathInfo['extension'] == 'pdf'){
                    $mime = 'application/pdf';
                }
                elseif ($pathInfo['extension'] == 'docx'){
                    $mime = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                }
                else{
                    dd($pathInfo);
                }

                $file->mime = $mime;
                $file->save();
            }

            if ( ! empty($itemOld->evaluation_2)){

                $evaluation->evaluation_at = $itemOld->date_evaluation_2 ? Carbon::parse($itemOld->date_evaluation_2, 'Europe/Madrid')->setTimezone('UTC') : null;
                $evaluation->save();

                $file = new ManagerEvaluationFile();
                $file->evaluation_id = $itemOld->id_evaluation;
                $file->filename = basename($itemOld->evaluation_2);
                $file->original_name = basename ($itemOld->evaluation_2);

                $pathInfo = pathInfo($itemOld->evaluation_2);
                $mime = '';
                if ($pathInfo['extension'] == 'pdf'){
                    $mime = 'application/pdf';
                }
                elseif ($pathInfo['extension'] == 'docx'){
                    $mime = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                }
                else{
                    dd($pathInfo);
                }

                $file->mime = $mime;
                $file->save();
            }


        }
    }
}
