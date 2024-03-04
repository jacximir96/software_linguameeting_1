<?php
namespace App\Src\StudentDomain\Makeup\Service;


use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Repository\MakeupRepository;

//busca y configura información sobre makeups para una matrícula
class MakeupSearcher{

    private MakeupRepository $makeupRepository;

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    public function __construct (MakeupRepository $makeupRepository, EnrollmentSessionRepository $enrollmentSessionRepository){
        $this->makeupRepository = $makeupRepository;
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
    }

    public function searchFromEnrollment (Enrollment $enrollment):MakeupAvailability{

        $makeups = $this->makeupRepository->obtainByEnrolllment($enrollment);
        $makeupsCollection = new MakeupsCollection($makeups);

        $courseMakeup = $enrollment->course()->courseMakeup();

        $missedSessionsNum = $this->enrollmentSessionRepository->countMissedWithoutMakeup($enrollment);

        return new MakeupAvailability($makeupsCollection, $courseMakeup, $missedSessionsNum);
    }
}
