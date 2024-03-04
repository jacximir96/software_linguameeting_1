<?php

namespace App\Src\CoachDomain\CoachCoordinator\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class AssignCoordinatorForm extends BaseSearchForm
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

    public function hasCoachesCoordinatorsForSelect(): bool
    {
        return count($this->coachesOptions());
    }

    public function config(User $coach)
    {
        $this->action = route('post.admin.coach.assign_coordinator', $coach->hashId());

        $this->initialize();

        $this->configureCoachesCoordinatorsOptions($coach);
    }

    public function initialize()
    {
        $this->model = [];
        $this->coachesOptions = [];
    }

    private function configureCoachesCoordinatorsOptions(User $assistant)
    {

        $this->coachesOptions = $this->fieldFormBuilder->obtainCoachesCoordinatorsOptions();

        unset($this->coachesOptions[$assistant->id]);

    }
}
