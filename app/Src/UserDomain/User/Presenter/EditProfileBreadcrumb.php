<?php

namespace App\Src\UserDomain\User\Presenter;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class EditProfileBreadcrumb
{
    const SLUG = 'profile_edit';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Edit profile');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
