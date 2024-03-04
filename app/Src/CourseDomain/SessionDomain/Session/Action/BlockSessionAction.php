<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Action;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;

class BlockSessionAction
{
    public function handle(Session $session): Session
    {

        $session->is_blocked = ! $session->is_blocked;
        $session->save();

        return $session;
    }
}
