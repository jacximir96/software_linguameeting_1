<?php

namespace App\Src\ConversationGuideDomain\Template\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb
{
    const SLUG = 'template_index';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Templates Assignments');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
