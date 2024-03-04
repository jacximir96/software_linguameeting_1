<?php
namespace App\Src\ExperienceDomain\Experience\Presenter;

use Illuminate\Support\Collection;


class ExperiencesList
{

    private Collection $experiencesItems;

    public function __construct (){
        $this->experiencesItems = collect();
    }

    public function get():Collection{
        return $this->experiencesItems;
    }

    public function hasExperiences():bool{
        return (bool)$this->experiencesItems->count();
    }

    public function addItem (ExperienceItem $experienceItem)
    {
        $this->experiencesItems->push($experienceItem);
    }
}
