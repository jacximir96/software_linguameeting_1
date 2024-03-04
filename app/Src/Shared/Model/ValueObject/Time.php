<?php

namespace App\Src\Shared\Model\ValueObject;

use DateTime;

class Time
{
    private string $time;

    public function __construct(string $time)
    {

        if (! $this->validate($time)) {
            throw new \InvalidArgumentException('Time incorrect: '.$time);
        }

        $this->time = $time;
    }

    public function get(): string
    {
        return $this->time;
    }

    public function isEqual(Time $other): bool
    {
        return $this->time == $other->get();
    }

    public function timeInSeconds(): int
    {

        return strtotime($this->time);
    }

    public function convertTo12HourFormat(): string
    {

        $dateTime = DateTime::createFromFormat('H:i:s', $this->time);

        return $dateTime->format('h:i A');
    }

    private function validate(string $time)
    {

        $formatoHora = 'H:i:s';
        $hora = DateTime::createFromFormat($formatoHora, $time);

        return $hora && $hora->format($formatoHora) === $time;
    }
}
