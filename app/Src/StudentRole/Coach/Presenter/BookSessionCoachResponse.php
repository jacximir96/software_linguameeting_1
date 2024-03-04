<?php

namespace App\Src\StudentRole\Coach\Presenter;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewsStatsCollection;
use App\Src\StudentRole\BookSession\Service\Availability\Availability;
use App\Src\StudentRole\BookSession\Service\Availability\TimeHourSelected;

class BookSessionCoachResponse
{
    private Availability $availability;

    private ReviewsStatsCollection $reviewsStatsCollection;

    private TimeHourSelected $timeHourSelected;

    public function __construct(Availability $availability, ReviewsStatsCollection $reviewsStatsCollection, TimeHourSelected $timeHourSelected)
    {

        $this->availability = $availability;
        $this->reviewsStatsCollection = $reviewsStatsCollection;
        $this->timeHourSelected = $timeHourSelected;
    }

    public function availability(): Availability
    {
        return $this->availability;
    }

    public function reviewsStatsCollection(): ReviewsStatsCollection
    {
        return $this->reviewsStatsCollection;
    }

    public function timeHourSelected(): TimeHourSelected
    {
        return $this->timeHourSelected;
    }
}
