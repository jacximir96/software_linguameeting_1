<?php
namespace App\Src\CourseDomain\Course\Model\Trait;


use App\Src\Survey\Model\Survey;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait SurveyTrait
{


    public function survey(): MorphMany
    {
        return $this->morphMany(Survey::class, 'surveyable');
    }

    public function currentSurvey ():Survey{




    }

    public function mustShowSurvey():bool{

        if ($this->isFlex()){

            $period = $this->period();
            $startCourseLastWeek = $period->getEndDate()->clone()->subWeek()->startOfDay();
            $now = Carbon::now();

            $lastWeek = CarbonPeriod::create($startCourseLastWeek, $period->getEndDate());

            return $lastWeek->contains($now);
        }

        if ( ! $this->hasCoachingWeek()){
            return false;
        }

        $lastWeek = $this->coachingWeeksOrderedWithoutMakeUps()->last();
        $dateStart = $lastWeek->end_date->clone()->subWeek()->startOfDay();

        $period = CarbonPeriod::create($dateStart, $this->end_date);
        $now = Carbon::now();

        return $period->contains($now);
    }

}
