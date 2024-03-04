<?php


namespace App\Src\ExperienceDomain\Experience\Presenter;


use Illuminate\Support\Collection;

class StudentsList
{

    private Collection $studentsItems;

    public function __construct (){
        $this->studentsItems = collect();
    }

    public function get():Collection{
        return $this->studentsItems;
    }

    public function hasStudents():bool{
        return (bool)$this->studentsItems->count();
    }

    public function addItem (StudentItem $studentItem)
    {
        $this->studentsItems->push($studentItem);
    }
}
