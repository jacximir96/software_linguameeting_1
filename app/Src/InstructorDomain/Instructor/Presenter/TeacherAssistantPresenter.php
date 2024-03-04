<?php

namespace App\Src\InstructorDomain\Instructor\Presenter;

use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class TeacherAssistantPresenter
{
    private CourseRepository $courseRepository;

    private CommonPresenter $commonQuery;

    private SectionRepository $sectionRepository;

    public function __construct(CommonPresenter $commonQuery, CourseRepository $courseRepository, SectionRepository $sectionRepository)
    {
        $this->commonQuery = $commonQuery;
        $this->courseRepository = $courseRepository;
        $this->sectionRepository = $sectionRepository;
    }

    public function handle(User $instructor): TeacherAssistantResponse
    {
        $commonResponse = $this->commonQuery->handle($instructor);

        $courses = collect();

        $sectionsAsTeachingAssistant = $this->obtainSectionsAsTeachingAssistant($instructor);

        return new TeacherAssistantResponse($commonResponse, $courses, $sectionsAsTeachingAssistant);
    }

    private function obtainSectionsAsTeachingAssistant(User $instructor): Collection
    {

        return $this->sectionRepository->obtainSectionFromTeacherAssistant($instructor);

    }
}
