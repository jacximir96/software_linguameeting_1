<?php
namespace App\Src\CourseDomain\CoachingWeek\Service;

use Illuminate\Support\Collection;


class CoachingWeeksChecker
{

    public function obtainDifference (Collection $beforeCoachingWeeks, Collection $afterCoachingWeeks):CoachingWeeksDifference{

        $newCoachingWeeks = $this->obtainNewsCoachingWeeks($beforeCoachingWeeks, $afterCoachingWeeks);

        $deletedCoachingWeeks = $this->obtainDeletedCoachingWeeks($beforeCoachingWeeks, $afterCoachingWeeks);

        return new CoachingWeeksDifference($newCoachingWeeks, $deletedCoachingWeeks);
    }

    private function obtainNewsCoachingWeeks (Collection $beforeCoachingWeeks, Collection $afterCoachingWeeks):Collection{

        $newCoachingWeeks = collect();

        foreach ($afterCoachingWeeks as $afterCoachingWeek){

            $exists = false;
            foreach ($beforeCoachingWeeks as $beforeCoachingWeek){
                if ($beforeCoachingWeek->period()->eq($afterCoachingWeek->period())){
                    $exists = true;
                    break;
                }
            }

            if ( ! $exists){
                $newCoachingWeeks->push($afterCoachingWeek);
            }
        }

        return $newCoachingWeeks;
    }

    private function obtainDeletedCoachingWeeks (Collection $beforeCoachingWeeks, Collection $afterCoachingWeeks):Collection{

        $deletedCoachingWeeks = collect();
        foreach ($beforeCoachingWeeks as $beforeCoachingWeek){

            $exists = false;
            foreach ($afterCoachingWeeks as $afterCoachingWeek){
                if ($beforeCoachingWeek->period()->eq($afterCoachingWeek->period())){
                    $exists = true;
                    break;
                }
            }

            if ( ! $exists){
                $deletedCoachingWeeks->push($beforeCoachingWeek);
            }
        }

        return $deletedCoachingWeeks;
    }
}
