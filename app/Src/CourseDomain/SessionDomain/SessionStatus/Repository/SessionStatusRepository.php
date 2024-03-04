<?php

namespace App\Src\CourseDomain\SessionDomain\SessionStatus\Repository;

use App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus;

class SessionStatusRepository
{
    public function findUnspecified()
    {
        return SessionStatus::where('slug', SessionStatus::SLUG_UNSPECIFIED)->first();
    }

    public function findAttended()
    {
        return SessionStatus::where('slug', SessionStatus::SLUG_ATTENDANCE)->first();
    }

    public function findMissed()
    {
        return SessionStatus::where('slug', SessionStatus::SLUG_MISSED)->first();
    }
}
