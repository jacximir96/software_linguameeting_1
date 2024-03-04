<?php
namespace App\Src\CourseDomain\Section\Service;

use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\NotificationDomain\Notification\Service\ChangeCollection;
use App\Src\NotificationDomain\Notification\Service\ChangedField;


class SectionChanges
{

    private Section $section;

    private array $newValues;

    public function __construct (Section $section){

        $this->section = $section;
        $this->newValues = $section->getDirty();
    }

    public function section():Section{
        return $this->section;
    }

    public function isNew ():bool{
        return $this->section->wasRecentlyCreated;
    }

    public function isUpdated():bool{
        return $this->section->exists;
    }

    public function changeInSectionCreated():ChangeCollection{

        $collection = new ChangeCollection();
        $value = $this->section->name;

        $change = new ChangedField('new', '', $value );
        $collection->addChange($change);

        return $collection;
    }

    public function changeInstructor ():ChangeCollection{
        return $this->changeInField('instructor_id');
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
        return $this->section->getDirty()[$field];
    }

    private function getOriginalField (string $field){
        return $this->section->getOriginal($field);
    }

    private function fieldWasChanged (string $field):bool{
        return array_key_exists($field, $this->newValues);
    }
}
