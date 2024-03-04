<?php
namespace App\Src\CoachDomain\CoachSchedule\Action\Command;


use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;

class DeleteCommand
{
    public function handle(CoachSchedule $coachSchedule)
    {
        $coachSchedule->delete();
    }
}
