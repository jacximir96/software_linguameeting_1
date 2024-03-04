<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReview\Service;

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

    public function configToCreate(EnrollmentSession $enrollmentSession)
    {
        $this->action = route('post.common.enrollments.session.feedback.create', $enrollmentSession->id);

        $this->model = [];

        $this->configCommonOptions();
    }

    public function configToEdit(StudentReview $sessionFeedback)
    {
        $this->isEdit = true;

        $this->action = route('post.common.enrollments.session.feedback.update', $sessionFeedback->id);

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
