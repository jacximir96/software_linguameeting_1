<?php
namespace App\Src\StudentRole\BookSession\Service\Availability\Algorithm;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CoachDomain\CoachSchedule\Repository\CoachScheduleRepository;
use App\Src\CoachDomain\CoachSchedule\Service\Occupation;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\StudentRole\BookSession\Service\Availability\CoachFreeSlots;
use App\Src\TimeDomain\Semester\Model\Semester;
use App\Src\UserDomain\User\Model\User;


/**
 * Dada una clase CoachFreeSlots (coach + collectiond de freeSlots) hace todos los cálculos para el TotalScore
 *
 * Class ScoreCoachCalculator
 * @package App\Src\StudentRole\BookSession\Service\Availability\Algorithm
 */
class ScoreCoachCalculator
{
    const SCORE_COACH_WITH_SESSIONS_NOT_FULL = 100;

    //construct
    private CoachReviewRepository $coachReviewRepository;

    private CoachScheduleRepository $coachScheduleRepository;


    //status
    private User $coach;

    private CoachFreeSlots $coachFreeSlots;

    private Filter $filter;


    public function __construct (CoachReviewRepository $coachReviewRepository, CoachScheduleRepository $coachScheduleRepository,){
        $this->coachReviewRepository = $coachReviewRepository;
        $this->coachScheduleRepository = $coachScheduleRepository;
    }

    public function handle(CoachFreeSlots $coachFreeSlots, Filter $filter):CoachScore{

        $this->initialize($coachFreeSlots, $filter);

        $score = $this->obtainPreferenceValue() + $this->obtainAverageRating();

        $hasFreeSession = false;
        if ($this->checkHasSessionFree()){
            $score += self::SCORE_COACH_WITH_SESSIONS_NOT_FULL;
            $hasFreeSession = true;
        }

        $occupationPercentage = $this->obtainOccupationPercentage();
        $occupationPercentage = $occupationPercentage->occupationPercentage();

        return new CoachScore($coachFreeSlots->coach(), $score, $occupationPercentage, $hasFreeSession);
    }

    private function initialize (CoachFreeSlots $coachFreeSlots, Filter $filter){
        $this->coach = $coachFreeSlots->coach();
        $this->coachFreeSlots = $coachFreeSlots;
        $this->filter = $filter;
    }

    private function obtainPreferenceValue ():int{
        return $this->coach->coachInfo->preference ?? 0;
    }

    private function obtainAverageRating ():float{
        return $this->coachReviewRepository->averageByCoach($this->coach);
    }

    private function checkHasSessionFree ():bool{

        foreach ($this->coachFreeSlots->freeSlots() as $freeSlot){

            $coachSchedule = $freeSlot->coachSchedules()->first();

            if ( ! $coachSchedule->hasSession()){
                continue;
            }

            $dateSlotFromCoachSchedule = $coachSchedule->toSlot();

            $hasSameStartTime = $dateSlotFromCoachSchedule->isStartEqual($this->filter->getDateSlot()->start());
            if ($hasSameStartTime){

                if ($this->checkCoachScheduleHasSessionWithSameCourseAndNotComplete($coachSchedule, $this->filter->getCourse())){
                    return true;
                }
            }
        }

        return false;
    }

    private function checkCoachScheduleHasSessionWithSameCourseAndNotComplete (CoachSchedule $coachSchedule, Course $course):bool{

        if (is_null($coachSchedule->session)){
            return false;
        }

        if ($coachSchedule->course()->isSame($course)){

            $occupation = $coachSchedule->session->occupation();

            if ( ! $occupation->isFull()){
                return true;
            }
        }

        return false;
    }

    private function obtainOccupationPercentage():Occupation{

        $semester = new Semester();

        $period = $semester->period();

        return $this->coachScheduleRepository->obtainOccupationPercentageByCoachAndPeriod($this->coach, $period);
    }
}
