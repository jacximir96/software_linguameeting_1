<?php

namespace App\Src\CoachDomain\InvoiceDomain\Invoice\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class CoachInvoicesBreadcrumb implements IBreadcrumb
{
    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Invoices');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
