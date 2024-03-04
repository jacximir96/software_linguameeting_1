<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Presenter;


use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;

class NextSessionNotAvailable
{

    private CoachingWeek $coachingWeek;

    public function __construct (CoachingWeek $coachingWeek){
        $this->coachingWeek = $coachingWeek;
    }


}
