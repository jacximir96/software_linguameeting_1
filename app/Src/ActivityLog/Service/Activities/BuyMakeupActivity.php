<?php
namespace App\Src\ActivityLog\Service\Activities;

use App\Src\ActivityLog\Service\Formatter\FormatterBuilder;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;


class BuyMakeupActivity implements \App\Src\ActivityLog\Service\Activities\Activity
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
        return 'Makeup';
    }

    public function trans ():string{
        return $this->activity->trans();
    }

    public function formattedProperties():Collection{

        $formatters = collect();
        $formatterBuilder = app(FormatterBuilder::class);

        //las propiedas extras para formatear no están en la columna properties sino en el propio makeup
        $makeup = $this->activity->subject;

        $formatter = $formatterBuilder->courseFormatter($makeup->enrollment->course());
        $formatters->push($formatter);

        $formatter = $formatterBuilder->makeupTypeFormatter($makeup);
        $formatters->push($formatter);

        $formatter = $formatterBuilder->makeupFreeFormatter($makeup);
        $formatters->push($formatter);

        return $formatters;
    }

}
