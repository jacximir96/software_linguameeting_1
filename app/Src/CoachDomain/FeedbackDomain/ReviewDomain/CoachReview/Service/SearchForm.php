<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class SearchForm extends BaseSearchForm
{
    const KEY_FORM = 'review_searcher';

    private FieldFormBuilder $fieldFormBuilder;

    private array $reviewOptions;

    private array $universityOptions;

    private array $starsOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function fieldWithOptions(string $field): array
    {
        return $this->$field;
    }

    public function config()
    {
        $this->action = route('post.admin.coach.review.search');

        $this->configModelForm(self::KEY_FORM);

        $this->universityOptions = $this->fieldFormBuilder->obtainUniversityOptions();

        $this->reviewOptions = $this->fieldFormBuilder->obtainReviewOptionOptions();

        $this->starsOptions = $this->fieldFormBuilder->obtainNumberOptions(1, 5, 'desc');
    }
}
