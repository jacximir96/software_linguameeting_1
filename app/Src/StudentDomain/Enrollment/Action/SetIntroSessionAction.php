<?php
namespace App\Src\StudentDomain\Enrollment\Action;


use App\Src\StudentDomain\Enrollment\Model\Enrollment;

class SetIntroSessionAction
{

    public function handle(Enrollment $enrollment):Enrollment{

        $enrollment->intro_session = 1;
        $enrollment->save();

        return $enrollment;
    }
}
