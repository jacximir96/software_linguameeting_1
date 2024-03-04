<?php
namespace App\Src\ActivityLog\Service\Activities;

use App\Src\ActivityLog\Exception\SubjectTypeNotValid;
use App\Src\ActivityLog\Service\Formatter\FormatterBuilder;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\UserDomain\User\Model\User;
use App\Src\UserDomain\User\Repository\UserRepository;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;


class SectionSendDocumentationActivity implements \App\Src\ActivityLog\Service\Activities\Activity
{
    use Printable;

    private Section $section;

    private Activity $activity;

    public function __construct(Activity $activity)
    {
        $this->checkSubjectType($activity);

        $this->activity = $activity;
        $this->section = $activity->subject;
    }

    public function activity(): Activity
    {
        return $this->activity;
    }

    public function nameModel(): string
    {
        return 'Section';
    }

    public function formattedProperties():Collection{

        $properties = $this->activity->properties();

        $formatter = app(FormatterBuilder::class);
        $formatedData = $formatter->buildFormatters($properties);

        return $formatedData;
    }

    public function trans ():string{
        return $this->activity->trans().': '.$this->section->name;
    }

    public function sender():User{
        return $this->activity->causer;
    }

    public function recipient():User{

        $properties = $this->activity->properties();

        $recipient = $properties->getProperty('recipient');

        return UserRepository::findTrashed($recipient['id']);
    }

    private function checkSubjectType(Activity $activity)
    {
        if ($activity->subject_type != Section::MORPH) {
            throw new SubjectTypeNotValid();
        }
    }
}
