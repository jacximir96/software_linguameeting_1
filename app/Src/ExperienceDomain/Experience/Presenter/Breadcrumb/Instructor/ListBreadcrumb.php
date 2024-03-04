<?php

namespace App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\Instructor;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class ListBreadcrumb implements IBreadcrumb
{

    private bool $isUpcoming;

    public function __construct (bool $isUpcoming){

        $this->isUpcoming = $isUpcoming;
    }

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create(route('get.instructor.experiences.dashboard'), 'Experiences', 'Experiences');
        $itemKink = new ItemLink($link);
        $breadcrumb->push($itemKink);


        if ($this->isUpcoming){
            $tag = new ItemTag('Upcoming Experiences');
        }
        else{
            $tag = new ItemTag('Past Experiences');
        }

        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
