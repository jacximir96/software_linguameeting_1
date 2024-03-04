<?php

namespace App\Src\ConversationPackageDomain\Package\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb implements IBreadcrumb
{
    const SLUG = 'conversation_package_index';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Conversation Package');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
