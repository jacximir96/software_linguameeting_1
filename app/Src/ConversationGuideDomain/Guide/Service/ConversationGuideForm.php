<?php

namespace App\Src\ConversationGuideDomain\Guide\Service;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class ConversationGuideForm extends BaseSearchForm
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

    public function config(ConversationGuide $guide)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.config.conversation_guide.update', $guide->id);

        $this->model = $guide->toArray();
    }
}
