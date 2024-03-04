<?php
namespace App\Src\CourseDomain\Course\Service;

use App\Src\NotificationDomain\Notification\Service\ChangeCollection;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\CoachingWeeksNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\ConversationGuideNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\ConversationPackageNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\CourseCreatedNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\CourseDatesNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\DiscountNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\HolidaysNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\IsFreeNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\LanguageNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\NameNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\SemesterNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Course\StudentClassNotifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Key;
use App\Src\NotificationDomain\Notification\Service\Notifiers\NotifiersBuilder;
use App\Src\UserDomain\User\Model\User;


class CourseNotification
{
    //construct
    private NotifiersBuilder $notifiersBuilder;

    //status
    private User $user;
    private CourseChanges $courseChanges;


    public function __construct (NotifiersBuilder $notifiersBuilder){

        $this->notifiersBuilder = $notifiersBuilder;
    }

    public function publish(User $user, CourseChanges $courseChanges){

        $this->initialize($user, $courseChanges);

        if ($courseChanges->isNew()){
            $this->registerNewCourse();
        }
        else{

            $this->registerCourseDateChanges();

            $this->registerSemesterChange();

            $this->registerNameChange();

            $this->registerLanguageChange();

            $this->registerConversationGuideChange();

            $this->registerIsFreeChange();

            $this->registerStudentClassChange();

            $this->registerDiscountChange();

            $this->registerConversationPackageChange();

            $this->registerHolidaysChange();

            $this->registerCoachingWeeksChange();
        }
    }

    private function initialize (User $user, CourseChanges $courseChanges){
        $this->user = $user;
        $this->courseChanges = $courseChanges;
    }

    private function registerNewCourse (){
        $this->registerChanges($this->courseChanges->changeInCourseCreated(),$this->buildKey(CourseCreatedNotifier::KEY));
    }

    private function registerCourseDateChanges (){
        $this->registerChanges($this->courseChanges->changeInCourseDates(),$this->buildKey(CourseDatesNotifier::KEY));
    }

    private function registerSemesterChange (){
        $this->registerChanges($this->courseChanges->changeInSemester(),$this->buildKey(SemesterNotifier::KEY));
    }

    private function registerNameChange (){
        $this->registerChanges($this->courseChanges->changeInName(),$this->buildKey(NameNotifier::KEY));
    }

    private function registerLanguageChange (){
        $this->registerChanges($this->courseChanges->changeInLanguage(),$this->buildKey(LanguageNotifier::KEY));
    }

    private function registerConversationGuideChange (){
        $this->registerChanges($this->courseChanges->changeInConversationGuide(),$this->buildKey(ConversationGuideNotifier::KEY));
    }

    private function registerIsFreeChange (){

        $changes = $this->courseChanges->changeIsOpenAccess();

        if ($changes->hasChanges()){

            $changeField = $changes->get()->first();

            $beforeIsPaid = (bool)$changeField->getBefore();
            $afterIsFree = (bool)$changeField->getAfter();

            if ( !$beforeIsPaid AND $afterIsFree){
                $notifier = $this->notifiersBuilder->build(IsFreeNotifier::KEY);
                $notifier->publish($this->user, $this->courseChanges->course(), $changes);
            }
        }
    }

    private function registerStudentClassChange (){
        $this->registerChanges($this->courseChanges->changeStudentClass(),$this->buildKey(StudentClassNotifier::KEY));
    }

    private function registerDiscountChange (){
        $this->registerChanges($this->courseChanges->changeDiscount(),$this->buildKey(DiscountNotifier::KEY));
    }

    private function registerConversationPackageChange (){
        $this->registerChanges($this->courseChanges->changeConversationPackage(),$this->buildKey(ConversationPackageNotifier::KEY));
    }

    private function registerHolidaysChange (){

        if ($this->courseChanges->holidaysDifference()->thereAreDifferences()){
            $this->registerChanges($this->courseChanges->changeHolidays(),$this->buildKey(HolidaysNotifier::KEY));
        }
    }

    private function registerCoachingWeeksChange (){

        if ($this->courseChanges->coachingWeeksDifference()->thereAreDifferences()){
            $this->registerChanges($this->courseChanges->changeCoachingWeeks(),$this->buildKey(CoachingWeeksNotifier::KEY));
        }
    }

    private function buildKey (string $value):Key{
        return new Key($value);
    }

    private function registerChanges(ChangeCollection $changeCollection, Key $key){

        if ($changeCollection->hasChanges()){
            $notifier = $this->notifiersBuilder->build($key->get());
            $notifier->publish($this->user, $this->courseChanges->course(), $changeCollection);
        }
    }


}
