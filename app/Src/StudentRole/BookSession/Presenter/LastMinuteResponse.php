<?php
namespace App\Src\StudentRole\BookSession\Presenter;

use Illuminate\Support\Collection;


class LastMinuteResponse
{

    private Collection $sessions;

    public function __construct (Collection $sessions){

        $this->sessions = $sessions;
    }

    public function sessions(): Collection
    {
        return $this->sessions;
    }

    public function coaches ():Collection{

        $coaches = collect();

        foreach ($this->sessions as $session){

            if (!$coaches->has($session->coach_id)){
                $coaches->put($session->coach->id, $session->coach);
            }
        }

        return $coaches;
    }
}
