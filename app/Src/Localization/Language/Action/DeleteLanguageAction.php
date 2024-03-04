<?php

namespace App\Src\Localization\Language\Action;

use App\Src\Localization\Language\Model\Language;

class DeleteLanguageAction
{
    public function handle(Language $language): Language
    {
        $language->delete();

        return $language;
    }
}
