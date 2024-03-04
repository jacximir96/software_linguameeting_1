<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;
use App\Src\UserDomain\User\Model\User;

class CoachBillingBreadcrumb implements IBreadcrumb
{
    private User $coach;

    public function __construct(User $coach)
    {

        $this->coach = $coach;
    }

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create(route('get.admin.coach.index'), 'Coaches', 'List of coaches');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $link = HtmlLink::create(route('get.admin.coach.show', $this->coach->hashId()), $this->coach->name, $this->coach->name);
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Billing Configuration');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
