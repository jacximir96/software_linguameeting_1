<?php

namespace App\Src\ConversationGuideDomain\Template\Service;

use App\Src\ConversationGuideDomain\Template\Model\Template;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class TemplateForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configToCreate()
    {

        $this->action = route('get.admin.config.conversation_guide.template.create');

    }

    public function configToEdit(Template $template)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.config.conversation_guide.template.update', $template->id);

        $this->model = $template->toArray();
    }
}
