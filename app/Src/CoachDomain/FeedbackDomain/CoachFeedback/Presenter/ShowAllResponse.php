<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Presenter;

use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service\Feedbacks;
use Illuminate\Pagination\LengthAwarePaginator;

class ShowAllResponse
{
    private Feedbacks $feedbacks;

    private LengthAwarePaginator $lengthAwarePaginator;

    public function __construct(Feedbacks $feedbacks, LengthAwarePaginator $lengthAwarePaginator)
    {

        $this->feedbacks = $feedbacks;
        $this->lengthAwarePaginator = $lengthAwarePaginator;
    }

    public function feedbacks(): Feedbacks
    {
        return $this->feedbacks;
    }

    public function paginator(): LengthAwarePaginator
    {
        return $this->lengthAwarePaginator;
    }
}
