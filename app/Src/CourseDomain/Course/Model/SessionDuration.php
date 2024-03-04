<?php

namespace App\Src\CourseDomain\Course\Model;

class SessionDuration
{
    private int $duration;

    private function __construct(int $duration)
    {
        $this->duration = $duration;
    }

    public static function create(int $duration): self
    {
        $existsDuration = in_array($duration, config('linguameeting.session_duration'));

        if (! $existsDuration) {
            throw new \Exception('Session duration invalid.');
        }

        return new self($duration);
    }

    public function get(): int
    {
        return $this->duration;
    }
}
