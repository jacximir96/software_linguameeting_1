<?php
namespace App\Src\StudentDomain\Makeup\Model;


class MakeupNumber
{

    private int $num;

    public function __construct (int $num){

        if ($num < 0){
            throw new \InvalidArgumentException(sprint('Make-up number (%s) for purchase is incorrect', $num));
        }

        $this->num = $num;
    }

    public function get():int{
        return $this->num;
    }
}
