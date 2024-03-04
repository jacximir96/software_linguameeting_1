<?php

namespace App\Src\CourseDomain\CourseCoordinator\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoordinator\Repository\CourseCoordinatorRepository;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UniversityDomain\University\Model\University;
use Facades\App\Src\UserDomain\Role\Service\FactoryRole;

class ChangeCourseCoordinatorForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $courseCoordinatorsOptions;

    private CourseCoordinatorRepository $courseCoordinatorRepository;

    public function __construct(FieldFormBuilder $fieldFormBuilder, CourseCoordinatorRepository $courseCoordinatorRepository)
    {

        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->courseCoordinatorRepository = $courseCoordinatorRepository;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config(Course $course)
    {

        $this->action = route('post.admin.course.course_coordinator.change', $course->hashId());

        $this->configModel($course);

        $this->configCourseCoordinatorsOptions($course->university);
    }

    private function configModel(Course $course)
    {

        $this->model = [];

        $courseCoordinator = $this->courseCoordinatorRepository->obtainFromCourse($course);

        if ($courseCoordinator) {

            $this->model['instructor_id'] = $courseCoordinator->coordinator_id;
        }

    }

    private function configCourseCoordinatorsOptions(University $university)
    {

        $courseCoordinatorRole = FactoryRole::obtainCurseCoordinator();

        $roleId = $courseCoordinatorRole->id;

        $this->courseCoordinatorsOptions = $this->fieldFormBuilder->obtainInstructorsOptionsByUniversityAndRole($university, collect($roleId));
    }
}
