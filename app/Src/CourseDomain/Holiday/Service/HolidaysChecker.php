<?php
namespace App\Src\CourseDomain\Holiday\Service;

use Illuminate\Support\Collection;


class HolidaysChecker
{

    public function obtainDifference (Collection $beforeHolidays, Collection $afterHolidays):HolidaysDifference{

        $newHolidays = $this->obtainNewsHolidays($beforeHolidays, $afterHolidays);

        $deletedHolidays = $this->obtainDeletedHolidays($beforeHolidays, $afterHolidays);

        return new HolidaysDifference($newHolidays, $deletedHolidays);
    }

    private function obtainNewsHolidays (Collection $beforeHolidays, Collection $afterHolidays):Collection{

        $newHolidays = collect();

        foreach ($afterHolidays as $afterHoliday){

            $exists = false;
            foreach ($beforeHolidays as $beforeHoliday){
                if ($beforeHoliday->isSameDay($afterHoliday->date)){
                    $exists = true;
                    break;
                }
            }

            if ( ! $exists){
                $newHolidays->push($afterHoliday);
            }
        }

        return $newHolidays;
    }

    private function obtainDeletedHolidays (Collection $beforeHolidays, Collection $afterHolidays):Collection{

        $deletedHolidays = collect();
        foreach ($beforeHolidays as $beforeHoliday){

            $exists = false;
            foreach ($afterHolidays as $afterHoliday){
                if ($beforeHoliday->isSameDay($afterHoliday->date)){
                    $exists = true;
                    break;
                }
            }

            if ( ! $exists){
                $deletedHolidays->push($beforeHoliday);
            }
        }

        return $deletedHolidays;
    }
}
