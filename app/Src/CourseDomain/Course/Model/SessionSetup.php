<?php

namespace App\Src\CourseDomain\Course\Model;

class SessionSetup
{
    private SessionNumber $sessionNumber;

    private SessionDuration $sessionDuration;

    private function __construct(SessionNumber $sessionNumber, SessionDuration $sessionDuration)
    {
        $this->sessionNumber = $sessionNumber;
        $this->sessionDuration = $sessionDuration;
    }

    public static function createWithInteger(int $sessionNumber, int $sessionDuration)
    {
        $sessionNumber = SessionNumber::create($sessionNumber);

        $sessionDuration = SessionDuration::create($sessionDuration);

        return new static ($sessionNumber, $sessionDuration);
    }

    public function sessionNumber(): SessionNumber
    {
        return $this->sessionNumber;
    }

    public function sessionDuration(): SessionDuration
    {
        return $this->sessionDuration;
    }
}
