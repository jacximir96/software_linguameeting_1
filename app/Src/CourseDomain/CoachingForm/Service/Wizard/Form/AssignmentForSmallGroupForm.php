<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Form;

use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class AssignmentForSmallGroupForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private AssignmentRepository $assignmentRepository;

    private array $chaptersOptions = [];

    public function __construct(FieldFormBuilder $fieldFormBuilder, AssignmentRepository $assignmentRepository)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->assignmentRepository = $assignmentRepository;
    }

    public function chaptersOptions(): array
    {
        return $this->chaptersOptions;
    }

    public function allowsFullEdition(Course $course, User $user): bool
    {
        return $course->allowsFullEdition($user);
    }

    public function config(Course $course)
    {

        $this->action = route('post.admin.course.coaching_form.course_assignment.update.week.small_group', $course);

        $this->configModel($course);

        $this->chaptersOptions = $this->fieldFormBuilder->obtainConversationGuideChapters($course->conversationGuide);
    }

    private function configModel(Course $course)
    {

        $this->model = [];

        $section = $course->section->first();

        if ($section) {

            foreach ($course->coachingWeeksOrderedWithoutMakeUps() as $coachingWeek) {

                $assignment = $this->assignmentRepository->findBySectionAndCoachingWeekOrNull($section, $coachingWeek);

                if ($assignment) {

                    $assignmentChapter = $assignment->chapter;

                    if ($assignmentChapter) {
                        $this->model['chapter_id'][$coachingWeek->id] = $assignmentChapter->chapter_id;
                    }
                }
            }
        }
    }
}
