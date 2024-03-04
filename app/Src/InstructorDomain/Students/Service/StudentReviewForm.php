<?php

namespace App\Src\InstructorDomain\Students\Service;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class StudentReviewForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $puntualityTypeOptions;

    private array $participationTypeOptions;

    private array $preparedClassTypeOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configToEdit(StudentReview $sessionFeedback)
    {
        $this->isEdit = true;

        $this->action = route('post.instructor.students.enrollment.session.feedback.show_form', $sessionFeedback->id);

        $this->model = $sessionFeedback->toArray();

        $this->model['is_attended'] = $sessionFeedback->enrollmentSession->status->isAttended();

        $this->configCommonOptions();
    }

    private function configCommonOptions()
    {
        $this->puntualityTypeOptions = $this->fieldFormBuilder->obtainPuntualityTypeOptions('description');

        $this->preparedClassTypeOptions = $this->fieldFormBuilder->obtainPreparedClassOptions('description');

        $this->participationTypeOptions = $this->fieldFormBuilder->obtainParticipationTypeOptions('description');
    }
}
