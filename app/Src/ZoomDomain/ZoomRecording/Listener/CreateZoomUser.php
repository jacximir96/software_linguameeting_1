<?php

namespace App\Src\ZoomDomain\ZoomRecording\Listener;

use App\Src\UserDomain\User\Model\User;

interface CreateZoomUser
{
    public function user(): User;
}
