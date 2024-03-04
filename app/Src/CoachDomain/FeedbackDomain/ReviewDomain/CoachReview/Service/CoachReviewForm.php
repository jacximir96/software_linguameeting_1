<?php
namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;


class CoachReviewForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $reviewOptions;


    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configForCreate(EnrollmentSession $enrollmentSession)
    {

        $this->action = route('post.student.session.coach_review.create', $enrollmentSession->hashId());

        $this->model = [
            'rate' => 5
        ];

        $this->configOptions();
    }

    private function configOptions()
    {

        $this->reviewOptions = $this->fieldFormBuilder->obtainReviewOptionOptions();
    }
}
