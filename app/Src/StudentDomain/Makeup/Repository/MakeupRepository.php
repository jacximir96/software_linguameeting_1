<?php
namespace App\Src\StudentDomain\Makeup\Repository;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use App\Src\UserDomain\User\Model\User;

class MakeupRepository
{

    public static function findTrashed(int $id){
        return Makeup::withTrashed()->find($id);
    }

    public function obtainByEnrolllment (Enrollment $enrollment){

        return Makeup::query()
            ->with($this->relations())
            ->where('enrollment_id', $enrollment->id)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function obtainFirstNotUsedByEnrollment (Enrollment $enrollment){

        return Makeup::query()
            ->where('enrollment_id', $enrollment->id)
            ->doesntHave('enrollmentSession')
            ->orderBy('id', 'asc')
            ->first();
    }

    public function obtainIdsByStudent (User $student){

        return Makeup::query()
            ->select('id')
            ->whereIn('enrollment_id', $student->enrollment->pluck('id')->toArray())
            ->get()
            ->pluck('id')
            ->toArray();
    }

    public function relations ():array{

        return [
            'allocator',
            'enrollmentSession',
            'paymentDetail',
            'paymentDetail.payment',
            'type'
        ];
    }
}
