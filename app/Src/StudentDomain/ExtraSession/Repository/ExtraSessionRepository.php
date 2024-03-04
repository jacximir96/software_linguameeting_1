<?php
namespace App\Src\StudentDomain\ExtraSession\Repository;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\ExtraSession\Model\ExtraSession;

class ExtraSessionRepository
{

    public static function findTrashed(int $id){
        return ExtraSession::withTrashed()->find($id);
    }

    public function obtainFirstAvailableFromEnrollment (Enrollment $enrollment){

        return ExtraSession::query()
            ->where('enrollment_id', $enrollment->id)
            ->whereDoesntHave('enrollmentSession')
            ->first();
    }
}
