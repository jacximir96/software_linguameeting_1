<?php

namespace App\Src\StudentDomain\ExtraSessionType\Repository;

use App\Src\StudentDomain\ExtraSessionType\Model\ExtraSessionType;

class ExtraSessionTypeRepository
{
    public function obtainBySlug(string $slug)
    {
        return ExtraSessionType::where('slug', $slug)->first();
    }
}
