<?php

namespace App\Src\ConversationGuideDomain\Guide\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb
{
    const SLUG = 'conversation_guide_index';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Conversation Guides');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
