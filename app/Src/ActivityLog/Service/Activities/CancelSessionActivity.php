<?php
namespace App\Src\ActivityLog\Service\Activities;

use App\Src\ActivityLog\Service\Formatter\FormatterBuilder;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;


class CancelSessionActivity implements \App\Src\ActivityLog\Service\Activities\Activity
{
    use Printable, Formattable;

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
        return 'Session';
    }

    public function trans ():string{
        return $this->activity->trans();
    }

    public function formattedProperties():Collection{

        $properties = $this->activity->properties();

        $formatter = app(FormatterBuilder::class);
        $formatedData = $formatter->buildFormatters($properties);

        $enrollmentSession = $properties->obtainEnrollmentSession();
        $formatedData->push($formatter->sessionOrderFormatter($enrollmentSession->sessionOrder()));

        return $formatedData;
    }
}
