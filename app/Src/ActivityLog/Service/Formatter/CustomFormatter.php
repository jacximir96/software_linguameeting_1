<?php
namespace App\Src\ActivityLog\Service\Formatter;


class CustomFormatter implements Formatter
{

    private string $title;
    private string $value;

    public function __construct (string $title, string $value){

        $this->title = $title;
        $this->value = $value;
    }

    public function print(): string
    {
        return $this->title.': '.$this->value;
    }
}
