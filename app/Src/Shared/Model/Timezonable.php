<?php
namespace App\Src\Shared\Model;


use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use Carbon\Carbon;


trait Timezonable
{
    public function datetimeToTimezone(string $localField, string $localTimezoneFieldId = '', TimeZone $targetTimeZone): Carbon
    {
        $useTimezoneColumn = !empty($localTimezoneFieldId);
        if ($useTimezoneColumn){

            $timeZoneId = $this->$localTimezoneFieldId;
            $timezone = TimeZoneRepository::findById($timeZoneId);

            $moment = Carbon::parse($this->$localField->toDateString(), $timezone->name);

            return $moment->clone()->setTimezone($targetTimeZone->name);

        }

        $moment = $this->$localField->clone();

        return $moment->setTimezone($targetTimeZone->name);
    }

    public function dateAndTimeToTimezone(string $dateField, string $timeField, string $localTimezoneFieldId = '', TimeZone $targetTimezone): Carbon
    {
        $day = $this->$dateField;
        $time = $this->$timeField;

        $useTimezoneColumn = !empty($localTimezoneFieldId);
        if ($useTimezoneColumn){

            $timeZoneId = $this->$localTimezoneFieldId;
            $timezone = TimeZoneRepository::findById($timeZoneId);

            if ($day instanceof Carbon) {
                $date = Carbon::parse($day->toDateString().' '.$time, $timezone->name);
            }
            else{
                $date = Carbon::parse($day.' '.$time, $timezone->name);
            }

            return $date->setTimezone($targetTimezone->name);
        }

        if ($day instanceof Carbon) {
            $date = Carbon::parse($day->toDateString().' '.$time);
        }
        else{
            $date = Carbon::parse($day.' '.$time);
        }

        return $date->setTimezone($targetTimezone->name);
    }
}
