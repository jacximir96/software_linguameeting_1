<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service;

class ReviewsStats
{
    private int $total;

    private float $average;

    public function __construct(int $total, float $average)
    {
        $this->total = $total;
        $this->average = $average;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function average(): float
    {
        return $this->average;
    }
}
