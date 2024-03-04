<?php

namespace App\Src\InstructorDomain\InstructorHelp\Repository;

use App\Src\InstructorDomain\InstructorHelp\Model\InstructorHelp;

class InstructorHelpRepository
{
    public function all()
    {

        return InstructorHelp::query()
            ->select('instructor_help.*')
            ->with('type')
            ->join('instructor_help_type', 'instructor_help.instructor_help_type_id', '=', 'instructor_help_type.id')
            ->orderBy('instructor_help_type.id')
            ->orderBy('instructor_help.description')
            ->get();
    }
}
