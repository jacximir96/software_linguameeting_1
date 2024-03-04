<?php


namespace App\Src\CourseDomain\Course\Model\Trait;


trait AssignmentTrait
{

    public function hasCompleteAssignments(): bool
    {

        foreach ($this->section as $section) {

            $statusAssignment = $section->statusAssignment();

            if (! $statusAssignment->isCompleted()) {
                return false;
            }
        }

        return true;
    }

    public function isFullFilled(): bool
    {
        return $this->hasCompleteAssignments();
    }

}
