<?php
namespace App\Src\StudentRole\BookSession\Service\Availability\Algorithm;

use Illuminate\Support\Collection;


class CoachesSorter
{

    public function sortCourseCoaches (Collection $originalCoachesCollection):Collection{

        $coachesSorted = $this->fillCollectionWithScores($originalCoachesCollection)
            ->sortBy([
                ['hasFreeSession', 'desc'],
                ['score', 'desc'],
                ['occupationPercentage' , 'asc'],
                ['ranking' , 'asc'],
            ]);

        return $this->sortOriginal($coachesSorted, $originalCoachesCollection);
    }

    public function sortUniversityCoaches (Collection $originalCoachesCollection):Collection{

        $coachesSorted = $this->fillCollectionWithScores($originalCoachesCollection)
            ->sortBy([
                ['hasFreeSession', 'desc'],
                ['score', 'desc'],
                ['occupationPercentage' , 'asc'],
                ['ranking' , 'asc'],
            ]);

        return $this->sortOriginal($coachesSorted, $originalCoachesCollection);
    }


    public function sortOtherCoaches (Collection $originalCoachesScores):Collection{

        $coachesSorted = $this->fillCollectionWithScores($originalCoachesScores)
            ->sortBy([
                ['score', 'desc'],
                ['occupationPercentage' , 'asc'],
                ['ranking' , 'asc'],
            ]);

        return $this->sortOriginal($coachesSorted, $originalCoachesScores);
    }

    private function fillCollectionWithScores(Collection $original):Collection{

        return $original->map(function ($coachScore){
            return [
                'coach_id' => $coachScore->coach()->id,
                'score' => $coachScore->score(),
                'hasFreeSession' => $coachScore->hasFreeSession(),
                'occupationPercentage' => $coachScore->occupationPercentage(),
                'ranking' => $coachScore->coach()->coachInfo->ranking,
            ];
        });
    }

    private function sortOriginal(Collection $coachesScoredSorted, Collection $originalCoachesCollection): Collection
    {
        $othersSorted = collect();

        foreach ($coachesScoredSorted as $coachScoreSorted) {

            $coachScored = $originalCoachesCollection->filter(function ($coachScore) use ($coachScoreSorted) {

                if ($coachScore->coach()->id == $coachScoreSorted['coach_id']) {
                    return $coachScore;
                }
            })->first();

            $othersSorted->put($coachScored->coach()->id, $coachScored);
        }

        return $othersSorted;
    }
}
