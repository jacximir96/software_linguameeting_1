<?php

namespace App\Src\StudentDomain\MakeupType\Repository;

use App\Src\StudentDomain\MakeupType\Model\MakeupType;

class MakeupTypeRepository
{
    public function obtainBySlug(string $slug)
    {
        return MakeupType::where('slug', $slug)->first();
    }
}
