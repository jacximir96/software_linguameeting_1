<?php

namespace App\Src\Shared\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use Illuminate\Support\Collection;

class Breadcrumb
{
    private Collection $links;

    public function __construct(Collection $links)
    {
        $this->links = $links;
    }

    public static function buildEmpty(): self
    {
        return new static(collect());
    }

    public static function buildWithDashboard(): self
    {
        if (user()->isCoach()) {
            $link = HtmlLink::create(route('get.coach.dashboard'), 'Dashboard', 'Go to dashboard');
        } elseif (user()->isStudent()) {
            $link = HtmlLink::create(route('get.student.dashboard'), 'Dashboard', 'Go to dashboard');
        } elseif (user()->isInstructor()) {
            $link = HtmlLink::create(route('get.instructor.dashboard'), 'Dashboard', 'Go to dashboard');
        } else {
            $link = HtmlLink::create(route('get.admin.dashboard.index'), 'Dashboard', 'Go to dashboard');
        }

        $item = new ItemLink($link);

        $links = collect()->push($item);

        return new static($links);
    }

    public function all(): Collection
    {
        return $this->links;
    }

    public function push(Item $item)
    {
        return $this->links->push($item);
    }
}
