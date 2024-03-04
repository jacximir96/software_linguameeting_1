<?php

namespace App\Src\UniversityDomain\Instructor\Action;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\UserDomain\User\Model\User;

class AssignSectionCommand
{
    public function handle(Section $section, User $instructor)
    {
    }
}
