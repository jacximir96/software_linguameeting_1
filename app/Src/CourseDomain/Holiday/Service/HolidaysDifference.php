<?php


namespace App\Src\CourseDomain\Holiday\Service;


use Illuminate\Support\Collection;

class HolidaysDifference
{

    private Collection $news;

    private Collection $deleted;

    public function __construct (Collection $news, Collection $deleted){

        $this->news = $news;
        $this->deleted = $deleted;
    }

    public function news(): Collection
    {
        return $this->news;
    }

    public function deleted(): Collection
    {
        return $this->deleted;
    }

    public function thereAreDifferences():bool{

        if ($this->news->count()){
            return true;
        }

        if ($this->deleted->count()){
            return true;
        }

        return false;
    }


}
