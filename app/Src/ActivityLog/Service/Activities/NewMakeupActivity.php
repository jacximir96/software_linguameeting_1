<?php
namespace App\Src\ActivityLog\Service\Activities;

use App\Src\ActivityLog\Service\Formatter\FormatterBuilder;
use App\Src\StudentDomain\Makeup\Repository\MakeupRepository;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;


//asignar makeup desde el curso o la sección
class NewMakeupActivity implements \App\Src\ActivityLog\Service\Activities\Activity
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
        return 'User';
    }

    public function trans ():string{
        return $this->activity->trans();
    }

    public function formattedProperties():Collection{

        $formatterBuilder = app(FormatterBuilder::class);
        $formatters = collect();

        //las propiedas extras para formatear no están en la columna properties sino en el propio makeup
        $makeup = MakeupRepository::findTrashed($this->activity->subject_id);

        $formatter = $formatterBuilder->courseFormatter($makeup->enrollment->course());
        $formatters->push($formatter);


        if ($this->activity->description == config('linguameeting_log.activity.keys.section.makeup.create')){
            $formatter = $formatterBuilder->sectionFormatter($makeup->enrollment->section);
            $formatters->push($formatter);
        }

        $formatter = $formatterBuilder->makeupTypeFormatter($makeup);
        $formatters->push($formatter);

        $formatter = $formatterBuilder->makeupFreeFormatter($makeup);
        $formatters->push($formatter);

        return $formatters;
    }

}
