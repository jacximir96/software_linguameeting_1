<?php

namespace App\Src\CourseDomain\Flex\Service;

use Illuminate\Support\Collection;

class FlexSessions
{
    private Collection $sessions;

    public function __construct()
    {
        $this->sessions = collect();
    }

    public function get(): Collection
    {
        return $this->sessions;
    }

    public function addSession(FlexSession $sessionFlex)
    {
        $this->sessions->push($sessionFlex);
    }
}
