<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Repository;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\ReviewOption\Model\ReviewOption;

class MoreSelected
{
    //construct
    private ReviewOption $reviewOption;

    private int $count;

    public function __construct(ReviewOption $reviewOption, int $count)
    {
        $this->reviewOption = $reviewOption;
        $this->count = $count;
    }

    public function reviewOption()
    {
        return $this->reviewOption;
    }

    public function count()
    {
        return $this->count;
    }

    public function emoji()
    {

        return match ($this->reviewOption->id) {

            1 => '❤️',
            2 => '🥰',
            3 => '🔥',
            4 => '✨',
            5 => '🌞',
            6 => '🎉',
            7 => '👨‍🎤',
            8 => '😎',
            9 => '🧙',
            default => '',
        };
    }
}
