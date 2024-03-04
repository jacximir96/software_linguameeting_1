<?php
namespace App\Src\ActivityLog\Service\Properties;

interface Property
{

    public function buildProperty (string $key, string $title = ''):array;

}
