<?php
namespace App\Src\StudentDomain\Enrollment\Presenter\StudentRole;


use Illuminate\Support\Collection;


class SessionsCollection
{
    /**
     * @var Collection CoachingWeeks | FlexSession
     */
    private Collection $sessions;

    public function __construct(Collection $sessions){

        $this->sessions = $sessions;
    }

    public function get():Collection{
        return $this->sessions;
    }

    public function count():int{
        return $this->sessions->count();
    }

    public function orderByNumberSession ():Collection{

        return $this->sessions->sortBy(function ($sessionWeek){
            //dd($sessionWeek);
            return $sessionWeek->sessionOrderObject()->get();
        });
    }
}
