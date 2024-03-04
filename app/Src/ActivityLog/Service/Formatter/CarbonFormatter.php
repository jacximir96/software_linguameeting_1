<?php
namespace App\Src\ActivityLog\Service\Formatter;


use Carbon\Carbon;

class CarbonFormatter implements Formatter
{

    private string $title;
    private string $datetime;

    public function __construct (string $title, string $datetime){

        $this->title = $title;
        $this->datetime = $datetime;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function value(): Carbon
    {
        return Carbon::parse($this->datetime);
    }

    public function print(): string
    {
        return $this->title.': '.$this->datetime;
    }
}
