<?php

namespace App\Src\ConversationGuideDomain\Chapter\Service;

use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class ChapterForm extends BaseSearchForm
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

        $this->action = route('post.admin.config.conversation_guide.chapter.create', $guide->id);

    }

    public function configToEdit(Chapter $chapter)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.config.conversation_guide.chapter.update', $chapter->id);

        $this->model = $chapter->toArray();
    }
}
