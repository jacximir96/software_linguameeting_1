<?php

namespace App\Src\CoachDomain\CoachSchedule\Service;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DateSlot
{
    private Carbon $start;

    private Carbon $end;

    public function __construct(Carbon $start, Carbon $end)
    {

        $this->start = $start;
        $this->end = $end;

        if ($this->end->format('H:i') == '23:59') {
            $this->end = $this->end->endOfDay();
        }
    }

    public static function fromIntervalWithStartAndEnd(array $interval)
    {

        $start = Carbon::parse($interval['start']);
        $end = Carbon::parse($interval['end']);

        return new self($start, $end);
    }

    public static function fromDateAndTimes(Carbon $date, string $startTime, string $endTime): self
    {
        $start = Carbon::parse($date->toDateString().' '.$startTime, $date->timezoneName)->setTimezone('UTC');

        $end = Carbon::parse($date->toDateString().' '.$endTime, $date->timezoneName)->setTimezone('UTC');

        return new self($start, $end);

    }

    public function buildSameTimesWithOtherDate(Carbon $date): self
    {
        $start = Carbon::parse($date->toDateString().' '.$this->start->toTimeString());

        $end = Carbon::parse($date->toDateString().' '.$this->end->toTimeString());

        return new self($start, $end);
    }

    public function start(): Carbon
    {
        return $this->start;
    }

    public function end(): Carbon
    {
        return $this->end;
    }

    public function isStartEqual(Carbon $other): bool
    {
        return $this->start->eq($other);
    }

    public function isEndEqual(Carbon $other): bool
    {
        return $this->end->eq($other);
    }

    public function sortKey(): string
    {
        return $this->start->toDatetimeString();
    }

    public function period ():CarbonPeriod{
        return CarbonPeriod::create($this->start, $this->end);
    }

    public function periodRange (string $range):CarbonPeriod{
        return CarbonPeriod::create($this->start, $range, $this->end);
    }

    public function printTimes(): string
    {
        return $this->start->toTimeString().' - '.$this->end->toTimeString();
    }

    public function toPrint(): string
    {
        return $this->start->toDateTimeString().' '.$this->start->timezoneName.' # '.$this->end->toDateTimeString().' '.$this->end->timezoneName.'#';
    }
}
