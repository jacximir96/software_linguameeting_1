<?php
namespace App\Src\CoachDomain\CoachSchedule\Service;

use App\Src\Localization\TimeZone\Model\TimeZone;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;


class SlotsUtc
{

    private Collection $dateSlots;

    /*
     * $date: fecha con el timezone destino (el que muestra el calendario normalmente)
     */
    private function __construct (Collection $dateSlots){
        $this->dateSlots = $dateSlots;
    }

    public static function convertSlotsRequestsToUtc (Carbon $date, array $startTimeRequest, array $endTimeRequest):self{

        $dateSlots = collect();
        foreach ($startTimeRequest as $key => $startTime){

            $startTime = $startTime;
            $endTime = $endTimeRequest[$key];

            $startTimeUtc = Carbon::parse($date->toDateString().' '.$startTime, $date->timezoneName)->setTimezone('UTC');
            $endTimeUtc = Carbon::parse($date->toDateString().' '.$endTime, $date->timezoneName)->setTimezone('UTC');

            if ($endTime == '23:59'){
                $endTimeUtc->addMinute();
            }

            $dateSlot = new DateSlot($startTimeUtc, $endTimeUtc);
            $dateSlots->push($dateSlot);
        }

        return  new self($dateSlots);
    }

    public static function convertPeriodToUtc(CarbonPeriod $period):self{

        $dateSlots = collect();

        $start = $period->getStartDate()->clone()->setTimezone('UTC');
        $end = $period->getEndDate()->clone()->setTimezone('UTC');

        $dateSlot = new DateSlot($start, $end);
        $dateSlots->push($dateSlot);

        return  new self($dateSlots);
    }

    public static function buildWithDateSlotsCollection (Collection $datesSlots):self{
        return new self($datesSlots);
    }

    public function addDateSlot (DateSlot $dateSlot){
        $this->dateSlots->push($dateSlot);
    }

    public function slots ():Collection{
        return $this->dateSlots;
    }

    public function startTimeLimit ():Carbon{
        return $this->dateSlots->first()->start();
    }

    public function endTimeLimit ():Carbon{
        return $this->dateSlots->last()->end();
    }

    public function print(){
        foreach ($this->dateSlots as $dateSlot){
            echo "\r\n<br>".$dateSlot->toPrint();
        }
    }
}
