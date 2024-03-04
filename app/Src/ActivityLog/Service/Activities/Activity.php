<?php

namespace App\Src\ActivityLog\Service\Activities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface Activity
{
    public function activity(): \Spatie\Activitylog\Models\Activity;

    public function formattedProperties():Collection;

    public function nameModel():string;

    public function trans():string;
}
