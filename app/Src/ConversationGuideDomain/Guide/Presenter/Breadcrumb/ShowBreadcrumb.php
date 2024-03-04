<?php

namespace App\Src\ConversationGuideDomain\Guide\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class ShowBreadcrumb
{
    const SLUG = 'conversation_guide_show';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create(route('get.admin.config.conversation_guide.index'), 'Conversation Guides', 'List Conversation Guides');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Conversation Guide');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
