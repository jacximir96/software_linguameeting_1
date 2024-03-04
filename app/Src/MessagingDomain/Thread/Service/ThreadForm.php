<?php

namespace App\Src\MessagingDomain\Thread\Service;

use App\Src\CoachDomain\CoachHelp\Model\CoachHelp;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class ThreadForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $recipientOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->recipientOptions = [];
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configForCreate()
    {

        $this->action = route('post.admin.messaging.create');

        $this->model = [];

    }

    public function configForEdit(CoachHelp $coachHelp)
    {

        $this->isEdit = true;

        $this->action = route('post.admin.coach.help.update', $coachHelp->id);

        $this->model = $coachHelp->toArray();
    }
}
