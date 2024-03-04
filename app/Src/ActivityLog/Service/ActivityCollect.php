<?php

namespace App\Src\ActivityLog\Service;

use Illuminate\Support\Collection;

class ActivityCollect
{
    private Collection $activities;

    public function __construct()
    {
        $this->activities = collect();
    }

    public function get(): Collection
    {
        return $this->activities;
    }

    public function push(\App\Src\ActivityLog\Model\Activity $activity)
    {
        $this->activities->push($activity);
    }

    public function clean()
    {
        $this->activities = collect();
    }

    public function sort ():Collection{

        return $this->activities->sortBy(function ($activity){
            return $activity->created_at->toDatetimeString();
        });
    }
}
