<?php
namespace App\Src\CoachDomain\Algorithm\Service;


class CoachFilter
{
    private string $name;

    private function __construct (string $name){

        $this->name = $name;
    }

    public static function filterByName(string $name):self{
        return new self($name);
    }

    public function isFilterByName ():bool{
        return !empty($this->name);
    }

    public function name():string{
        return $this->name;
    }
}
