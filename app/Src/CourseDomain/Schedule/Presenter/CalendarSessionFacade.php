<?php

namespace App\Src\CourseDomain\Schedule\Presenter;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\Occupation;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CalendarSessionFacade
{
    private Session $session;

    public function __construct(Session $session)
    {

        $this->session = $session;
    }

    public function session(): Session
    {
        return $this->session;
    }

    public function coach(): User
    {
        return $this->session->coach;
    }

    public function moment(): Carbon
    {
        return $this->session->startTime();
    }

    public function isDay(Carbon $date): bool
    {
        return $this->moment()->toDateString() == $date->toDateString();
    }

    public function occupation(): Occupation
    {
        return new Occupation($this->session->enrollmentSession->count(), $this->session->course->student_class);
    }

    public function key(): string
    {
        return $this->session->coach->id.'-'.$this->moment()->timestamp;
    }

    public function enrollments(): Collection
    {
        return $this->session->enrollmentSession;
    }
}
