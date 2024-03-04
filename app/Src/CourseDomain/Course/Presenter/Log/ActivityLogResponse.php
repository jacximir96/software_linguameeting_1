<?php

namespace App\Src\CourseDomain\Course\Presenter\Log;

use App\Src\ActivityLog\Service\ActivityCollect;

class ActivityLogResponse
{
    private ActivityCollect $activityCollect;

    public function __construct(ActivityCollect $activityCollect)
    {

        $this->activityCollect = $activityCollect;
    }

    public function activityCollect(): ActivityCollect
    {
        return $this->activityCollect;
    }
}
