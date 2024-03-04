<?php

namespace App\Src\CoachDomain\CoachCoordinator\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class AssignCoordinatedForm extends BaseSearchForm
{
    private array $coachesOptions = [];

    private FieldFormBuilder $fieldFormBuilder;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {

        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function coachesOptions(): array
    {
        return $this->coachesOptions;
    }

    public function hasCoachesForSelect(): bool
    {
        return count($this->coachesOptions());
    }

    public function config(User $coachCoordinator)
    {
        $this->action = route('post.admin.coach.assign_coordinated', $coachCoordinator->hashId());

        $this->initialize();

        $this->configureCoachesOptions($coachCoordinator);
    }

    public function initialize()
    {
        $this->model = [];
        $this->coachesOptions = [];
    }

    private function configureCoachesOptions(User $assistant)
    {

        $this->coachesOptions = $this->fieldFormBuilder->obtainCoachesOptionsToBeCoordinated();

        unset($this->coachesOptions[$assistant->id]);

    }
}
