<?php
namespace App\Src\ActivityLog\Service\Activities;

use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;


class StudentCreateActivity implements \App\Src\ActivityLog\Service\Activities\Activity
{
    use Printable;

    private Activity $activity;

    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    public function activity(): Activity
    {
        return $this->activity;
    }

    public function nameModel(): string
    {
        return 'User Create';
    }

    public function trans ():string{
        return $this->activity->trans();
    }

    public function formattedProperties():Collection{

        $formatters = collect();
        $properties = $this->activity->properties();

        if ($properties->hasIp()){
            $formatters->push($properties->ipFormatter());
        }

        return $formatters;
    }
}
