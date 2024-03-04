<?php
namespace App\Src\CourseDomain\Assignment\Presenter\StudentRole;

use App\Src\CourseDomain\Assignment\Service\AssignmentCollection;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\SessionsCollection;

class ShowAssignmentPresenter
{

    private SectionRepository $sectionRepository;

    public function __construct (SectionRepository $sectionRepository){

        $this->sectionRepository = $sectionRepository;
    }

    public function handle(Enrollment $enrollment):ShowAssignmentResponse{

        $section =  $enrollment->section;

        $section->load($this->sectionRepository->relations());

        $sessionWeeks = $this->obtainSessionWeeks($section->course);

        $assignmentsCollection = $this->obtainAssignmentCollection($section);

        return new ShowAssignmentResponse($enrollment, $section, $sessionWeeks, $assignmentsCollection);
    }

    private function obtainSessionWeeks (Course $course):SessionsCollection{

        if ($course->isFlex()){
            return new SessionsCollection($course->obtainFlexSessions()->get());
        }

        return new SessionsCollection($course->coachingWeeksOrdered());
    }

    private function obtainAssignmentCollection (Section $section):AssignmentCollection{

        $collection = new AssignmentCollection();
        $assignments = $section->assignments();

        foreach ($assignments as $assignment){
            $collection->push($assignment);
        }

        return $collection;
    }
}
