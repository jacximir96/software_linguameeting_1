<?php

namespace App\Src\CourseDomain\SessionDomain\Session\SessionReview\Service;

use App\Src\CourseDomain\SessionDomain\Session\SessionReview\Model\Review;
use Carbon\Carbon;

class SessionReviewFake implements Review
{
    public function date(): Carbon
    {
        return Carbon::now();
    }

    public function rating(): float
    {
        return 5.4;
    }

    public function student(): string
    {
        return 'Pablo Picasso';
    }

    public function university(): string
    {
        return 'University of Texas';
    }

    public function comment(): string
    {
        return 'Category content...';
    }
}
