<?php

namespace App\Src\MessagingDomain\Thread\Presenter\Breadcrumb\Coach;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Model\ValueObject\Url;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class ShowThreadBreadcrumb implements IBreadcrumb
{
    private Url $messagingUrl;

    public function __construct(Url $messagingUrl)
    {
        $this->messagingUrl = $messagingUrl;
    }

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create($this->messagingUrl->get(), 'Messaging', 'Messaging');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Read Thread');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
