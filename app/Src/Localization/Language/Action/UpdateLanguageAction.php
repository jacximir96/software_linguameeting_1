<?php

namespace App\Src\Localization\Language\Action;

use App\Src\Localization\Language\Model\Language;
use App\Src\Localization\Language\Request\LanguageRequest;

class UpdateLanguageAction
{
    public function handle(LanguageRequest $request, Language $language): Language
    {

        $language->name = $request->name;
        $language->is_lingro = $request->is_lingro;
        $language->save();

        return $language;
    }
}
