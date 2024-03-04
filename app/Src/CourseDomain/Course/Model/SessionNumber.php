<?php

namespace App\Src\CourseDomain\Course\Model;

class SessionNumber
{
    const MIN_SESSION_NUMBER = 1;

    const MAX_SESSION_NUMBER = 12;

    private int $sessions;

    private function __construct(int $sessions)
    {
        $this->sessions = $sessions;
    }

    public static function create(int $sessions): self
    {
        if ($sessions < self::MIN_SESSION_NUMBER) {
            throw new \Exception('Session number invalid.');
        }

        if ($sessions > self::MAX_SESSION_NUMBER) {
            throw new \Exception('Session number invalid.');
        }

        return new self($sessions);
    }

    public function get(): int
    {
        return $this->sessions;
    }
}
