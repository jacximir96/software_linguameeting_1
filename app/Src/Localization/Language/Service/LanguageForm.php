<?php

namespace App\Src\Localization\Language\Service;

use App\Src\Localization\Language\Model\Language;
use App\Src\Shared\Service\BaseSearchForm;

class LanguageForm extends BaseSearchForm
{
    public function configToCreate()
    {
        $this->action = route('post.admin.config.language.create');
        $this->model = [];
    }

    public function configToEdit(Language $language)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.config.language.update', $language->id);

        $this->model = $language->toArray();
    }
}
