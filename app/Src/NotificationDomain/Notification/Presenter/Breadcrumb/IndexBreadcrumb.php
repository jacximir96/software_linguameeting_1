<?php

namespace App\Src\NotificationDomain\Notification\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb implements IBreadcrumb
{
    const SLUG = 'notification_index';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Notifications');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
