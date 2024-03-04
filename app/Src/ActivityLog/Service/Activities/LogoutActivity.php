<?php
namespace App\Src\ActivityLog\Service\Activities;

use App\Src\ActivityLog\Service\Formatter\FormatterBuilder;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;


class LogoutActivity implements \App\Src\ActivityLog\Service\Activities\Activity
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
        return 'User';
    }

    public function trans ():string{
        return $this->activity->trans();
    }

    public function formattedProperties():Collection{

        $properties = $this->activity->properties();

        $formatter = app(FormatterBuilder::class);
        $formatedData = $formatter->buildFormatters($properties);

        return $formatedData;
    }
}
