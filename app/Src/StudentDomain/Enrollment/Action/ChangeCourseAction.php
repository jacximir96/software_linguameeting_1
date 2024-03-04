<?php
namespace App\Src\StudentDomain\Enrollment\Action;

use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\ConversationPackageDomain\Package\Exception\NumberSessionsNotEqual;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\NotificationDomain\Notification\Service\ChangeCollection;
use App\Src\NotificationDomain\Notification\Service\ChangedField;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment\CourseChangedNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\NotifiersBuilder;
use App\Src\StudentDomain\Enrollment\Action\Command\ChangeStatusCommand;
use App\Src\StudentDomain\Enrollment\Action\Command\CreateEnrollmentCommand;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\EnrollmentStatus\Service\EnrollmentStatusBuilder;
use App\Src\UserDomain\User\Model\User;
use Spatie\Activitylog\Models\Activity;


class ChangeCourseAction
{
    //construct
    private NotifiersBuilder $notifiersBuilder;

    private ChangeStatusCommand $changeStatusCommand;

    private CreateEnrollmentCommand $createEnrollmentCommand;

    //status
    private Enrollment $currentEnrollment;

    private Enrollment $newEnrollment;

    private Section $currentSection;

    private Section $newSection;


    public function __construct (NotifiersBuilder $notifiersBuilder, ChangeStatusCommand $changeStatusCommand , CreateEnrollmentCommand $createEnrollmentCommand){
        $this->notifiersBuilder = $notifiersBuilder;
        $this->changeStatusCommand = $changeStatusCommand;
        $this->createEnrollmentCommand = $createEnrollmentCommand;
    }

    public function handle(Enrollment $enrollment, Section $newSection, User $user):Enrollment{

        $this->initialize($enrollment, $newSection);

        $this->checkCourseIsCompatible();

        $this->changeStatusCurrentEnrollment();

        $this->createNewEnrollment();

        $this->linkCurrentWithNewEnrollment();

        $this->copyAccommodation();

        $this->registerActivity();

        $this->publishNotificacion($user);

        return $this->newEnrollment;
    }

    private function initialize (Enrollment $enrollment, Section $newSection){
        $this->currentEnrollment = $enrollment;
        $this->currentSection = $enrollment->section;
        $this->newSection = $newSection;
    }

    private function checkCourseIsCompatible ():bool{

        if ($this->currentSection->course->conversationPackage->isSame($this->newSection->course->conversationPackage)){
            return true;
        }

        $currentSessionSetup = $this->currentSection->course->conversationPackage->obtainSessionSetup();
        $newSessionSetup = $this->currentSection->course->conversationPackage->obtainSessionSetup();

        if ($currentSessionSetup->sessionNumber() >= $newSessionSetup->sessionNumber()){
            return true;
        }

        throw new NumberSessionsNotEqual();
    }

    private function changeStatusCurrentEnrollment (){

        $status = EnrollmentStatusBuilder::buildChanged();

        $this->currentEnrollment = $this->changeStatusCommand->handle($this->currentEnrollment, $status);
    }

    private function createNewEnrollment (){

        $this->newEnrollment = $this->createEnrollmentCommand->handle($this->currentEnrollment->user, $this->newSection);
    }

    private function linkCurrentWithNewEnrollment (){
        //guardamos en la nueva matríula el id de la original
        $this->newEnrollment->origin_enrollment_id = $this->currentEnrollment->id;
        $this->newEnrollment->save();
    }

    private function copyAccommodation (){

        if ($this->currentEnrollment->accommodation){

            $accommodation = $this->currentEnrollment->accommodation;

            $newAccommodation = $accommodation->replicate();
            $newAccommodation->enrollment_id = $this->newEnrollment->id;
            $newAccommodation->save();
        }
    }

    private function registerActivity(): Activity
    {
        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildEnrollment($this->currentEnrollment)->buildProperty('before', 'Before'),
            PropertyBuilder::buildEnrollment($this->newEnrollment)->buildProperty('after', 'After')
        );

        return  activity()
            ->causedBy(user())
            ->performedOn($this->currentEnrollment)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.student.course.change'));
    }

    private function publishNotificacion (User $user):Notification{

        $changeField = new ChangedField('section_id', $this->currentSection->id, $this->newSection->id);
        $changeCollection = new ChangeCollection();
        $changeCollection->addChange($changeField);

        $notifier = $this->notifiersBuilder->build(CourseChangedNotifier::KEY);

        return $notifier->publish($user, $this->newEnrollment, $changeCollection);
    }
}
