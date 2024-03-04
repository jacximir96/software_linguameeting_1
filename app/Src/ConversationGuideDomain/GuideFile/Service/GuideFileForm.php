<?php

namespace App\Src\ConversationGuideDomain\GuideFile\Service;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class GuideFileForm extends BaseSearchForm
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

    public function configToCreate(ConversationGuide $guide)
    {

        $this->action = route('post.admin.config.conversation_guide.file.create', $guide->id);

    }

    public function configToEdit(ConversationGuideFile $file)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.config.conversation_guide.file.update', $file->id);

        $this->model = $file->toArray();
    }
}
