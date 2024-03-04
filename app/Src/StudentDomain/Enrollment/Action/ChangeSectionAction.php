<?php
namespace App\Src\StudentDomain\Enrollment\Action;


use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\CourseDomain\Section\Exception\SectionIsFull;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\NotificationDomain\Notification\Service\ChangeCollection;
use App\Src\NotificationDomain\Notification\Service\ChangedField;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment\SectionChangedNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\NotifiersBuilder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;
use Spatie\Activitylog\Models\Activity;

class ChangeSectionAction
{

    private Section $currentSection;

    private Section $newSection;

    private NotifiersBuilder $notifiersBuilder;

    public function __construct (NotifiersBuilder $notifiersBuilder){
        $this->notifiersBuilder = $notifiersBuilder;
    }

    public function handle(Enrollment $enrollment, Section $newSection, User $user):Enrollment{

        $this->initialize($enrollment, $newSection);

        $enrollment->section_id = $newSection->id;

        $this->publishNotificacion($enrollment, $user);

        $enrollment->save();

        $this->registerActivity($enrollment);

        return $enrollment;
    }

    private function initialize (Enrollment $enrollment, Section $newSection){

        $this->currentSection = $enrollment->section;
        $this->newSection = $newSection;

    }

    public function publishNotificacion (Enrollment $enrollment, User $user):Notification{

        $changeField = new ChangedField('section_id', $enrollment->getOriginal('section_id'), $enrollment->section_id);
        $changeCollection = new ChangeCollection();
        $changeCollection->addChange($changeField);

        $notifier = $this->notifiersBuilder->build(SectionChangedNotifier::KEY);

        return $notifier->publish($user, $enrollment, $changeCollection);
    }

    private function registerActivity(Enrollment $enrollment): Activity
    {
        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildSection($this->currentSection)->buildProperty('before', 'Before'),
            PropertyBuilder::buildSection($this->newSection)->buildProperty('after', 'After')
        );

        return activity()
            ->causedBy(user())
            ->performedOn($enrollment)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.student.section.change'));
    }
}
