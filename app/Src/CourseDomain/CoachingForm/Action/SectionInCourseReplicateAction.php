<?php

namespace App\Src\CourseDomain\CoachingForm\Action;

use App\Src\CourseDomain\Assignment\Action\DeleteAssignmentAction;
use App\Src\CourseDomain\Assignment\Action\ReplicateAssignmentActionDeprecated;
use App\Src\CourseDomain\CoachingForm\Request\CourseAssignmentRequest;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;

class SectionInCourseReplicateAction
{
    private CourseAssignmentRequest $request;

    private Section $mainSection;

    private Course $targetCourse;

    private DeleteAssignmentAction $deleteAssignmentAction;

    private ReplicateAssignmentActionDeprecated $replicateAssignmentAction;

    public function __construct(DeleteAssignmentAction $deleteAssignmentAction, ReplicateAssignmentActionDeprecated $replicateAssignmentAction)
    {
        $this->deleteAssignmentAction = $deleteAssignmentAction;
        $this->replicateAssignmentAction = $replicateAssignmentAction;
    }

    public function handle(CourseAssignmentRequest $request, Section $mainSection, Course $targetCourse)
    {
        $this->initialize($request, $mainSection, $targetCourse);

        $this->replicateOriginalSection();
    }

    private function initialize(CourseAssignmentRequest $request, Section $mainSection, Course $targetCourse)
    {
        $this->request = $request;
        $this->mainSection = $mainSection;
        $this->targetCourse = $targetCourse;
    }

    private function replicateOriginalSection()
    {
        $courseSections = $this->targetCourse->section;

        foreach ($courseSections as $secondarySection) {

            if ($this->mainSection->isSame($secondarySection)) {
                continue;
            }

            $secondarySection = $this->updateAssignmentType($secondarySection);

            $this->deleteExistingAssignment($secondarySection);

            $this->replicateAssignment($secondarySection);
        }
    }

    private function updateAssignmentType(Section $secondarySection): Section
    {

        $secondarySection->save();

        return $secondarySection;

    }

    private function deleteExistingAssignment(Section $secondarySection)
    {
        foreach ($secondarySection->assignment as $assignment) {
            $this->deleteAssignmentAction->handle($assignment);
        }
    }

    private function replicateAssignment(Section $secondarySection)
    {
        $this->replicateAssignmentAction->handle($this->mainSection, $secondarySection);
    }
}
