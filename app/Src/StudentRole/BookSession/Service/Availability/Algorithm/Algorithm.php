<?php
namespace App\Src\StudentRole\BookSession\Service\Availability\Algorithm;

use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;
use Illuminate\Support\Collection;


class Algorithm
{
    //construct
    private ScoreCoachCalculator $scoreCalculator;

    private SessionRepository $sessionRepository;

    private CoachesSorter $coachesSorter;

    //status
    private Collection $coachFreeSlots;
    private Filter $filter;
    private CoachesScored $allCoachesScored;
    private CoachesScored $coachesScoredWithSessionsWithGaps;

    private CoachesScored $finalCoachesScored;

    private int $numCoachesMustBeReturned;

    public function __construct (ScoreCoachCalculator $scoreCalculator, SessionRepository $sessionRepository, CoachesSorter $coachesSorter){
        $this->scoreCalculator = $scoreCalculator;
        $this->sessionRepository = $sessionRepository;
        $this->coachesSorter = $coachesSorter;

        $this->finalCoachesScored = app(CoachesScored::class);

        $this->numCoachesMustBeReturned = config('linguameeting.session.algorithm.num_coaches_returned');
    }

    public function sort(Collection $coachFreeSlots, Filter $filter):CoachesScored{

        $this->initialize($coachFreeSlots, $filter);

        $this->calculateTotalScore();

        if ($this->coachesScoredWithSessionsWithGaps->countCoachScores() == $this->numCoachesMustBeReturned){
            return $this->coachesScoredWithSessionsWithGaps;
        }

        $coachesScoreBags = $this->shareCoachesInCollections($filter);

        $this->createFinalListWithCoachesScores($coachesScoreBags);

        return $this->finalCoachesScored;
    }

    private function initialize (Collection $coachFreeSlots, Filter $filter){

        $this->coachFreeSlots = $coachFreeSlots;
        $this->filter = $filter;

        $this->allCoachesScored = new CoachesScored();
        $this->coachesScoredWithSessionsWithGaps = new CoachesScored();
    }

    //realiza el cálculo del score para cada coach en cada slot
    private function calculateTotalScore ():void{

        foreach ($this->coachFreeSlots as $coachFreeSlot){

            $coachScore = $this->scoreCalculator->handle($coachFreeSlot, $this->filter);

            $this->allCoachesScored->addCoachScore($coachScore);

            if ($coachScore->hasFreeSession()){

                $this->coachesScoredWithSessionsWithGaps->addCoachScore($coachScore);

                if ($this->coachesScoredWithSessionsWithGaps->countCoachScores() >= $this->numCoachesMustBeReturned){
                    return;
                }
            }
        }
    }

    private function shareCoachesInCollections (Filter $filter):CoachesScoreBags{

        $coachesWithCourse = collect();
        $coachesWithUniversity = collect();
        $otherCoaches = collect();

        foreach ($this->allCoachesScored->coachScores() as $coachScore){

            $numSessionsInCourse = $this->sessionRepository->numSessionsCoachWithCourse($coachScore->coach(), $filter->getCourse());
            if ($numSessionsInCourse){
                $coachesWithCourse->push($coachScore);
                continue;
            }

            $numSessionsInUniversity = $this->sessionRepository->numSessionsCoachWithUniversity($coachScore->coach(), $filter->getCourse()->university);
            if ($numSessionsInUniversity){
                $coachesWithUniversity->push($coachScore);
                continue;
            }

            $otherCoaches->push($coachScore);
        }

        return new CoachesScoreBags($coachesWithCourse, $coachesWithUniversity, $otherCoaches);
    }

    //escoge los X coaches más relevantes, primero de la colección del curso, luego de la universidad y luego de los otros
    public function createFinalListWithCoachesScores (CoachesScoreBags $coachesScoreBags):void{

        //process coaches with session in course
        $coachesScores = $this->coachesSorter->sortCourseCoaches($coachesScoreBags->getCoachesScoreWithCourse());
        foreach ($coachesScores as $coachScore){

            $this->finalCoachesScored->addCoachScore($coachScore);
            if ( ! $this->weMustContinueProcess()){
                return;
            }
        }

        //process coaches with session in university
        $coachesScores = $this->coachesSorter->sortCourseCoaches($coachesScoreBags->getCoachesScoreWithUniversity());
        foreach ($coachesScores as $coachScore){

            $this->finalCoachesScored->addCoachScore($coachScore);
            if ( ! $this->weMustContinueProcess()){
                return;
            }
        }

        //process rest of coaches
        $coachesScores = $this->coachesSorter->sortOtherCoaches($coachesScoreBags->getOthersCoachesScore());
        foreach ($coachesScores as $coachScore){

            $this->finalCoachesScored->addCoachScore($coachScore);
            if ( ! $this->weMustContinueProcess()){
                return;
            }
        }
    }

    private function weMustContinueProcess():bool{
        return $this->finalCoachesScored->countCoachScores() < $this->numCoachesMustBeReturned;
    }
}
