<?php
namespace App\Src\CourseDomain\Course\Service;

use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\CoachingWeek\Service\CoachingWeeksDifference;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Holiday\Service\HolidaysDifference;
use App\Src\NotificationDomain\Notification\Service\ChangeCollection;
use App\Src\NotificationDomain\Notification\Service\ChangedField;
use Carbon\Carbon;


class CourseChanges
{

    private Course $course;

    private array $newValues;

    private HolidaysDifference $holidaysDifference;

    private CoachingWeeksDifference $coachingWeeksDifference;

    public function __construct (Course $course){

        $this->course = $course;
        $this->newValues = $course->getDirty();

        $this->holidaysDifference = new HolidaysDifference(collect(), collect());

        $this->coachingWeeksDifference = new CoachingWeeksDifference(collect(), collect());
    }

    public static function buildWithHolidaysDifference(Course $course, HolidaysDifference $holidaysDifference):self{

        $courseChanges = new static($course);
        $courseChanges->setHolidaysDifference($holidaysDifference);

        return $courseChanges;
    }

    public static function buildWithCoachingWeeksDifference(Course $course, CoachingWeeksDifference $coachingWeeksDifference):self{

        $courseChanges = new static($course);
        $courseChanges->setCoachingWeeksDifference($coachingWeeksDifference);

        return $courseChanges;

    }

    public function course():Course{
        return $this->course;
    }

    public function isNew ():bool{
        return $this->course->wasRecentlyCreated;
    }

    public function isUpdated():bool{
        return $this->course->exists;
    }

    public function semesterWasChanged ():bool{
        return $this->fieldWasChanged('semester_id');
    }

    public function changeInCourseCreated():ChangeCollection{

        $collection = new ChangeCollection();

        $term = $this->course->semester->name;
        $year = $this->course->year;
        $value = $term.', '.$year;

        if ($this->course->serviceType->hasConversationGuide()){
            $conversationGuideName = $this->course->conversationGuide->name;
            $value .= ', '.$conversationGuideName;
        }
        elseif ($this->course->serviceType->isExperiences()){
            $value .= ', '.$this->course->serviceType->name;
        }

        $change = new ChangedField('new', '', $value );
        $collection->addChange($change);

        return $collection;
    }

    public function changeInCourseDates ():ChangeCollection{

        $collection = new ChangeCollection();

        if ($this->fieldWasChanged('start_date')){

            $before = Carbon::parse($this->getOriginalField('start_date'));
            $after = Carbon::parse($this->getDirtyField('start_date'));

            $change = new ChangedField('start_date',  $before->toDateString(), $after->toDateString() );
            $collection->addChange($change);
        }

        if ($this->fieldWasChanged('end_date')){

            $before = Carbon::parse($this->getOriginalField('end_date'));
            $after = Carbon::parse($this->getDirtyField('end_date'));

            $change = new ChangedField('end_date', $before->toDateString(), $after->toDateString());
            $collection->addChange($change);
        }

        return $collection;
    }

    public function changeInSemester ():ChangeCollection{
        return $this->changeInField('semester_id');
    }

    public function changeInName ():ChangeCollection{
        return $this->changeInField('name');
    }

    public function changeInLanguage ():ChangeCollection{
        return $this->changeInField('language_id');
    }

    public function changeInConversationGuide ():ChangeCollection{
        return $this->changeInField('conversation_guide_id');
    }

    public function changeIsOpenAccess():ChangeCollection{
        return $this->changeInField('is_free');
    }

    public function changeStudentClass ():ChangeCollection{
        return $this->changeInField('student_class');
    }

    public function changeConversationPackage ():ChangeCollection{
        return $this->changeInField('conversation_package_id');
    }

    public function changeDiscount ():ChangeCollection{

        $collection = new ChangeCollection();
        $field = 'amount_discount';


        if ($this->fieldWasChanged($field)){

            $before = $this->getOriginalField($field);
            $after = $this->getDirtyField($field);

            if ($before != $after){

                if (is_null($before)){
                    $before = '';
                }

                if (is_null($after)){
                    $after = '';
                }

                $change = new ChangedField($field,  $before, $after );
                $collection->addChange($change);
            }
        }

        return $collection;
    }


    public function setHolidaysDifference (HolidaysDifference $holidaysDifference){
        $this->holidaysDifference = $holidaysDifference;
    }

    public function holidaysDifference ():HolidaysDifference{
        return $this->holidaysDifference;
    }

    public function changeHolidays():ChangeCollection{

        $collection = new ChangeCollection();

        foreach ($this->holidaysDifference->deleted() as $holiday){
            $change = new ChangedField('deleted_'.$holiday->date->toDateString(),  $holiday->date->toDateString(), '' );
            $collection->addChange($change);
        }

        foreach ($this->holidaysDifference->news() as $holiday){
            $change = new ChangedField('new_'.$holiday->date->toDateString(),  '', $holiday->date->toDateString() );
            $collection->addChange($change);
        }

        return $collection;
    }

    public function setCoachingWeeksDifference (CoachingWeeksDifference $coachingWeeksDifference){
        $this->coachingWeeksDifference = $coachingWeeksDifference;
    }

    public function coachingWeeksDifference ():CoachingWeeksDifference{
        return $this->coachingWeeksDifference;
    }

    public function changeCoachingWeeks():ChangeCollection{

        $collection = new ChangeCollection();

        foreach ($this->coachingWeeksDifference->deleted() as $coachingWeek){
            $change = new ChangedField('deleted_'.$coachingWeek->id, $this->value($coachingWeek), '' );
            $collection->addChange($change);
        }

        foreach ($this->coachingWeeksDifference->news() as $coachingWeek){
            $change = new ChangedField('new_'.$coachingWeek->id,  '', $this->value($coachingWeek) );
            $collection->addChange($change);
        }

        return $collection;
    }

    private function value (CoachingWeek $coachingWeek):string{

        $period = $coachingWeek->period();

        return $coachingWeek->writeSessionNumber().': '.$period->getStartDate()->toDateString().' to '.$period->getEndDate()->toDateString();

    }


    private function changeInField (string $field){

        $collection = new ChangeCollection();

        if ($this->fieldWasChanged($field)){

            $before = $this->getOriginalField($field);
            $after = $this->getDirtyField($field);

            $change = new ChangedField($field,  $before, $after );
            $collection->addChange($change);

        }

        return $collection;
    }

    private function getDirtyField (string $field){
        return $this->course->getDirty()[$field];
    }

    private function getOriginalField (string $field){
        return $this->course->getOriginal($field);
    }

    private function fieldWasChanged (string $field):bool{
        return array_key_exists($field, $this->newValues);
    }
}
