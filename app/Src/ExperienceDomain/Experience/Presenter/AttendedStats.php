<?php
namespace App\Src\ExperienceDomain\Experience\Presenter;


class AttendedStats
{

    private int $attendedAtLeastOne;
    private int $totalStudents;


    public function __construct (int $attendedAtLeastOne, int $totalStudents){
        $this->attendedAtLeastOne = $attendedAtLeastOne;
        $this->totalStudents = $totalStudents;
    }

    public function attendedAtLeastOne(): int
    {
        return $this->attendedAtLeastOne;
    }

    public function totalStudents(): int
    {
        return $this->totalStudents;
    }

    public function notAttended(): int
    {
        return $this->totalStudents - $this->attendedAtLeastOne;
    }

    public function attendedPercetage():int{

        if ( ! $this->totalStudents){
            return 0;
        }

        $result = ($this->attendedAtLeastOne() * 100) / $this->totalStudents;

        return round($result);

    }

    public function notAttendedPercetage():int{
        return 100 - $this->attendedPercetage();
    }
}
