<?php

namespace App\Src\CourseDomain\SessionDomain\ReplacedCoach\Action\Command;

use App\Src\CourseDomain\SessionDomain\ReplacedCoach\Model\ReplacedCoach;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class ReplaceCoachCommand
{
    public function handle(Session $session, User $newCoach): ReplacedCoach
    {

        $new = new ReplacedCoach();
        $new->session_id = $session->id;
        $new->replaced_coach_id = $session->coach_id;
        $new->new_coach_id = $newCoach->id;
        $new->replaced_at = Carbon::now();
        $new->save();

        return $new;
    }
}
