<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Presenter\Instructor;


class GradeCount
{

    private int $grade;

    private int $count;

    public function __construct (int $grade){
        $this->grade = $grade;
        $this->count = 0;
    }

    public function grade():int{
        return $this->grade;
    }

    public function count():int{
        return $this->count;
    }

    public function add(){
        $this->count++;
    }
}
