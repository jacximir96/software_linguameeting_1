<?php
namespace App\Src\ActivityLog\Service;


use Carbon\Carbon;

class MomentLogin
{

    private ?Carbon $moment = null;

    public function __construct (?Carbon $moment = null){
        $this->moment = $moment;
    }

    public function hasMoment ():bool{
        return !is_null($this->moment);
    }

    public function moment ():Carbon{
        return $this->moment;
    }
}
