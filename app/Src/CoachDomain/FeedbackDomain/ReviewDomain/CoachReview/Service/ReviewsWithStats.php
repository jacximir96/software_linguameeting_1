<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service;

use Illuminate\Support\Collection;

class ReviewsWithStats
{
    private Collection $reviews;

    private int $total;

    private float $average;

    public function __construct(Collection $reviews, int $total, float $average)
    {
        $this->reviews = $reviews;
        $this->total = $total;
        $this->average = $average;
    }

    public function reviews(): Collection
    {
        return $this->reviews;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function average(): float
    {
        return $this->average;
    }

    public function hasReviews(): bool
    {
        return (bool) $this->reviews->count();
    }
}
