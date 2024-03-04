<?php
namespace App\Src\Survey\Service;

use App\Src\Shared\Model\ValueObject\Url;

interface ViewSurvey
{

    public function isDefault():bool;

    public function description ():string;

    public function url ():Url;
}
