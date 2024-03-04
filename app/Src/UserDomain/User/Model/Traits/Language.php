<?php

namespace App\Src\UserDomain\User\Model\Traits;

use App\Src\UserDomain\Language\Model\UserLanguage;

trait Language
{
    public function language()
    {
        return $this->belongsToMany(\App\Src\Localization\Language\Model\Language::class, 'user_language');
    }

    public function hasLanguage(\App\Src\Localization\Language\Model\Language $oneLanguage): bool
    {

        foreach ($this->language as $language) {

            if ($language->isSame($oneLanguage)) {
                return true;
            }
        }

        return false;
    }

    public function transformLanguagesToArrayIds(): array
    {
        return $this->language->pluck('id', 'id')->toArray();
    }

    public function userLanguage()
    {
        return $this->hasMany(UserLanguage::class);
    }
}
