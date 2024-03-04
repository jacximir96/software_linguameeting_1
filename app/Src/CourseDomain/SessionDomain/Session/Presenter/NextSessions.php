<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Presenter;


use Illuminate\Support\Collection;


class NextSessions
{

    public Collection $availables;

    public Collection $existing;

    public Collection $notAvailables;

    public function __construct(){
        $this->availables = collect();
        $this->existing = collect();
        $this->notAvailables = collect();
    }

    public function addNextSessionAvailable(NextSessionAvailable $nextSessionAvailable){
        $this->availables->push($nextSessionAvailable);
    }

    public function addNextSessionExisting (NextSessionExisting $nextSessionExisting){
        $this->existing->push($nextSessionExisting);
    }

    public function addNextSessionNotAvailable(NextSessionNotAvailable $nextSessionNotAvailable){
        $this->notAvailables->push($nextSessionNotAvailable);
    }

    public function hasNextSessions ():bool{

        if ($this->availables->count()){
            return true;
        }

        return false;
    }
}
