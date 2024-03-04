<?php

namespace App\Src\StudentDomain\StudentHelp\Repository;

use App\Src\StudentDomain\StudentHelp\Model\StudentHelp;

class StudentHelpRepository
{
    public function all()
    {

        return StudentHelp::query()
            ->select('student_help.*')
            ->with('type')
            ->join('student_help_type', 'student_help.student_help_type_id', '=', 'student_help_type.id')
            ->orderBy('student_help_type.id')
            ->orderBy('student_help.description')
            ->get();
    }
}
