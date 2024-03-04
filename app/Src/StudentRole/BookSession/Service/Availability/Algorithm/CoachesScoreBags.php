<?php
namespace App\Src\StudentRole\BookSession\Service\Availability\Algorithm;


use Illuminate\Support\Collection;

class CoachesScoreBags
{

    /**
     * @var Collection
     */
    private Collection $coachesScoreWithCourse;
    /**
     * @var Collection
     */
    private Collection $coachesScoreWithUniversity;
    /**
     * @var Collection
     */
    private Collection $othersCoachesScore;

    public function __construct (Collection $coachesScoreWithCourse, Collection $coachesScoreWithUniversity, Collection $othersCoachesScore){

        $this->coachesScoreWithCourse = $coachesScoreWithCourse;
        $this->coachesScoreWithUniversity = $coachesScoreWithUniversity;
        $this->othersCoachesScore = $othersCoachesScore;
    }

    /**
     * @return Collection
     */
    public function getCoachesScoreWithCourse(): Collection
    {
        return $this->coachesScoreWithCourse;
    }

    /**
     * @return Collection
     */
    public function getCoachesScoreWithUniversity(): Collection
    {
        return $this->coachesScoreWithUniversity;
    }

    /**
     * @return Collection
     */
    public function getOthersCoachesScore(): Collection
    {
        return $this->othersCoachesScore;
    }


}
