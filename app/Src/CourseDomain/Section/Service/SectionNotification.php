<?php
namespace App\Src\CourseDomain\Section\Service;

use App\Src\NotificationDomain\Notification\Service\ChangeCollection;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Key;
use App\Src\NotificationDomain\Notification\Service\Notifiers\NotifiersBuilder;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Section\InstructorNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Section\SectionCreatedNotifier;
use App\Src\UserDomain\User\Model\User;


class SectionNotification
{
    //construct
    private NotifiersBuilder $notifiersBuilder;

    //status
    private User $user;
    private SectionChanges $sectionChanges;


    public function __construct (NotifiersBuilder $notifiersBuilder){

        $this->notifiersBuilder = $notifiersBuilder;
    }

    public function publish(User $user, SectionChanges $sectionChanges){

        $this->initialize($user, $sectionChanges);

        if ($sectionChanges->isNew()){
            $this->registerNewCourse();
        }
        else{
            $this->registerInstructorChange();
        }
    }

    private function initialize (User $user, SectionChanges $courseChanges){
        $this->user = $user;
        $this->sectionChanges = $courseChanges;
    }

    private function registerNewCourse (){
        $this->registerChanges($this->sectionChanges->changeInSectionCreated(),$this->buildKey(SectionCreatedNotifier::KEY));
    }

    private function registerInstructorChange (){
        $this->registerChanges($this->sectionChanges->changeInstructor(),$this->buildKey(InstructorNotifier::KEY));
    }

    private function buildKey (string $value):Key{
        return new Key($value);
    }

    private function registerChanges(ChangeCollection $changeCollection, Key $key){

        if ($changeCollection->hasChanges()){
            $notifier = $this->notifiersBuilder->build($key->get());
            $notifier->publish($this->user, $this->sectionChanges->section(), $changeCollection);
        }
    }
}
