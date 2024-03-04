<?php

namespace App\Src\HelpDomain\Issue\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class IssueForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $issueTypeOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->issueTypeOptions = [];
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config(User $user)
    {
        $this->action = route('post.student.support.issue.create');

        $this->model = [];
        $this->model['name'] = $user->writeFullNameAndLastName();
        $this->model['email'] = $user->email;

        $this->issueTypeOptions = $this->fieldFormBuilder->obtainIssueTypeOptions();
    }
}
