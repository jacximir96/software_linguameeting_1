<?php

namespace App\Src\UniversityDomain\University\Action;

use App\Src\UniversityDomain\University\Model\University;

class RestoreUniversityAction
{
    public function handle(University $university): University
    {

        $university->restore();

        return $university;
    }
}
