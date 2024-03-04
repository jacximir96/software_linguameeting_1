<?php

namespace App\Src\UserDomain\User\Model\Traits;

use App\Src\CoachDomain\BillingInfo\Model\BillingInfo;
use App\Src\CoachDomain\CoachCoordinator\Model\CoachCoordinator;
use App\Src\CoachDomain\CoachInfo\Model\CoachInfo;
use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluation\Model\ManagerEvaluation;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Model\CoachReview;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CoachDomain\Payment\Model\Payment;
use App\Src\CoachDomain\SalaryDomain\Discount\Model\Discount;
use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;
use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use App\Src\CoachDomain\SemesterFinished\Model\SemesterFinished;
use App\Src\CourseDomain\CourseCoach\Model\CourseCoach;
use App\Src\CourseDomain\CourseCoordinator\Model\CourseCoordinator;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\PaymentDomain\Currency\Model\Currency;
use App\Src\UserDomain\Hobby\Model\Hobby;
use App\Src\ZoomDomain\ZoomMeeting\Model\ZoomMeeting;
use App\Src\ZoomDomain\ZoomUser\Model\ZoomUser;

trait Coach
{
    public function billingInfo()
    {
        return $this->hasOne(BillingInfo::class);
    }

    public function coachCoordinated()
    {
        //relación con su coordinador
        return $this->hasOne(CoachCoordinator::class, 'coach_id');
    }

    public function coachCoordinator()
    {
        //relación con los que coordina
        return $this->hasMany(CoachCoordinator::class, 'coordinator_id');
    }

    public function coachFeedback()
    {
        return $this->hasMany(CoachFeedback::class);
    }

    public function courseCoach()
    {
        return $this->hasMany(CourseCoach::class, 'coach_id');
    }

    public function courseCoordinator()
    {
        return $this->hasMany(CourseCoordinator::class, 'coordinator_id');
    }

    public function coachInfo()
    {
        return $this->hasOne(CoachInfo::class);
    }

    public function coachReview()
    {
        return $this->hasMany(CoachReview::class, 'coach_id');
    }

    public function discount()
    {
        return $this->hasMany(Discount::class, 'coach_id');
    }

    public function discountSortedDesc()
    {
        return $this->discount->sortByDesc(function ($discount) {
            return $discount->date->toDateString();
        });
    }

    public function evaluationManager()
    {
        return $this->hasMany(ManagerEvaluation::class, 'coach_id');
    }

    public function hobby()
    {
        return $this->hasMany(Hobby::class);
    }

    public function incentive()
    {
        return $this->hasMany(Incentive::class, 'coach_id');
    }

    public function incentiveSortedDesc()
    {
        return $this->incentive->sortByDesc(function ($incentive) {
            return $incentive->date->toDateString();
        });
    }

    public function payment()
    {
        return $this->hasMany(Payment::class, 'coach_id');
    }

    public function reviewStats()
    {
        $repo = app(CoachReviewRepository::class);

        return $repo->reviewStats($this);
    }

    public function salary()
    {
        return $this->hasOne(Salary::class, 'coach_id');
    }

    public function schedule()
    {
        return $this->hasMany(CoachSchedule::class, 'coach_id');
    }

    public function semesterFinished()
    {
        return $this->hasOne(SemesterFinished::class, 'coach_id');
    }

    public function session (){
        return $this->hasMany(Session::class, 'coach_id');
    }

    public function zoomMeeting()
    {
        return $this->hasOne(ZoomMeeting::class, 'user_id', 'id');
    }

    public function zoomUser()
    {
        return $this->hasOne(ZoomUser::class, 'user_id', 'id');
    }

    public function currency(): Currency
    {
        return $this->billingInfo->currency;
    }

    public function canGenerateInvoice(): bool
    {
        return $this->billingInfo->hasPaymentInfo();
    }
}
