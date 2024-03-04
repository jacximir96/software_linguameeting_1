<?php

namespace App\Http\Controllers;

use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function userTimezone ():TimeZone{

        return TimeZoneRepository::findByName(userTimezoneName());

    }

    protected function experienceTimezone ():TimeZone{

        return TimeZoneRepository::findByName(config('linguameeting.timezone.by_default_in_experiences'));

    }
}
