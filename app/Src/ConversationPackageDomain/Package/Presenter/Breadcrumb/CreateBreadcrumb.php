<?php

namespace App\Src\ConversationPackageDomain\Package\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class CreateBreadcrumb implements IBreadcrumb
{
    const SLUG = 'conversation_package_create';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create(route('get.admin.config.conversation_package.index'), 'Conversation Packages', 'List Conversation Packages');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Create Conversation Package');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
