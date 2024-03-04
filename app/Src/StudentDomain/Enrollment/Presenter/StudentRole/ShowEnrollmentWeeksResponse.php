<?php
namespace App\Src\StudentDomain\Enrollment\Presenter\StudentRole;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewsStatsCollection;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Service\SessionsWeeksBag;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class ShowEnrollmentWeeksResponse
{
    private Enrollment $enrollment;

    private Collection $experienceRegisters;

    private SessionRegister $sessionRegister;

    private SessionsCollection $sessionWeeks;

    private ReviewsStatsCollection $reviewsStatsCollection;

    private SessionsWeeksBag $sessionsBag;

    private Collection $extraSessionsAvailable;

    private SessionOrder $sessionOrder;

    public function __construct (Enrollment $enrollment,
                                 Collection $experienceRegisters,
                                 SessionRegister $sessionRegister,
                                 SessionsCollection $sessionWeeks,
                                 ReviewsStatsCollection $reviewsStatsCollection,
                                 SessionsWeeksBag $sessionsBag,
                                 Collection $extraSessionsAvailable, SessionOrder $sessionOrder){

        $this->enrollment = $enrollment;
        $this->experienceRegisters = $experienceRegisters;
        $this->sessionRegister = $sessionRegister;
        $this->sessionWeeks = $sessionWeeks;
        $this->reviewsStatsCollection = $reviewsStatsCollection;
        $this->sessionsBag = $sessionsBag;
        $this->extraSessionsAvailable = $extraSessionsAvailable;
        $this->sessionOrder = $sessionOrder;
    }

    public function enrollment(): Enrollment
    {
        return $this->enrollment;
    }

    public function experienceRegisters(): Collection
    {
        return $this->experienceRegisters;
    }

    public function experienceRegistersSorted ():Collection{

        $timezone = $this->enrollment->user->timezone;

        return $this->experienceRegisters->sortBy(function ($experienceRegister) use($timezone){
            return $experienceRegister->experience->startTime($timezone)->toDatetimeString();
        });
    }

    public function sessionRegister(): SessionRegister
    {
        return $this->sessionRegister;
    }

    public function sessionWeeks(): SessionsCollection
    {
        return $this->sessionWeeks;
    }

    public function reviewsStatsCollection(): ReviewsStatsCollection
    {
        return $this->reviewsStatsCollection;
    }

    public function sessionsBag ():SessionsWeeksBag{
        return $this->sessionsBag;
    }

    public function extraSessionsAvailable(): Collection
    {
        return $this->extraSessionsAvailable;
    }

    public function sessionOrder(): SessionOrder
    {
        return $this->sessionOrder;
    }

    //-------------//

    public function course ():Course{
        return $this->enrollment->section->course;
    }

    public function student ():User{
        return $this->enrollment->user;
    }
}
