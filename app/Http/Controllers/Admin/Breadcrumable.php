<?php

namespace App\Http\Controllers\Admin;

use App\Src\Shared\Presenter\Breadcrumb\BreadcrumbFactory;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;

trait Breadcrumable
{
    public function buildBreadcrumbAndSendToView(string $type, string $currentPageText = '')
    {
        $builder = app(BreadcrumbFactory::class);
        $breadcrumb = $builder->build($type);

        view()->share('breadcrumb', $breadcrumb);
    }

    public function buildBreadcrumbInstanceAndSendToView(IBreadcrumb $breadcrumb)
    {
        view()->share('breadcrumb', $breadcrumb->handle());
    }
}
