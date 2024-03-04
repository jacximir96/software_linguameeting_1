<?php

namespace App\Src\UniversityDomain\University\Action;

use App\Src\UniversityDomain\University\Model\University;

class DeleteUniversityAction
{
    public function handle(University $university)
    {
        $university->delete();
    }
}
