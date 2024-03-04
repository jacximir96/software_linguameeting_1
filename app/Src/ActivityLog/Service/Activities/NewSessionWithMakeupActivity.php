<?php
namespace App\Src\ActivityLog\Service\Activities;

use App\Src\ActivityLog\Service\Formatter\FormatterBuilder;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\StudentDomain\Makeup\Repository\MakeupRepository;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;


class NewSessionWithMakeupActivity implements \App\Src\ActivityLog\Service\Activities\Activity
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

        $formatterBuilder = app(FormatterBuilder::class);
        $formatters = collect();

        //las propiedas extras para formatear no están en la columna properties sino en el propio makeup
        $enrollmentSession = EnrollmentSessionRepository::findTrashed($this->activity->subject_id);

        $formatter = $formatterBuilder->courseFormatter($enrollmentSession->enrollment->course());
        $formatters->push($formatter);

        $formatter = $formatterBuilder->sessionOrderFormatter($enrollmentSession->sessionOrder());
        $formatters->push($formatter);

        $makeup = MakeupRepository::findTrashed($enrollmentSession->makeup_id);

        $formatter = $formatterBuilder->makeupTypeFormatter($makeup);
        $formatters->push($formatter);

        $formatter = $formatterBuilder->makeupFreeFormatter($makeup);
        $formatters->push($formatter);

        return $formatters;
    }
}
