<?php
namespace App\Src\CourseDomain\SessionDomain\StudentReview\Repository;

use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use App\Src\Shared\Service\IdCollection;

class StudentReviewRepository
{

    public function obtainByCourses (IdCollection $idCollection){

        return StudentReview::query()
            ->with($this->relations())
            ->whereHas('enrollmentSession.session', function ($query) use($idCollection){
                $query->whereIn('course_id', $idCollection->toArray());
            })
            ->get();
    }

    public function relations ():array{

        return [
            'enrollmentSession.session.course.conversationPackage',
            'enrollmentSession.enrollment.user',
            'enrollmentSession.enrollment.user.experienceRegister',
            'enrollmentSession.enrollment.user.experienceRegister.experience',
            'enrollmentSession.enrollment.enrollmentTarget',

            'participationType',
            'preparedClassType',
            'puntualityType'
        ];
    }
}
